<?php
namespace Mirrim\dao;

require_once __DIR__ . "/../model/User.php" ;

use PDO ;
use Mirrim\model\User ;


class mysql_userDao extends mysql_baseDao {
	
	// get a content item by id/version
	public function get( $id, $ver = null) {
		
		if (is_null( $ver )) $ver = 0 ;
		$obj = new User();
		$result = $this->doBasicGet( $obj, $id, $ver ) ;
		return $result ;
		/*
			
		$sql = "select * FROM users u WHERE u.id = :id ";

		try {
			$db = $this->getConnection ();
					
			$stmt = $db->prepare ( $sql );
				
			$stmt->bindParam ( "id", $id , PDO::PARAM_INT);
			$stmt->execute ();
			$user = $stmt->fetchObject( "Mirrim\model\User" );
			$db = null;
			return $user;
		} catch ( PDOException $e ) {

			$message = $e->getMessage ();
			echo "Error! $message\n" ;
			return array (
					"Error" => array (
							"text" => $message
					)
			);
		}
		*/
	}


	/**
	 * Not supported
	 * @param unknown $user
	 * @return NULL
	 */
	public function create( $user ) {
		
		error_log ( "add new user\n", 3, '/var/tmp/php.log' );
		/*
		$password = $this->getProp ( $user, "password", null );
		if (! is_null ( $password )) {
			$cryptpass = md5 ( $password );
		}
		$user->password = $cryptpass ;
		$user->refuser = 0;
		
		$refuserid = $this->getProp ( $user, "refuserid", null );
		if (! empty ( $refuserid )) {
			$referringuser = $this->getByRefId ( $refuserid );
			if (! is_null ( $referringuser )) {
				$user->refuser = intval ( $referringuser->id );
			}
		}
	
		$user = $this->doBasicCreate( $user ) ;
		
		// for now fill in usercache table with lat/long
		// TODO: Merge Usercache into user table for simplicity
		
		$usercache = $this->createUserCache ( $user->id, $user->countrycode, $user->zipcode, $user->userip );
		$user->latitude = $usercache->latitude;
		$user->longitude = $usercache->longitude;
		$user->locupdate = true ;	// flag front end that location has been set/updated

		return $user ;
		*/
		return null ;
			
	}
	
	/**
	 * Not supported
	 * @param unknown $user
	 * @param unknown $norev
	 * @return NULL
	 */
	public function update( $user, $norev ) {
		
		return null ;
	
		
	}
	
	/**
	 * Not supported
	 * @param unknown $id
	 * @return boolean
	 */
	public function delete( $id ) {

		return false ;
	}
	
	// get a list of content items by criteria
	public function query($offset, $limit, $preds, $order ) {
		$obj = new User() ;
		
		$result = $this->doBasicQuery( $obj, $offset, $limit, $preds, $order ) ;
		// remove sensitive information
		$output = array() ;
		foreach( $result->elements as $user ) {
			$user->password = "" ;
			$user->salt = "" ;
			$new_password_key = "" ;
			$new_password_requested = "" ;
			$new_email = "" ;
			$new_email_key = "" ;	
			$output[] = $user ;
		}
		return $output ;
		
	}
	
	// ==============================================================================================================
	// Use Generic Logic from base DAO
	/*
	protected function getSelection( $tableAlias ) {
		//return ' * ' ;
		$select = " ci.id, us.ver, ci.thisver, ci.classid, ccl.name as 'classname', ci.status, cst.name as 'statusname', cst.ispublished as 'ispublished', us.uuid, us.refid, us.username, ci.created, us.modified, us.refuser, us.refuserid, us.email, us.zipcode, ";
		$select .= " us.countrycode, us.usertype, us.userstatus, us.userclass, us.mecon, us.userip, us.staylogged, us.notes, us.emailvalidatedon, us.communications, us.notifications, us.usermessages, us.emailresettoken, c.latitude, c.longitude, c.usersetloc  ";
		return $select ;
	}
	
	protected function getFrom( $tableName, $tableAlias ) {
		//return "FROM $tableName $tableAlias" ;
		return "FROM cinst ci join user us on ci.id = us.id join cclass ccl on ci.classid = ccl.id join cstatus cst on ci.status = cst.id left outer join usercache c on us.id = c.id " ;
	}
	*/
	

}

