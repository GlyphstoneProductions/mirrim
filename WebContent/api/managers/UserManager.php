<?php
namespace Mirrim\manager;
/** 
 * manager for user objects
 * @author breanna
 *
 */

require_once __DIR__ . "/../model/User.php";

require_once __DIR__ . "/../dao/DaoManager.php" ;
require_once __DIR__ . "/../Tuple.php" ;


use Mirrim\dao\DaoManager ;
use Mirrim\model\User ;
use Tuple ;

class UserManager {
	
	public function get( $id ) {
		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "user") ;
		
		$result = $dao->get( $id ) ;
		
		return $result ;		
	}
	
	public function query($offset, $limit, $preds, $order) {
	
		$offset = (is_null($offset))? 0 : $offset ;
		$limit = (is_null($limit))? 1000 : $limit ;
		
		// Fall back to basic list users behavior.  If preds is specified, caller is responsible for predicates.
		if( is_null($preds) || count($preds) == 0 ) {
			$preds = Tuple::parseTriTuple("") ;
		}
		
		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "user") ;
		
		$result = $dao->query( $offset, $limit, $preds, $order ) ;
		
		return $result ;

	}
	
	
	
	/**
	 * Create a new user from scratch.
	 * we are deprecating the adoption logic now.
	 * @param unknown $user        	
	 * @return unknown multitype:multitype:unknown
	 */
	public function createUser( $obj, $adopt) {
			
		// TODO: verify no duplicate name or email
		
		$user = new User() ;
		$user->load($obj) ;
		$userip = $_SERVER ['REMOTE_ADDR'];
		$user->userip = $userip ;
		
		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "user") ;
		
		$result = $dao->create( $user ) ;
		return $result ;
		
	}

	
	/**
	 * modify user information
	 * Does not modify:
	 * uuid, refid, password, created,
	 * 
	 * @param unknown $user        	
	 * @return unknown multitype:multitype:unknown
	 */
	public function updateUser($obj, $norev) {
		
		// TODO: VERIFY NO duplicate user name or email
		
		$now = $date = date ( 'Y-m-d H:i:s' );
		error_log ( "updateuser $now  norev=$norev\n", 3, '/var/tmp/php.log' );
		
		$user = new User() ;
		$user->load($obj) ;
		$userip = $_SERVER ['REMOTE_ADDR'];
		$user->userip = $userip ;
		
		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "user") ;
		
		$result = $dao->update( $user, $norev ) ;
		return $result ;
		

	}
	
	public function deleteUser( $uuid ) {
		

		$now = $date = date ( 'Y-m-d H:i:s' );
		error_log ( "delete user $uuid at $now \n", 3, '/var/tmp/php.log' );
	
		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "user") ;
		
		$user = $dao->getByUuid( $uuid ) ;
		if( $user ) {
			$dao->delete( $user->id ) ;
			return true ;
		}
		return false ;
	
		
	}
	

	private function getProp($obj, $propname, $default) {
		error_log ( "get property $propname \n", 3, '/var/tmp/php.log' );
		if (property_exists ( $obj, $propname )) {
			return $obj->$propname;
		} else {
			error_log ( "prop $propname not found \n", 3, '/var/tmp/php.log' );
			return $default;
		}
	}
	

}