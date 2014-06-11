<?php
namespace Mirrim\dao;

require_once __DIR__ . "/../model/Portrait.php" ;

use PDO ;
use Mirrim\model\Portrait ;


class mysql_portraitDao extends mysql_baseDao {
	
	// get a content item by id/version
	public function get( $id, $ver = null) {
		
		if (is_null( $ver )) $ver = 0 ;
		$obj = new Portrait();
		$result = $this->doBasicGet( $obj, $id, $ver ) ;
		return $result ;
	
	}

	public function create( $obj ) {
		
		$now = $date = date ( 'Y-m-d H:i:s' );
		$obj->created = $now ;
		$obj->modified = $now ;
		$obj = $this->doBasicCreate( $obj ) ;
		return $obj;
				
	}
	

	public function update( $obj, $norev ) {

		$now = $date = date ( 'Y-m-d H:i:s' );
		$obj->modified = $now ;
		$obj = $this->doBasicUpdate($obj, $norev) ;
		return $obj ;
		
	}
	
	public function delete( $id ) {

		$obj = new Portrait() ;
		return $this->doBasicDelete($obj, $id);
	}
	
	// get a list of content items by criteria
	public function query($offset, $limit, $preds, $order ) {
		$obj = new Portrait() ;
		
		$result = $this->doBasicQuery( $obj, $offset, $limit, $preds, $order ) ;

		return $result ;
		
	}
	
	

}


