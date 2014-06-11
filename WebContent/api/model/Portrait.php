<?php
namespace Mirrim\model;

require_once "BaseModel.php" ;

use \Mirrim\model\BaseModel ;

class Portraits  {

	public $elements = array() ;	// array of entities selected

	public function count() {
		return count( $this->element ) ;
	}
	

}

class Portrait extends BaseModel {
	
	public function __construct() {
		$this->classid = 2 ;
	}

	public function getModelName( ) {
		return "Portrait" ;
	}
	
	public function getClassName() {
		return "Mirrim\model\Portrait" ;
	}
	
	// table class name
	public function getClassId() {
		return $this->classid ;
	}
	
	public function getTableName() {
		return "portraits" ;
	}
	
	public function getTableAlias() {
		return "pt" ;
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
		return new Portraits() ;
	}
	

}
?>