<?php 
/**
 * @Developer  Doeun
 * @Module     Type Equipement
 * @Descript Add,Edit,Update and select
 * @Company   Mapring
 * @copyright 2013
 */
class Application_Model_ModTypeEquipement{
	public $TableTypeEquipement;
	private $_tblRefCodes;
	private $_tblSite;
	private $_tblCompany;
	
	public function __construct(){
		$this->TableTypeEquipement = new Application_Model_DbTable_TypeEquipement();
		$this->_tblRefCodes = new Application_Model_DbTable_RefCodes ();
		$this->_tblSite=new Application_Model_DbTable_Site();
		$this->_tblCompany=new Application_Model_DbTable_Company();
	}
	public function SelectRefCode() {
		$sql = $this->_tblRefCodes->select ()
		->from ( $this->_tblRefCodes, array (
				"ref_code_lib",
				"ref_Code",
				"ref_Id"
		) )->where ( "ref_Num=?", "TYP001" );
		$rows =$this->_tblRefCodes->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	public function SelectSiteName() {
		$data=array ("site_Id","site_Name");
		$sql = $this->_tblSite->select ()
		->from ( $this->_tblSite,$data  );
		$rows =$this->_tblSite->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	public function SelectCompanyName() {
		$data=array ("Com_Id","Com_Name");
		$sql = $this->_tblCompany->select ()
		->from ( $this->_tblCompany,$data  );
		$rows =$this->_tblCompany->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	
	
	/*Starting select all record from table type Equipement*/
	public function GetAllRecordTypeEquipement(){
		try{
		$ql = $this->TableTypeEquipement->select()->from($this->TableTypeEquipement,array('*'));
		$rows = $this->TableTypeEquipement->fetchAll ( $ql )->toArray ();
		return (!empty($rows))?$rows:null;
		}catch (ErrorException $ex){
			echo "Message:".$ex->getMessage();
		}
	}
	/*Ending select all record from table type Equipement*/
	/*Starting add new Equipement type*/
	public function addEquipementType($dataTypeEquipement){
		try{
			$SucessAdd = $this->TableTypeEquipement->insert($dataTypeEquipement);
			if($SucessAdd){
				return true;
			}else{
			    return false;	
			}
			
		}catch(ErrorException $excep){
			echo "Message:".$excep->getMessage();
		}
	}
	/*Ending add new Equipement type*/
	/*Startind edit of equipement type*/
	public function equipementEdit($idEdit){
		try{
			$ql = $this->TableTypeEquipement->select()->from($this->TableTypeEquipement,array('*'))
			->where('Type_id = ?',$idEdit)->limit(1);
			$rows = $this->TableTypeEquipement->fetchAll ( $ql )->toArray ();
			return (!empty($rows))?$rows:null;
		}catch(ErrorException $ex){
		 echo "Message".$ex->getMessage();	
		}
	}
	/*Ending edit of equipement type*/
	/*Starting update equipement type*/
	public function saveUpdate($dataTypeEquipementUpdate,$idHidden){
		try{
		$where = $this->TableTypeEquipement->getAdapter()->quoteInto('Type_id = ?', $idHidden);
		$getRows = $this->TableTypeEquipement->update($dataTypeEquipementUpdate, $where);
		if ($getRows){
			return true;
		}else{
			return false;
		}
		}catch (ErrorException $ex){
			echo "Message".$ex->getMessage();
		}
	}
	/*Ending update equipement type*/
	/*Starting deleting typeequipement*/
	public function deleteTypeEquipement($id){
		try{
		$idDelete=$this->TableTypeEquipement->getAdapter()->quoteInto(' Type_id= ? ',$id) ;
		$successDel = $this->TableTypeEquipement->delete($idDelete);
		if($successDel){
			return true;
		}else{
		    return false;	
		}
		}catch(ErrorException $ex){
			echo "Message:".$ex->getMessage();
		}
		
	}
	/*Endingg deleting typeequipement*/
	/*starting multiple delete*/
	public function multiDelete($id){
		try{
		for($i=0;$i<count($id);$i++){
			$idLoop = $id[$i];
			$idMultiDelete=$this->TableTypeEquipement->getAdapter()->quoteInto(' Type_id= ? ',$idLoop) ;
			$successMultiDel = $this->TableTypeEquipement->delete($idMultiDelete);
		}
		
		}catch(ErrorException $ex){
			echo "Message:".$ex->getMessage();
		}
	}
	/*Ending multiple delete*/
}