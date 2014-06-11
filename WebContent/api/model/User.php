<?php
namespace Mirrim\model;

require_once "BaseModel.php" ;

use \Mirrim\model\BaseModel ;

class Users  {

	public $elements = array() ;	// array of entities selected

	public function count() {
		return count( $this->element ) ;
	}
	

}

class User extends BaseModel {
	
	public function __construct() {
		$this->classid = 1 ;
	}

	public function getModelName( ) {
		return "User" ;
	}
	
	public function getClassName() {
		return "Mirrim\model\User" ;
	}
	
	// table class name
	public function getClassId() {
		return $this->classid ;
	}
	
	public function getTableName() {
		return "users" ;
	}
	
	public function getTableAlias() {
		return "u" ;
	}
	
	public function getDefaultOrderCol() {
		return "created" ;
	}
	
	public function getDefaultOrderDir() {
		return "DESC" ;
	}
	
	public function getIsVersioned() {
		return false ;
	}
	
	public function getIsMappable() {
		return false ;
	}
	
	/* return a new instance of the collection object 
	 * 
	 */
	public function getCollection() {
		return new Users() ;
	}
	

}
?>