<?php
class Application_Model_Register {
	private $_dbTable;
	private $_dbCompany;
	private $_tbladminHirachieUser;
	private $_refCod;
    
	public function __construct() {
		$this->_dbTable = new Application_Model_DbTable_CUser ();
        $this->_tbladminHirachieUser = new Application_Model_DbTable_HierarchyUser ();
		$this->_dbCompany = new Application_Model_DbTable_Company ();
		$this->_refCod    = new Application_Model_DbTable_RefCodes();
	}
	public function addOrganism($dataOrganism) {
		$this->_dbCompany->insert($dataOrganism);
		$insertID=$this->_dbCompany->getAdapter()->lastInsertId();
		return $insertID;
	}
	public function addRegister($array) {
		$this->_dbTable->insert($array);
		$insertID = $this->_dbTable->getAdapter()->lastInsertId();
		return $insertID;
	}
    public function addSubUser($subUser){
        	$this->_tbladminHirachieUser->insert($subUser);
    }
	public function loginActionPro($UserName, $UserPassword) {
		$ql = $this->_dbTable->select ()->from ( $this->_dbTable, array (
				'User_login',
				'User_password',
                'User_id' 
		) )->where ( 'User_login=?', $UserName )->where ( 'User_password=?', $UserPassword )->where('User_Statut=?','Actif');
		return $this->_dbTable->fetchAll ( $ql )->toArray ();
	}
	
	// org
	public function selectProfile($UserNameget) 

	{
		$db = Zend_Db_Table::getDefaultAdapter ();
		$select = $db->select ()->from ( 'Company' )->joinInner ( array (
				'users' => 'CUser' 
		), 'users.Com_Id = Company.Com_Id' )->where ( 'User_Login=?', $UserNameget );
		$rows = $db->fetchAll ( $select );
		return $rows;
	}
	// org
	public function selectAllUsersName() {
		$sql = $this->_dbTable->select ()->from ( $this->_dbTable, array (
				'User_login','User_Mail'
		) );
		$getRows = $this->_dbTable->fetchAll( $sql )->toArray ();
		return $getRows;
	}
	
	//select for check and confirm 
	//select for check and confirm
	public function selectUsersConfirm() {
	
		$sql = $this->_dbTable->select ()->from ( $this->_dbTable, array (
				'User_Mail',
				'activated'
		) );
	
		$getRows = $this->_dbTable->fetchAll( $sql )->toArray ();
		return $getRows;
	}
	
	public function selectUsersCheck($data,$where) {
		$sql = $this->_dbTable->select ()->from ( $this->_dbTable,$data) ->where ($where );
		$getRows = $this->_dbTable->fetchAll( $sql )->toArray ();
		return $getRows;
	}
	
