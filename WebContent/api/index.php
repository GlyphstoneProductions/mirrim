<?php
// Main entry point for mirrim utilties api

require 'vendor/autoload.php';
require 'managers/UserManager.php' ;
require 'managers/PortraitManager.php' ;

use Slim\Slim ;
use Guzzle\Http\Client;
use Mirrim\manager\UserManager ;
use Mirrim\manager\PortraitManager ;

session_start() ;
$app = new \Slim\Slim();
$app->contentType('application/json');
// -------------------------------------
// Routes
$app->get( '/ping', 'ping');
$app->get( '/blog/latest', 'getLatestBlogPost') ;
$app->get( '/users', 'queryUsers' ) ;
$app->get( '/users/:id', 'getUser');
$app->get( '/portraits', 'queryPortraits') ;
$app->get( '/portraits/:id', 'getPortrait') ;
$app->post( '/portraits', 'createPortrait');
$app->put( '/portraits','updatePortrait') ;
$app->delete( '/portraits/:id', 'deletePortrait');
$app->run();


function ping() {
	echo "Mirrim ping\n" ;
}


//blog.mirrim3d.com/node.json?type=blog&author=3&status=1&sort=created&direction=DESC&limit=1
function getLatestBlogPost() {

	$client = new Client('http://blog.mirrim3d.com');
	
	$request = $client->get('/node.json?type=blog&author=3&status=1&sort=created&direction=DESC&limit=1');
	$request->setAuth('restws_access', 'R3mot3');

	$response = $request->send();
	
	$data = $response->json();
	$encoded = $response->getBody();
	//echo $encoded ;
	//var_dump($data);
	
	$bloglist = $data["list"] ;
	
	$blogpost = new stdClass() ;
	if( is_array( $bloglist ) && count($bloglist) > 0 ) {
		$bptemp = $bloglist[0] ;
		$title = $bptemp["title"] ;
		$body = $bptemp["body"]["value"];
		$summary = $bptemp["body"]["summary"];
		$blogpost->title = $title ;
		$body = str_replace( 'src="/', 'src="http://blog.mirrim3d.com/', $body);
		$blogpost->body = $body ;
		
		$blogpost->summary = $summary ;
	} else {
		$blogpost->title = "Welcome to Mirrim 3D Portraits" ;
		$blogpost->body = "Follow our blog at blog.mirrim3d.com" ;
		$blogpost->summary = "The finest in 3d portraits" ;		
	}
	echo json_encode($blogpost) ;
}

function queryUsers() {
	
	$start = microtime() ;
	$mgr = new UserManager() ;
	$request = Slim::getInstance()->request();
	$offset = $request->get( "offset" ) ;
	$limit = $request->get("limit") ;
	$preds = Tuple::parseTriTuple($request->get("preds")) ;
	$order = Tuple::parseTuple( $request->get("order")) ;
	$result = $mgr->query($offset, $limit, $preds, $order) ;
	send( $result, $start ) ;
}

function getUser($id) {
	$start = microtime() ;
	$mgr = new UserManager() ;
	$result = $mgr->get($id ) ;
	send( $result, $start ) ;
}


function queryPortraits() {

	$start = microtime() ;
	$mgr = new PortraitManager() ;
	$request = Slim::getInstance()->request();
	$offset = $request->get( "offset" ) ;
	$limit = $request->get("limit") ;
	$preds = Tuple::parseTriTuple($request->get("preds")) ;
	$order = Tuple::parseTuple( $request->get("order")) ;
	$result = $mgr->query($offset, $limit, $preds, $order) ;
	send( $result, $start ) ;
}

function getPortrait($id ) {
	$start = microtime() ;
	$mgr = new PortraitManager() ;
	$result = $mgr->get($id ) ;
	send( $result, $start ) ;	
}

function createPortrait() {
	
	$start = microtime() ;
	$request = Slim::getInstance()->request();
	$data = json_decode($request->getBody());
	$mgr = new PortraitManager() ;
	$result = $mgr->create( $data ) ;
	send( $result , $start) ;
}

function updatePortrait() {

	$start = microtime() ;
	$request = Slim::getInstance()->request();
	$data = json_decode($request->getBody());
	$norev = $request->params("norev") ;
	$mgr = new PortraitManager() ;
	$result = $mgr->update( $data, $norev ) ;
	send( $result, $start) ;

}

function deletePortrait($id) {
	$start = microtime() ;
	$request = Slim::getInstance()->request();
	$mgr = new PortraitManager() ;
	send( $mgr->delete($id) , $start) ;
}

function send( $result, $start ) {
	$elapsed = microtime() - $start ;
	header( "Content-Type: application/json") ;
	echo json_encode($result) ;

}
