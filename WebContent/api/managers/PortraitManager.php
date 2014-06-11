<?php
namespace Mirrim\manager;
/** 
 * manager for user objects
 * @author breanna
 *
 */

require_once __DIR__ . "/../model/Portrait.php";

require_once __DIR__ . "/../dao/DaoManager.php" ;
require_once __DIR__ . "/../Tuple.php" ;


use Mirrim\dao\DaoManager ;
use Mirrim\model\Portrait ;
use Tuple ;

class PortraitManager {
	
	public function get( $id ) {
		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "portrait") ;
		
		$result = $dao->get( $id ) ;
		
		return $result ;		
	}
	
	public function query($offset, $limit, $preds, $order) {
	
		$offset = (is_null($offset))? 0 : $offset ;
		$limit = (is_null($limit))? 1000 : $limit ;
		
		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "portrait") ;
		
		$result = $dao->query( $offset, $limit, $preds, $order ) ;
		return $result ;

	}
	
	public function create( $data) {

		$obj = new Portrait() ;
		$obj->load($data) ;

		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "portrait") ;

        $mgr->getDaoByName( $obj->getClassId()) ;
		
		$result = $dao->create( $obj ) ;
		return $result ;
		
	}

	public function update($data, $norev) {
		
		$obj = new Portrait() ;
		$obj->load($data) ;

		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "portrait") ;
		
		$result = $dao->update( $obj, $norev ) ;
		return $result ;
		

	}
	
	public function delete( $id ) {	
	
		$mgr = DaoManager::getInstance() ;
		$dao = $mgr->getDaoByName( "portrait") ;
		
		$dao->delete( $id ) ;
		return true ;		
	}
	


}