	public function update($data ,$where)
	{
		//$db = Zend_Db_Table::getDefaultAdapter ();
		$data = array('User_Statut' => $data);
		$where = $this->_dbTable->getAdapter()->quoteInto('activated = ?', $where);
		$getRows = $this->_dbTable->update($data, $where);
		return $getRows;
	}	
	// end select for check and confirm 
    public function updateUser($data,$where){
    	$getRows = $this->_dbTable->update($data, $where);
    	return $getRows;
    }
    public function selectForUserManagement() {
    	$data=array ('*');
    	$sql = $this->_dbTable->select ()->from ( $this->_dbTable,$data );
    	//->where ('User_login=?',$_SESSION['UserSession']);
    	$getRows = $this->_dbTable->fetchAll( $sql )->toArray ();
    	return (! empty ( $getRows )) ? $getRows : null;
    }
    
    
    public function addAdminUser($adminuser) {
			$this->_dbTable->insert($adminuser);
			$LastIdInsert = $this->_dbTable->getAdapter ()->lastInsertId ();
		return $LastIdInsert;
	}
	public function addToHirachieUser($dataAddHirachieUser) {
		$getHirachie = $this->_tbladminHirachieUser ->insert ( $dataAddHirachieUser );
		return $getHirachie;
	}
	public function SelectComId() {
		$sql = $this->_dbCompany->select ()
		->from ( $this->_dbCompany, array ("Com_Id","Com_Name") );
		return $this->_dbCompany->fetchAll ( $sql )->toArray ();
	}
    /*Select all reference code*/
	public function selectReferenceCode(){
		$sql = $this->_refCod->select()
		->from( $this->_refCod,array('*'))
		->where('ref_Num=?','COM002');
		return $this->_refCod->fetchAll ( $sql )->toArray ();
	}
	/*Ending all reference code*/
	/*Select selectReferenceCompanyType*/
	public function selectReferenceCompanyType(){
		$sql = $this->_refCod->select()
		->from( $this->_refCod,array('*'))
		->where('ref_Num=?','COM001');
		return $this->_refCod->fetchAll ( $sql )->toArray ();
	}
	/*Ending of selecting selectReferenceCompanyType*/
	/*Starting select sex*/
	public function selectSex(){
		$sql = $this->_refCod->select()
		->from( $this->_refCod,array('*'))
		->where('ref_Num=?','USR001');
		return $this->_refCod->fetchAll ( $sql )->toArray ();
	}
	/*Ending select sex*/
	/*Starting select code function*/
	public function selectCodeFunction(){
		$sql = $this->_refCod->select()
		->from( $this->_refCod,array('*'))
		->where('ref_Num=?','USR005');
		return $this->_refCod->fetchAll ( $sql )->toArray ();
	}
	/*Ending select code function*/
	/*Starting user status*/
	public function selectUserStatus(){
		$sql = $this->_refCod->select()
		->from( $this->_refCod,array('*'))
		->where('ref_Num=?','USR002');
		return $this->_refCod->fetchAll ( $sql )->toArray ();
	}
	/*Ending user status*/
	/*Starting select userReference code*/
	public function selectUserRecode(){
	$sql = $this->_refCod->select()
	->from( $this->_refCod,array('*'))
	->where('ref_Num=?','USR003');
	return $this->_refCod->fetchAll ( $sql )->toArray ();
	}
	/*Ending select*/ 
	/*Starting user level*/
	public function selectUserLevel(){
		$sql = $this->_refCod->select()
		->from( $this->_refCod,array('*'))
		->where('ref_Num=?','USR004');
		return $this->_refCod->fetchAll ( $sql )->toArray ();
	}
	/*Ending user level*/
    
    /*** Select Company Level ***/
    public function selectCompanyLevel(){
        $sql = $this->_refCod->select()
        ->from( $this->_refCod,array('*'))
        ->where('ref_Num=?','COM004');
        return $this->_refCod->fetchAll($sql)->toArray();
    }    
    /*** End Select Company Level ***/
    
    /*** select company name ***/
    public function selectCompany(){
        $sql = $this->_dbCompany->select()
        ->from($this->_dbCompany,array('*'));
        return $this->_dbCompany->fetchAll($sql)->toArray();
    }
    /*** End select company name ***/
    
    public function deleteUserAdmin($idUser){	
    	try{
    		$idUserwhere = $this->_dbTable->getAdapter ()->quoteInto ( 'User_id = ?', $idUser );
    		$idUser= $this->_dbTable->delete ( $idUserwhere );
    	if($idUser){
    			return true;
    		}else{
    			return false;
    		}
    	}catch(ErrorException $ex){
    		echo "Message:".$ex->getMessage();
    	}
    }
    public function selectionEditUser($id){
    	$data=array ('*');
    	$sql = $this->_dbTable->select ()->from ( $this->_dbTable,$data )
    	->where('User_id=?',$id);
    	$getRows = $this->_dbTable->fetchAll( $sql )->toArray ();
    	return (! empty ( $getRows )) ? $getRows : null;
    	
    }
   /*Update user account*/
    public function updateUserInadmin($id, $AdminUserData){
    	try{
    		$idEdit=$this->_dbTable->getAdapter()->quoteInto('User_id= ? ',$id) ;
    		$this->_dbTable->update($AdminUserData, $idEdit);
    	}catch(ErrorException $ex){
    		echo "Message:".$ex->getMessage();
    	}
    }
    /*Ending update user account*/
    /*Starting of select overview of user*/
    public function userOverView($OverID){
    	$sql = $this->_dbTable->select()
    	->from( $this->_dbTable,array('*'))
    	->where('User_id=?',$OverID);
    	return $this->_dbTable->fetchAll($sql)->toArray();
    }
    /*Ending of selecting overview of user*/
    
}