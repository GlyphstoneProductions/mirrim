<?php
// Main entry point for mirrim utilties api

require 'vendor/autoload.php';

use Slim\Slim ;
use Guzzle\Http\Client;

session_start() ;
$app = new \Slim\Slim();
$app->contentType('application/json');
// -------------------------------------
// Routes
$app->get( '/ping', 'ping');
$app->get( '/echo/:message', 'callecho') ;	
$app->get( '/test/struct', 'getstruct');
$app->get( '/blog/latest', 'getLatestBlogPost') ;
$app->run();


function ping() {
	echo "Mirrim ping\n" ;
}

function callecho( $message) {
	echo "Echo $message";
}

function getstruct() {
	$obj = new stdClass() ;
	$obj->name = "Mirrim";
	$obj->business = "3D Portraits";	
	$obj->slogan = "Your mirror image" ;
	$obj->founded = "2014";
	$obj->founder = "Breanna Anderson" ;
	
	echo json_encode($obj);
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