<?php
class Application_Model_Register {
	private $_dbTable;
	private $_dbOrganisme;
	public function __construct() {
		$this->_dbTable = new Application_Model_DbTable_Utilisateur ();
		$this->_dbOrganisme = new Application_Model_DbTable_Organisme ();
	}
	public function addOrganism($dataOrganism) {
		$this->_dbOrganisme->insert($dataOrganism);
		$insertID=$this->_dbOrganisme->getAdapter()->lastInsertId();
		return $insertID;
	}
	public function addRegister($array) {
		$this->_dbTable->insert($array);
		$insertID = $this->_dbTable->getAdapter()->lastInsertId();
		return $insertID;
	}
	public function loginActionPro($UserName, $UserPassword) {
		$ql = $this->_dbTable->select ()->from ( $this->_dbTable, array (
				'User_login',
				'User_password' 
		) )->where ( 'User_login=?', $UserName )->where ( 'User_password=?', $UserPassword )->where('User_Statut=?',1);
		return $this->_dbTable->fetchAll ( $ql )->toArray ();
	}
	
	// org
	public function selectProfile($UserNameget) 

	{
		$db = Zend_Db_Table::getDefaultAdapter ();
		$select = $db->select ()->from ( 'organisme' )->joinInner ( array (
				'users' => 'utilisateur' 
		), 'users.Org_Id = organisme.Org_Id' )->where ( 'User_Login=?', $UserNameget );
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
}

