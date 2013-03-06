<?php
/**
 * @Developer  Doeun
 * @Module     Type Equipement
 * @Descript   Add,Edit,Update and select
 * @Company   Mapring
 * @copyright 2013
 */
require_once 'Zend/Controller/Plugin/Abstract.php';
require_once 'Zend/function.php';
class TypeequipementController extends Zend_Controller_Action {
	public $ModTypeEquipements = null;
	public function init() {
		/* Initialize action controller here */
		$this->view->controller = $this->_request->getParam ( 'controller' );
		$this->view->action = $this->_request->getParam ( 'action' );
		// call function for dynamic sidebar
		$this->_Categories = new Application_Model_ModCatTerm ();
		$parent_id = $this->_getParam ( 'controller' );
		$this->view->secondSideBar = $this->_Categories->showCateParent ( $parent_id );
		$this->ModTypeEquipements = new Application_Model_ModTypeEquipement ();
		
		
		$this->_helper->ajaxContext->addActionContext('deleteTypeEquipement', 'json')->initContext();
	}
	public function indexAction() {
		if (! $this->CheckTransactionUser ()) {
			try {
				Zend_Session::start ();
				$lan = $this->_getParam ( 'lang' );
				$this->_redirect ( $lan . '/index/index' );
				throw new ErrorException ( "No Permission for accessing this page" );
				exit ();
			} catch ( Zend_Session_Exception $e ) {
				echo "Message:" . $e->getMessage ();
				session_start ();
			}
		} else {
			
			$success=$this->_getParam ( 'success' );
			
			//$success1=['success'];
			if($success=='add'){
				$message='Type Equipement is added successfully !';
				$this->view->success=$message;
			}else if($success=='update'){
				$message='Type Equipement is updated successfully !';
				$this->view->success=$message;
			}
			else if($success=='delete'){
				$message='Type Equipement is deleted successfully !';
				$this->view->success=$message;
			}
			
			try {
				$getResult = $this->ModTypeEquipements->GetAllRecordTypeEquipement ();
				$this->view->PassResultToview = $getResult;
			} catch ( ErrorException $exerror ) {
				echo "Message:" . $exerror->getMessage ();
			}
		}
	}
	/* Starting adding new for typeEquipement */
	public function addAction() {
		if (! $this->CheckTransactionUser ()) {
			try {
				Zend_Session::start ();
				$lan = $this->_getParam ( 'lang' );
				$this->_redirect ( $lan . '/index/index' );
				throw new ErrorException ( "No Permission for accessing this page" );
				exit ();
			} catch ( Zend_Session_Exception $e ) {
				echo "Message:" . $e->getMessage ();
				session_start ();
			}
		} else {
			$dataTypeEquipement = array ();
			$GetPost = $this->getRequest ();
			$lan = $this->_getParam ( 'lang' );
			if ($GetPost->getPost ( 'BtnAddNew' )) {
				//$dateNow = $GetPost->getPost('txtdatecreate');
				$dataTypeEquipement = array (
						'Type_name' => $GetPost->getPost ( 'txttypename' ),
						'Type_description' => $GetPost->getPost ( 'txttypedescription' ),
						'Type_ref' => $GetPost->getPost ( 'txtreference' ),
						'Type_createdate' => date('d-m-Y'),
						'site_Id'=>$GetPost->getPost ( 'txtisitename' ),
						'Com_Id'=>$GetPost->getPost ( 'txtcompanyname' ) 
				);
				$InsertSuccess = $this->ModTypeEquipements->addEquipementType ( $dataTypeEquipement );
				if ($InsertSuccess) {
					$this->_redirect ( $lan . '/typeequipement/index?success=add' );
					exit ();
				}
			}else{
				$RefCode= $this->ModTypeEquipements->SelectRefCode();
				$this->view->RefCode=$RefCode;
				$siteName=$this->ModTypeEquipements->SelectSiteName();
				$this->view->siteName=$siteName;
				$CompanyName=$this->ModTypeEquipements->SelectCompanyName();
				$this->view->CompanyName=$CompanyName;
			}
		}
	}
	/* Ending Adding new for typeEquipement */
    /*Starting edit equipement*/
    public function editAction() {
		if (! $this->CheckTransactionUser ()) {
			try {
				Zend_Session::start ();
				$lan = $this->_getParam ( 'lang' );
				$this->_redirect ( $lan . '/index/index' );
				throw new ErrorException ( "No Permission for accessing this page" );
				exit ();
			} catch ( Zend_Session_Exception $e ) {
				echo "Message:" . $e->getMessage ();
				session_start ();
			}
		} else {
			try {
				$lan = $this->_getParam ( 'lang' );
				if ($this->_getParam ( 'process' ) == "edit" && $this->_getParam ( 'id' )) {
					$RefCode=$this->ModTypeEquipements->SelectRefCode();
					$this->view->RefCode=$RefCode;
					
					$siteName=$this->ModTypeEquipements->SelectSiteName();
					$this->view->siteName=$siteName;
					$CompanyName=$this->ModTypeEquipements->SelectCompanyName();
					$this->view->CompanyName=$CompanyName;
					
					$idEdit = $this->_getParam ( 'id' );
					$successEdit = $this->ModTypeEquipements->equipementEdit ($idEdit );
					$this->view->displayEditEquipement = $successEdit;
					
				}
				if ($this->getRequest ()->getPost ( 'BtnEdit' )) {
					$GetPost = $this->getRequest ();
					//$dateNow = $GetPost->getPost('txtdatecreate');
					$idHidden = $GetPost->getPost ( 'editHidden' );
					$dataTypeEquipementUpdate = array (
							'Type_name' => $GetPost->getPost ( 'txttypename' ),
							'Type_description' => $GetPost->getPost ( 'txttypedescription' ),
							'Type_ref' => $GetPost->getPost ( 'txtreference' ),
							'Type_modifdate' => date('d-m-Y'),
							'site_Id'=>$GetPost->getPost ( 'txtisitename' ),
							'Com_Id'=>$GetPost->getPost ( 'txtcompanyname' )   
					);
					
					$editSuccess = $this->ModTypeEquipements->saveUpdate ( $dataTypeEquipementUpdate, $idHidden );
					if ($editSuccess) {
						$this->_redirect ( $lan . '/typeequipement/index?success=update' );
						exit ();
					}
				}
			} catch ( ErrorException $ex ) {
				echo "Message" . $ex->getMessage ();
			}
		}
	}
	/* Ending edit of equipement */
    /*Starting delete equipement of type*/
    public function deleteAction() {
		if (! $this->CheckTransactionUser ()) {
			try {
				Zend_Session::start ();
				$lan = $this->_getParam ( 'lang' );
				$this->_redirect ( $lan . '/index/index' );
				throw new ErrorException ( "No Permission for accessing this page" );
				exit ();
			} catch ( Zend_Session_Exception $e ) {
				echo "Message:" . $e->getMessage ();
				session_start ();
			}
		} else {
			$lan = $this->_getParam ( 'lang' );
			$process = $this->_getParam ( 'process' );
			if ($process=='delete') {
				$id = $this->_getParam ( 'id' );
				$sucessDelete = $this->ModTypeEquipements->deleteTypeEquipement ( $id );
				if ($sucessDelete) {
					$this->_redirect ( $lan . '/typeequipement/index?success=delete' );
					exit ();
				}
			}
			if ($this->getRequest ()->getPost ( 'BtnApply' )) {
				$id = $this->getRequest ()->getPost ( 'checkRow' );
				$multiSucess = $this->ModTypeEquipements->multiDelete ( $id );
				$this->_redirect ( $lan . '/typeequipement/index?success=delete' );
				exit ();
			}
		}
	}
	/* Ending delete equipement of type */
    /* Starting function check session */
    public function CheckTransactionUser() {
		if (isset ( $_SESSION ['UserSession'] )) {
			return true;
		} else {
			return false;
		}
	}
	/* Ending function check session */
}

