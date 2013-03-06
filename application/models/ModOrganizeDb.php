<?php
class Application_Model_ModOrganizeDb {
	private $_DbRefCodes;
	public $_TblCompany;
	private $_TblHirachieCompany;
	private $_TblCUser;
	private $_TblHirachieUser;

	public function __construct() {
		$this->_DbRefCodes = new Application_Model_DbTable_RefCodes ();
		$this->_TblCompany = new Application_Model_DbTable_Company ();
		$this->_TblHirachieCompany = new Application_Model_DbTable_HierarchieOrganisme ();
		$this->_TblCUser = new Application_Model_DbTable_CUser ();
		$this->_TblHirachieUser = new Application_Model_DbTable_HierarchyUser ();
	
	}
	public function SelectRefLevel() {
		$sql = $this->_DbRefCodes->select ()
		->from ( $this->_DbRefCodes, array (
				"ref_code_lib",
				"ref_Code",
				"ref_Description"
		) )->where ( "ref_Num=?", "SIT004" )->order('ref_Code ASC');
		$rows = $this->_DbRefCodes->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	public function SelectRefStatus() {
		$sql = $this->_DbRefCodes->select ()
		->from ( $this->_DbRefCodes, array (
				"ref_code_lib",
				"ref_Code",
				"ref_Description"
		) )->where ( "ref_Num=?", "SIT001" )->order('ref_Code ASC');
		$rows =$this->_DbRefCodes->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	public function SelectRefCode() {
		$sql = $this->_DbRefCodes->select ()->from ( $this->_DbRefCodes, array (
				"ref_code_lib",
				"ref_Code",
				"ref_Description" 
		) )->where ( "ref_Num=?", "SIT002" )->order('ref_Code ASC');
		return $this->_DbRefCodes->fetchAll ( $sql )->toArray ();
	}
	public function SelectRefComType() {
		$sql = $this->_DbRefCodes->select ()->from ( $this->_DbRefCodes, array ("ref_code_lib",
				"ref_Code",
				"ref_Description" 
		) )->where ( "ref_Num=?", "SIT003" )->order('ref_Code ASC');
		$rows = $this->_DbRefCodes->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	public function SelectRefCodeFunction() {
		$sql = $this->_DbRefCodes->select ()->from ( $this->_DbRefCodes, array ("ref_code_lib",
				"ref_Code",
				"ref_Description"
		) )->where ( "ref_Num=?", "COM001" )->order('ref_Code ASC');
		$rows = $this->_DbRefCodes->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
	}
	
	public function addSubUser($subUser){
		$this->_TblHirachieUser->insert($subUser);
	}
	
	public function InsertRecordToCompany($dataAddCompany) {
		$this->_TblCompany->insert ( $dataAddCompany );
		$LastIdInsert = $this->_TblCompany->getAdapter ()->lastInsertId ();
		return $LastIdInsert;
	}
	public function InsertRecodeToHierachieCompany($dataAddHirachieCompany) {
		$hirachieCom = $this->_TblHirachieCompany->insert ( $dataAddHirachieCompany );
		return $hirachieCom;
	}
	
	public function InsertRecordToUser($dataAddUser) {
		$this->_TblCUser->insert ( $dataAddUser );
		$rowsUserLastId = $this->_TblCUser->getAdapter ()->lastInsertId ();
		return $rowsUserLastId;
	}
	public function InsertRecordToHirachieUser($dataAddHirachieUser) {
		$getHirachie = $this->_TblHirachieUser->insert ( $dataAddHirachieUser );
		return $getHirachie;
	}
	public function AdvandeSearch($id){
		try{
			$search=array("Com_Refcode","Com_RaisonSocial","Com_City");
			$sql = $this->_TblCompany->select ()->from ( $this->_TblCompany,$search)->where ("Com_RaisonSocial like ?",$id."%");
			$rows = $this->_TblCompany->fetchAll ( $sql )->toArray ();
			return (! empty ( $rows )) ? $rows : null;
		}catch (ErrorException $ex){
			echo "MessageError".$ex->getMessage();
		}
		
	}
	public function CompareComparenameAndEmail() {
		$data=array ('Com_Name','Com_Mail');
		$sql = $this->_TblCompany->select ()->from ( $this->_TblCompany, $data);
		$getRows = $this->_TblCompany->fetchAll( $sql )->toArray ();
		return $getRows;
	}
	
	// select all data from company,HirachieCompany,CUser,HirachieUser table for
	// Organisme menu
	public function selectAllDataForOrganismeMenu() {
			$db = Zend_Db_Table::getDefaultAdapter ();
            $data=array("comid"=>"hor.Com_Id");
    		 $select = $db->select ()-> distinct()->from (array('com'=>'Company'))
    		->joinInner (array('hor'=>'HierarchyUser'),'com.Com_Id= hor.Com_Id',$data )
    		->joinInner (array('user'=>'CUser'),'hor.User_id= user.User_id' )
    		->where('user.User_id=?',$_SESSION['UserId']);
     	 /*$select = $db->select ()->from (array('com'=>'Company') )
    		->joinInner (array('hor'=>'HierarchieOrganisme'),'com.Com_Id= hor.Com_Id' ); */
			//	->joinInner ( array ('ref' => 'RefCodes' ), 'ref.ref_Id=com.Com_Refcode' )
			//	->joinInner ( array ('hus' => 'HierarchyUser' ), 'user.User_id=hus.User_id' );
		$rows = $db->fetchAll ( $select );
		return (! empty ( $rows )) ? $rows : null;
	}
	//Starting of selecting  data to update on form in Organisme menu
	
	public function SelectEditOrganisme($idEdit){
		try{
			$db = Zend_Db_Table::getDefaultAdapter ();
			$select = $db->select ()->from (array('com'=>'Company') )
    		->joinInner (array('hor'=>'HierarchyUser'),'com.Com_Id= hor.Com_Id' )
    		->joinInner (array('horOrg'=>'HierarchieOrganisme'),'com.Com_Id= horOrg.Com_Id' )
			->where('com.Com_Id=?',$idEdit);
			/*->joinInner (array('hor'=>'HierarchieOrganisme'),'com.Com_Id= hor.Com_Id' )
			 ->joinInner (array('ref'=>'RefCodes'),'ref.ref_Id=com.Com_Refcode' )
			->joinInner (array('hus'=>'HierarchyUser' ),'user.User_id=hus.User_id' ) ; */
			$rows = $db->fetchAll ($select );
			return (!empty($rows))?$rows:null;
			throw new Exception('Can not select!');
			
			/*$select = $db->select ()->from (array('com'=>'Company') )
			->joinInner (array('hor'=>'HierarchieOrganisme'),'com.Com_Id= hor.Com_Id' )
			->where('com.Com_Id=?',$idEdit);*/
		}catch (ErrorException $e){
			echo "Message:".$e->getMessage();
		}
	}
	 
	//Ending of seleting
	/*Select overview edit*/
	public function SelectOverViewEdit( $idEdit,$idUser ){
	
		try{
			$db = Zend_Db_Table::getDefaultAdapter ();
			$select = $db->select ()->from (array('com'=>'Company') )
    		->joinInner (array('hor'=>'HierarchyUser'),'com.Com_Id= hor.Com_Id' )
    		->joinInner (array('user'=>'CUser'),'hor.User_id= user.User_id' )
    		->where('user.User_id=?',$idUser)
			->where('com.Com_Id=?',$idEdit);
			/*->joinInner (array('hor'=>'HierarchieOrganisme'),'com.Com_Id= hor.Com_Id' )
			 ->joinInner (array('ref'=>'RefCodes'),'ref.ref_Id=com.Com_Refcode' )
			->joinInner (array('hus'=>'HierarchyUser' ),'user.User_id=hus.User_id' ) ; */
			$rows = $db->fetchAll ($select );
			return (!empty($rows))?$rows:null;
			throw new Exception('Can not select!');
		}catch (ErrorException $e){
			echo "Message:".$e->getMessage();
		}
	}
	/*Ending overview edit*/
	
	// Starting delete data from company,HirachieCompany,CUser,HirachieUser table
	
	public function deleteAllDataFromOrganismeMenu($id) {
		
		$idCompany = $this->_TblCompany->getAdapter ()->quoteInto ( 'Com_Id = ?', $id );
		$idParent = $this->_TblCompany->delete ( $idCompany );
		
		$idHOrganisme = $this->_TblHirachieCompany->getAdapter ()->quoteInto ( 'Com_Id = ?', $id );
		$HOrganisme = $this->_TblHirachieCompany->delete ( $idHOrganisme );
		
		 $idCUser = $this->_TblCUser->getAdapter ()->quoteInto ( 'Com_Id = ?', $id );
		$CUser = $this->_TblCUser->delete ( $idCUser ); 
		
		$idHUser = $this->_TblHirachieUser->getAdapter ()->quoteInto ( 'Com_Id = ?', $id );
		$HUser = $this->_TblHirachieUser->delete ( $idHUser );
		
		if ($idParent ) {
			return true;
		} else {
			return false;
		}
	}
	/*
	 * @Developer: Doeun
	 * Module    : Delete image from folder
	 */
	public function unlinkImagesFromFolderById($id){
		try{
		$sql = $this->_TblCompany->select ()->from ( $this->_TblCompany, array (
				"Com_Logo"
		) )->where ("Com_Id=?",$id);
		$rows = $this->_TblCompany->fetchAll ( $sql )->toArray ();
		return (! empty ( $rows )) ? $rows : null;
		}catch (ErrorException $ex){
			echo "MessageError".$ex->getMessage();
		}
	}
	//End of deleting 
	
	/*
	 * @module : mulitple delete
	 * @Deloper: Doeun
	 */
	public function multipledelete($idCount){
		//print_r($idCount);
	   // $id = (is_array($idCount))?implode(',',$idCount):$idCount;
	    for($i=0;$i<count($idCount);$i++){
	    	$id =$idCount[$i];
	    	$whereMulti = $this->_TblCompany->getAdapter ()->quoteInto ( 'Com_Id = ?', $id );
	    	$this->_TblCompany->delete ( $whereMulti );
	    	
	    	$idHOrganisme = $this->_TblHirachieCompany->getAdapter ()->quoteInto ( 'Com_Id = ?', $id );
	    	$HOrganisme = $this->_TblHirachieCompany->delete ( $idHOrganisme );
	    	
	    	 $idCUser = $this->_TblCUser->getAdapter ()->quoteInto ( 'Com_Id = ?', $id );
	    	$CUser = $this->_TblCUser->delete ( $idCUser );
	    	
	    	$idHUser = $this->_TblHirachieUser->getAdapter ()->quoteInto ( 'Com_Id = ?', $id );
	    	$HUser = $this->_TblHirachieUser->delete ( $idHUser ); 
	    }
	}
	

 
    	
    	//update HirachieCompany table by Com_Id  column
    	public function UpdateRecordHirachieCompany($fielnames,$idEdit){
    		$idEdit=$this->_TblHirachieCompany->getAdapter()->quoteInto(' Com_Id= ? ',$idEdit) ;
    		$this->_TblHirachieCompany->update($fielnames, $idEdit);
    	}
    	//update CUser table by Com_Id  column
    	public function UpdateRecordCUser($fielnames,$idEdit){
    		$idEdit=$this->_TblCUser->getAdapter()->quoteInto(' Com_Id= ? ',$idEdit) ;
    		$this->_TblCUser->update($fielnames, $idEdit);
    	}
    	//update HirachieUser table by Com_Id  column
    	public function UpdateRecordHirachieUser($fielnames,$idEdit){
    		$idEdit=$this->_TblHirachieUser->getAdapter()->quoteInto(' Com_Id= ? ',$idEdit) ;
    		$this->_TblHirachieUser->update($fielnames, $idEdit);
    	}
    	//updata company table by Com_Id  column
    	public function UpdateRecordCompany($dataUpdateCompany,$id){
    		$idEdit=$this->_TblCompany->getAdapter()->quoteInto(' Com_Id= ? ',$id) ;
    		$row=$this->_TblCompany->update($dataUpdateCompany, $idEdit);
    		return $row;
    	}
    	
}//end class