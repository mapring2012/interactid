<?php
/**
 * @Developer Doeun
 * @Module  addnew site
 * @Company Mapring
 * @copyright 2013
 */
require_once 'Zend/function.php';
require_once 'Zend/Controller/Plugin/Abstract.php';
class SiteController extends Zend_Controller_Action {
	public $getLibBaseUrl = null;
	public $GetModelSite = null;
	public function init() {
		$this->view->controller = $this->_request->getParam ( 'controller' );
		$this->view->action = $this->_request->getParam ( 'action' );
		$this->GetModelSite = new Application_Model_ModSite ();
		// call function for dynamic sidebar
		$this->_Categories = new Application_Model_ModCatTerm ();
		$parent_id = $this->_getParam ( 'controller' );
		$this->view->secondSideBar = $this->_Categories->showCateParent ( $parent_id );
		$this->_helper->ajaxContext->addActionContext('deleteSite', 'json')->initContext();
	}
	public function indexAction() {
	   // MESSAGE ***************************
		if ($this->_getParam('success') != ''
				|| $this->_getParam('success') != null) {
			$message = $this->_getParam('success');
			if ($message == 'delete') {
				$message = 'The site has been deleted!.';
				$this->view->success = $message;
			}
            if ($message == 'update') {
				$message = 'The site has been updated!.';
				$this->view->success = $message;
			}
            if ($message == 'add') {
				$message = 'The site has been added!.';
				$this->view->success = $message;
			}
		}

		if ($this->_getParam('error') != ''
				|| $this->_getParam('error') != null) {
			$message = $this->_getParam('error');
			if ($message == 1) {
				$message = 'Your email is already in use, please put the new one';
				$this->view->error = $message;
			}			
		}
		// end MESSAGE ************************
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
			if($success=='add'){
				$message='Site is added successfully !';
				$this->view->success=$message;
			}else if($success=='update'){
				$message='Site is updated successfully !';
				$this->view->success=$message;
			}
			else if($success=="delete"){
				$message='Site is deleted successfully !';
				$this->view->success=$message;
			
			}	
			try {
				$getRecordFromSite = $this->GetModelSite->selectAllViewSiteModule ();
				if ($getRecordFromSite) {
					$this->view->getRecordFromSite = $getRecordFromSite;
				}
			} catch ( Exception $ex ) {
				echo "Message:" . $ex->getMessage ();
			}
		}
	}
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
			
			try {
				
				  $GetPosts = $this->getRequest ();
				if ($GetPosts->getPost ( 'AddSubmit' )) {
					$DataSite = array (
							'site_Name' => $GetPosts->getPost ( 'txt_sitename' ),
							'site_Description' => $GetPosts->getPost ( 'txt_sitediscription' ),
							'site_Codefunction' => $GetPosts->getPost ( 'txt_sitecodefunction' ),
							'site_Adresse1' => $GetPosts->getPost ( 'txt_siteaddress1' ),
							'site_City' => $GetPosts->getPost ( 'txt_sitecity' ),
							'site_Zipcode' => $GetPosts->getPost ( 'txt_sitezipcode' ),
							'site_Type' => $GetPosts->getPost ( 'txt_sitetype' ),
							'site_Statut' => $GetPosts->getPost ( 'txt_sitestatus' ),
							'site_Createdate' => date('d-m-Y'),
							'Com_Id' => $GetPosts->getPost ( 'txt_Company' ),
							'site_GPSLatit' => $GetPosts->getPost ( 'txt_gpslatit' ),
							'site_GPSLong' => $GetPosts->getPost ( 'txt_gpslong' ),
							'site_GPSAlt' => $GetPosts->getPost ( 'txt_gpsalt' ),
							'site_GPSDateTime' => $GetPosts->getPost ( 'txt_gpsdatetime' ),
							'site_GPSCt' => $GetPosts->getPost ( 'txt_gasct' ),
							'site_Refcode' => $GetPosts->getPost ( 'txt_referencecode' ),
							'site_Level' => $GetPosts->getPost ( 'txt_sitlevel' ),
                            'User_id' => $_SESSION['UserId'] 
					);
					
					$GetLastIdSite = $this->GetModelSite->InsertRecordToTableSite ( $DataSite );
					$lan = $this->_getParam ( 'lang' );
					$this->_redirect ( $lan . '/Site/index?success=add' );
					exit ();
					
				}else{
					$RefComType=$this->GetModelSite->SelectRefComType();
					$this->view->RefComType=$RefComType;
					
					$RefStatus=$this->GetModelSite->SelectRefStatus();
					$this->view->RefStatus=$RefStatus;
					
					$RefCode=$this->GetModelSite->SelectRefCode();
					$this->view->RefCode=$RefCode;
					
					$RefLevel=$this->GetModelSite->SelectRefLevel();
					$this->view->RefLevel=$RefLevel;
                    
                    $SelectCompany = $this->GetModelSite->selectCompanyName();
                    $this->view->CompanyName = $SelectCompany; 
					
				}
			} catch ( ErrorException $exe ) {
				echo "Message:" . $exe->getMessage ();
			}
		}
	}
	/* Starting edit of Module site */
    
    /* view site */
    public function overviewAction ()
    {
        if(!$this->CheckTransactionUser()){
            $lan = $this->_getParam ( 'lang' );
			$this->_redirect ( $lan . '/index/index' );
            exit();
        }else{
            $id =$this->_getParam ( 'id' );
            $userid =$this->_getParam ( 'userids' );
            $process =$this->_getParam ( 'actions' );
            if($process=="overview"){
                $getValueSiteView = $this->GetModelSite->selectSiteOverview($id,$userid);
                $this->view->siteView=$getValueSiteView;
            }
        }
    }
    /* end view site */
    
    
    /* for edit site */
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
			$lan = $this->_getParam ( 'lang' );
			$idForEditSite = $this->_getParam ( 'id' );
			if ($this->_getParam ( 'actions' ) == "edit") {
				$idForEditSite = $this->_getParam ( 'id' );
				$idusers       = $this->_getParam('userids');
				$SelectCompany = $this->GetModelSite->selectCompanyName();
				$this->view->CompanyName = $SelectCompany;
				$DisplayResultSite = $this->GetModelSite->SelectAllFromSite ( $idForEditSite,$idusers);
				//var_dump($DisplayResultSite);
				if ($DisplayResultSite) {
					$this->view->displayResultSite = $DisplayResultSite;
				}
			}
			if ($this->getRequest ()->getPost ( 'EditSubmit' )) {
				$GetPosts = $this->getRequest ();
				$lan = $this->_getParam ( 'lang' );
				$userid = $GetPosts->getPost ( 'idForUser' );
				//echo $userid;die();
				$id = $GetPosts->getPost ( 'siteHiddenId' );
				$editSiteData = array (
						'site_Name' => $GetPosts->getPost ( 'txt_sitename' ),
							'site_Description' => $GetPosts->getPost ( 'txt_sitediscription' ),
							'site_Codefunction' => $GetPosts->getPost ( 'txt_sitecodefunction' ),
							'site_Adresse1' => $GetPosts->getPost ( 'txt_siteaddress1' ),
							'site_City' => $GetPosts->getPost ( 'txt_sitecity' ),
							'site_Zipcode' => $GetPosts->getPost ( 'txt_sitezipcode' ),
							'site_Type' => $GetPosts->getPost ( 'txt_sitetype' ),
							'site_Statut' => $GetPosts->getPost ( 'txt_sitestatus' ),
							'site_Createdate' => date('d-m-Y'),
							'Com_Id' => $GetPosts->getPost ( 'txt_Company' ),
							'site_GPSLatit' => $GetPosts->getPost ( 'txt_gpslatit' ),
							'site_GPSLong' => $GetPosts->getPost ( 'txt_gpslong' ),
							'site_GPSAlt' => $GetPosts->getPost ( 'txt_gpsalt' ),
							'site_GPSDateTime' => $GetPosts->getPost ( 'txt_gpsdatetime' ),
							'site_GPSCt' => $GetPosts->getPost ( 'txt_gasct' ),
							'site_Refcode' => $GetPosts->getPost ( 'txt_referencecode' ),
							'site_Level' => $GetPosts->getPost ( 'txt_sitlevel' ),
                            'User_id' => $_SESSION['UserId']  
				);
				
				$this->GetModelSite->updateRecordSite ( $editSiteData, $id );
				/*if ($GetPosts->getPost ( 'txt_sitlevel' ) =="1") {
					$EditDataSubsite = array (
							'hsite_Codefunction' => $GetPosts->getPost ( 'txt_hcodefuntion' ),
							'hsite_secondaire' => $GetPosts->getPost ( 'txt_hsecondaire' ),
							'hsite_Createdate' => $GetPosts->getPost ( 'txt_hcreatedate' ),
							'hsite_Modifdate' => $GetPosts->getPost ( 'txt_hmodifydate' ) 
					);
					$this->GetModelSite->UpdateRecordToTableSubSite ( $EditDataSubsite, $id );
				}*/
				$this->_redirect ( $lan . '/Site/index?success=update' );
				exit ();
			}else{
				$RefComType=$this->GetModelSite->SelectRefComType();
				$this->view->RefComType=$RefComType;
					
				$RefStatus=$this->GetModelSite->SelectRefStatus();
				$this->view->RefStatus=$RefStatus;
					
				$RefCode=$this->GetModelSite->SelectRefCode();
				$this->view->RefCode=$RefCode;
					
				$RefLevel=$this->GetModelSite->SelectRefLevel();
				$this->view->RefLevel=$RefLevel;
                
                
				
			}
		}
	}
	/* Ending edit of Module site */
	/**
	 * Starting Delete module site*
	 */
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
			$actions = $this->_getParam ( 'actions' );
			//$this->getRequest ()->getPost ( 'process' )==1
			if ( $actions=='delete') {
				$idSite = $this->_getParam ( 'id' );
				$SuccessDelete = $this->GetModelSite->deleteSites($idSite );
				if ($SuccessDelete) {
					$this->_redirect ( $lan . '/Site/index?success=delete' );
				}
			}
			/* In cases of multiple delete */
			if ($this->getRequest ()->getPost ( 'BtnDelete' )) {
				if ($this->getRequest ()->getPost ( 'multiAction' )) {
					$idMultiDelSite = $this->getRequest ()->getPost ( 'checkRow' );
					$MultiDeleteSuccess = $this->GetModelSite->multiDeleteSite ( $idMultiDelSite );
					if ($MultiDeleteSuccess) {
						$this->_redirect ( $lan . '/Site/index?success=delete' );
					}
				}
			}
		}
	}
	/**
	 * Ending Delete module site*
	 */
	
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

