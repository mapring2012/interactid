<?php
// session_start();
require_once 'Zend/function.php';
require_once 'Zend/Controller/Plugin/Abstract.php';
class IndexController extends Zend_Controller_Action {
	public $getLibBaseUrl;
	private $_registerDb = NULL;

	// public $sendemail;
	public function init() {

		/* Initialize action controller here */
		$this->view->controller = $this->_request->getParam('controller');
		$this->view->action = $this->_request->getParam('action');
		$this->view->assign('actions', 'index');
		$this->_registerDb = new Application_Model_Register();

		$this->getLibBaseUrl = new Zend_View_Helper_BaseUrl();

		//call function for dynamic sidebar
		$this->_Categories = new Application_Model_ModCatTerm();
		$parent_id = $this->_getParam('controller');
		$this->view->secondSideBar = $this->_Categories
				->showCateParent($parent_id);

		$getCompanyName = $this->_registerDb->SelectComId();
		$this->view->getCompanyName = $getCompanyName;

		$this->getLibBaseUrl = new Zend_View_Helper_BaseUrl();

		// call function for dynamic sidebar
		$this->_Categories = new Application_Model_ModCatTerm();
		$parent_id = $this->_getParam('controller');
		$this->view->secondSideBar = $this->_Categories
				->showCateParent($parent_id);

	}
	// this is function for login
	public function indexAction() {
		// MESSAGE ***************************
		if ($this->_getParam('success') != ''
				|| $this->_getParam('success') != null) {
			$message = $this->_getParam('success');
			if ($message == 1) {
				$message = 'Your account has been activated! please login below.';
				$this->view->success = $message;
			}
			if ($message == 2) {
				$message = 'Your account is already activated! please login below.';
				$this->view->success = $message;
			}
			if ($message == 3) {
				$message = 'You email does not have in interactid account.';
				$this->view->success = $message;
			}
			if ($message == 4) {
				$message = 'Your account can not reset new password, please try to reset again!.';
				$this->view->success = $message;
			}
			if ($message == 5) {
				$message = 'Your account has been set the new password, you can login below!.';
				$this->view->success = $message;
			}
            if ($message == 6) {
				$message = "L'activation de votre compte a bien été envoyé à votre adresse email.";
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
			if ($message == 2) {
				$message = 'Your Username is already in use, please put the new one';
				$this->view->error = $message;
			}
		}
		// end MESSAGE ************************
		// action body
		if ($this->getRequest()->getPost('BtnSubmit')) {
			$UserName = "";
			$UserName = $this->getRequest()->getPost('User_login');
			$UserPassword = $this->getRequest()->getPost('User_password');
			if ($UserName != "" && @$UserPassword != "") {
				$result = $this->_registerDb
						->loginActionPro($UserName, $UserPassword);
				foreach ($result as $column => $value) {
					$UserNames = $value['User_login'];
					$UserId = $value['User_id'];
					$PassWords = $value['User_password'];
				}
				if (@$UserNames == $UserName) {
					$_SESSION['UserSession'] = $UserNames;
					$_SESSION['UserId'] = $UserId;
					$_SESSION['User_Passwords'] = $PassWords;
					if ($this->getRequest()->getPost('txtRemember')
							== "autoLogin") {
						setcookie("cookname", $_SESSION['UserSession'],
								time() + 60, "/");
						setcookie("cookpass", $_SESSION['User_Passwords'],
								time() + 60, "/");
					}
					$lan = $this->_getParam('lang');
					$this->_redirect($lan . '/index/dashboard');
					return;
				} else {
					// $this->view->Login = '';
					$_SESSION['errorIn'] = "ErrorIncorrect";
				}
			} else {
				// $this->view->Login = '';
				$_SESSION['errorBlank'] = "ErrorBlacnk";
			}
		}
	}

	// sellect users
	public function tableuser() {
		$getTableUser = $this->_registerDb->selectAllUsersName();
		return $getTableUser;
	}
	// this is function for register user
	// end user
	public function registerAction() {
	   // MESSAGE ***************************
		if ($this->_getParam('success') != ''
				|| $this->_getParam('success') != null) {
			$message = $this->_getParam('success');
			if ($message == 1) {
				$message = 'Your account has been activated! please login below.';
				$this->view->success = $message;
			}
			if ($message == 2) {
				$message = 'Your account is already activated! please login below.';
				$this->view->success = $mess=age;
			}
			if ($message == 3) {
				$message = 'Your email does not have in interactid account.';
				$this->view->success = $message;
			}
			if ($message == 4) {
				$message = 'Your account can not reset new password, please try to reset again!.';
				$this->view->success = $message;
			}
		}

		if ($this->_getParam('error') != ''
				|| $this->_getParam('error') != null) {
			$message = $this->_getParam('error');
			if ($message == 1) {
				$message = "Votre e-mail est déjà en cours d'utilisation, s'il vous plaît mettez la nouvelle";
				$this->view->error = $message;
			}
			if ($message == 2) {
				$message = "Votre nom d'utilisateur est déjà utilisé, s'il vous plaît mettez le nouveau.";
				$this->view->error = $message;
			}
		}
		// end MESSAGE ************************
		$getReferenceCode = $this->_registerDb->selectReferenceCode();
		$this->view->getReferenceCode = $getReferenceCode;
		$getReferenceCodeCompanyType = $this->_registerDb
				->selectReferenceCompanyType();
		$this->view->getReferenceCodeCompanyType = $getReferenceCodeCompanyType;
		$getgender = $this->_registerDb->selectSex();
		$this->view->getgender = $getgender;
		$getCodeFunction = $this->_registerDb->selectCodeFunction();
		$this->view->getCodeFunction = $getCodeFunction;
        
        $getUserLevel = $this->_registerDb->selectUserLevel();
        $this->view->getUserLevel = $getUserLevel;
        
        $getCompanyLevel = $this->_registerDb->selectCompanyLevel();
        $this->view->getCompanyLevel = $getCompanyLevel;

		$base = "http://" . $_SERVER["SERVER_NAME"]
				. $this->getLibBaseUrl->baseUrl();
		if ($this->getRequest()->getPost('SubscriptSubmit')) {
			foreach ($this->tableuser() as $reRows) {
				$UserNames = $reRows['User_login'];
				$userEmail = $reRows['User_Mail'];

				if ($UserNames
						== $this->getRequest()->getPost('txtusername')) {
					$_SESSION['duplicateUserName'] = "<p style='color:red;'>UserName can not duplicated</p>";
					$lan = $this->_getParam('lang');
					$this->_redirect($lan . '/index/register?error=2');
					exit();
				} else if ($userEmail
						== $this->getRequest()->getPost('txtemail')) {
					$_SESSION['duplicateUserEmail'] = "<p style='color:red;'>UserEmail can not duplicated</p>";
					$lan = $this->_getParam('lang');
					$this->_redirect($lan . '/index/register?error=1');
					exit();
				}
			}
			$dataAdd = array();
			$GetPost = $this->getRequest();
			require_once 'Zend/ResizeClassImage.php';
			$fname = isset($_FILES['fileupload']['name']) ? $_FILES['fileupload']['name']
					: '';
			$fsize = $_FILES['fileupload']['size'];
			$ftmp = $_FILES['fileupload']['tmp_name'];
			$ftype = $_FILES['fileupload']['type'];
			$getCodGeneration = self::RandomActiveMail();
			$image = new ResizeClassImage();
			$baseUpload = $this->basePathUpload();
			if ($fname == '' || $fname == false) {
				$dataOrganism = array(
						'Com_Name' => $GetPost->getPost('txtcompanyname'),
						'Com_RaisonSocial' => $GetPost
								->getPost('txtcompanyraisonsocial'),
						'Com_Siret' => $GetPost->getPost('txtcompanysiret'),
						'Com_VAT' => $GetPost->getPost('txtvat'),
						'Com_Logo' => '',
						'Com_Address1' => $GetPost->getPost('txtaddress1'),
						'Com_ZipCode' => $GetPost->getPost('txtzipcode'),
						'Com_City' => $GetPost->getPost('txtcity'),
						'Com_Country' => $GetPost->getPost('txtcountry'),
						'Com_Telephone' => $GetPost->getPost('txtofficephone'),
						'Com_Type' => $GetPost->getPost('txtcompanytype'),
                        'Com_createdate' => date('d-m-Y'),
						'Com_Refcode' => $GetPost->getPost('txtcompanyreference')
                        );
				$LastID = $this->_registerDb->addOrganism($dataOrganism);
				$dataAdd = array(
						'User_login' => $GetPost->getPost('txtusername'),
						'User_password' => $GetPost->getPost('txtpassword'),
						'User_Firstname' => $GetPost->getPost('txtfirstname'),
						'User_Lastname' => $GetPost->getPost('txtlastname'),
						'User_titre' => $GetPost->getPost('txttitle'),
						'User_fonction' => $GetPost->getPost('txtfunction'),
						'User_Mobilephone' => $GetPost->getPost('txtphone'),
						'User_Mail' => $GetPost->getPost('txtemail'),
                        'User_createdate' => date('d-m-Y'),
						'User_level' => $GetPost->getPost('txtuserlevel'), 
                        'Com_Id' => $LastID,
						'activated' => $getCodGeneration);
			    $lastIdUser = $this->_registerDb->addRegister($dataAdd);
                $subUser = array(
                   'User_id'=>$lastIdUser,
                   'Com_Id'=>$LastID);
                      $this->_registerDb->addSubUser($subUser);
			} else {
				$check_type = $image->checkType($ftype); // check file type
				$check_size = $image->checkSize($fsize); // check file size
				if (true == $check_type) {
					if (true == $check_size) {
						$image->load($ftmp);
						$image->resize(500, 500);
						// resize to width = 500px and height =500p
						if (file_exists($baseUpload . '/' . $fname)) {
							$fname = $image->random(5) . '-' . $fname;
							$image->save($baseUpload . '/' . $fname); // =
							// move_upload_file()
							// create
							// thumbnail
							$image->resize(70, 70);
							$image->save($baseUpload . '/thumb/' . $fname);
						} else {
							$image->save($baseUpload . '/' . $fname); // =
							// move_upload_file()
							// create
							// thumbnail
							$image->resize(70, 70);
							$image->save($baseUpload . '/thumb/' . $fname);
						}
						$dataOrganism = array(
								'Com_Name' => $GetPost->getPost('txtcompanyname'),
								'Com_RaisonSocial' => $GetPost->getPost('txtcompanyraisonsocial'),
								'Com_Siret' => $GetPost	->getPost('txtcompanysiret'),
								'Com_VAT' => $GetPost->getPost('txtvat'),
								'Com_Logo' => $fname,
								'Com_Address1' => $GetPost->getPost('txtaddress1'),
								'Com_ZipCode' => $GetPost->getPost('txtzipcode'),
								'Com_City' => $GetPost->getPost('txtcity'),
								'Com_Country' => $GetPost->getPost('txtcountry'),
								'Com_Telephone' => $GetPost->getPost('txtofficephone'),
								'Com_Type' => $GetPost->getPost('txtcompanytype'),
                                'Com_level' => $GetPost->getPost('txtcompanylevel'),
                                'Com_createdate' => date('d-m-Y'),
								'Com_Refcode' => $GetPost->getPost('txtcompanyreference')
                                );
						$LastID = $this->_registerDb->addOrganism($dataOrganism);
						$dataAdd = array(
								'User_login' => $GetPost->getPost('txtusername'),
								'User_password' => $GetPost->getPost('txtpassword'),
								'User_Firstname' => $GetPost->getPost('txtfirstname'),
								'User_Lastname' => $GetPost->getPost('txtlastname'),
								'User_titre' => $GetPost->getPost('txttitle'),
								'User_fonction' => $GetPost->getPost('txtfunction'),
                                'User_level' => $GetPost->getPost('txtuserlevel'),
								'User_Mobilephone' => $GetPost->getPost('txtphone'),
                                'User_createdate' => date('d-m-Y'),
								'User_Mail' => $GetPost->getPost('txtemail'),
								'Com_Id' => $LastID,
								'activated' => $getCodGeneration);
					$lastIdUser=$this->_registerDb->addRegister($dataAdd);
                        $subUser = array(
                   'User_id'=>$lastIdUser,
                   'Com_Id'=>$LastID);
                      $this->_registerDb->addSubUser($subUser);
					}
				} // check_type
			}
			$lan = $this->_getParam('lang');

			require_once 'Zend/SendEmail.php';
			$sendemail = new SendEmail();
			$name = $GetPost->getPost('txtfirstname')
					. $GetPost->getPost('txtlastname');
			$email = $GetPost->getPost('txtemail');
			$header = "Interactid active your account <contact@interactid.com>";
			$subjects = "Hello";
			$activeAccount = "ACTIVE YOUR ACCOUNT NOW!";
			$BodyAccountActive = 'Click on this link to activate your account: <a href="'
					. $base . '/' . $lan . '/index/confirm?email=' . $email
					. '&activated=' . $getCodGeneration . '">Active Now!</a>';
			$sendemail = $sendemail->SendMail($name, $email, $base, $header, $subjects,$activeAccount, $BodyAccountActive);
             if($sendemail){
                echo $sendemail;
             }else{
                try{
                    
                }catch(ErrorException $ex){
                    echo "".$ex->getMessage();
                }
               
               
                
             }
        

			$this->_redirect($lan . '/index/index?success=6');
		}
	}

	/* this is function for generating active account register */
	static function RandomActiveMail($length = 50) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	// this is function for open new dashboard
	public function dashboardAction() {
		$this->view->render('sidebar.phtml');
		// this is body of function
		if (!$this->checkSession()) {
			$lan = $this->_getParam('lang');
			$this->_redirect($lan . '/index');
			exit();
		} else {
			$UserNameget = $_SESSION['UserSession'];
			$getResultProfile = $this->_registerDb
					->selectProfile($UserNameget);
			// $this->view->getResultProfile = $getResultProfile;
			$this->view->baseImage = $this->basePathUpload();

			// for user image
			foreach ($getResultProfile as $values) {
				$_SESSION["Logo"] = $values['Com_Logo'];
			}
		}
	}

	// this is function for logout
	public function logoutAction() {
		$SessionName = $_SESSION['UserSession'];
		if ($this->checkSession()) {
			unset($SessionName);
			session_destroy();
			$lan = $this->_getParam('lang');
			$this->_redirect($lan . '/index/index');
			exit();
		}
	}

	// this is function for get basepath upload images
	public function basePathUpload() {
		$pathupload = realpath(APPLICATION_PATH . '/../public/data/uploads');
		return $pathupload;
	}
	public function confirmAction() {
		// for check
		$GetMail = $this->_getParam("email");
		// select all (*)
		$data = '*';
		//$data=array ('User_login','User_Mail');
		$where = "User_Mail='" . $this->_getParam("email") . "'";

		$GetActive = $this->_getParam('activated');
		$lan = $this->_getParam('lang');
		$getTableUse = $this->_registerDb->selectUsersCheck($data, $where);
		foreach ($getTableUse as $reRow) {
			$User_Statut = $reRow['User_Statut'];
			if ($User_Statut == 0) {
				$getTableUser = $this->_registerDb->selectUsersConfirm();
				foreach ($getTableUser as $reRows) {
					$User_Mail = $reRows['User_Mail'];
					$activated = $reRows['activated'];

					if ($User_Mail == $GetMail && $activated == $GetActive) {
						$udate = $this->_registerDb->update('actif', $GetActive);
						$this->_redirect($lan . '/index/index?success=1');
					}
				}
			} else {
				$this->_redirect($lan . '/index/index?success=2');
			}
		}
	}
	public function administratorAction() {
		
		
		// MESSAGE ***************************
		if ($this->_getParam('success') != ''
				|| $this->_getParam('success') != null) {
			$message = $this->_getParam('success');
			if ($message == 1) {
				$message = 'This account has been insert and aready sent email to confirm.';
				$this->view->success = $message;
			}else if($message=="delete"){
				$message = 'User account had been deleted!';
				$this->view->success = $message;
			}else if($message=="update"){
				$message = 'User account had been updated!';
				$this->view->success = $message;
			}
			
		}
	 if (!$this->checkSession()) {
        	$this->redirectToIndex();
        
        }else {
        	try {
			$userManagement = $this->_registerDb->selectForUserManagement();
			$this->view->userManagement = $userManagement;
		} catch (ErrorException $ex) {
			echo "Message Error:" . $ex->getMessage();
		}
		// end MESSAGE ************************
 
	   }
    
	}
	
    
    /*************** add new user by Socheat *************/
	/**/
	public function overviewAction(){
		  try{
		  	if (!$this->checkSession()) {
		  		$this->redirectToIndex();
		  	
		  	} else {
		  		$process = $this->_getParam("process");
		  		$OverID  = $this->_getParam("id");
		  		 if($process=="overview"){
		  		   $UserOverView = $this->_registerDb->userOverView($OverID);
		  		   //var_export($UserOverView);
		  		   $this->view->UserOverView=$UserOverView;
		  		 }
		  	}
		  }catch (ErrorException $ex){
		  	echo "Message:".$ex->getMessage();
		  }
	}
	/**/
    public function adduserAction()
    {
    	/*Starting message*/
    	if ($this->_getParam('error') != ''
    			&& $this->_getParam('error') != null) {
    		$message = $this->_getParam('error');
    		if ($message == 1) {
    			$message = 'This email is already in use, please put the new one';
    			$this->view->error = $message;
    		}
    		if ($message == 2) {
    			$message = 'This Username is already in use, please put the new one';
    			$this->view->error = $message;
    		}
    	} 
    	/*Ending messages*/
  		$Usertitle = $this->_registerDb->selectSex();
		$this->view->usertitle=$Usertitle;
		$UserFunction = $this->_registerDb->selectCodeFunction();
		$this->view->selectCodeFunction=$UserFunction;
		$UserStatus = $this->_registerDb->selectUserStatus();
		$this->view->Userstatus=$UserStatus;
		$UserRefCode = $this->_registerDb->selectUserRecode();
		$this->view->UserRefCode=$UserRefCode;
		$UserLevel = $this->_registerDb->selectUserLevel();
		$this->view->UserLevel=$UserLevel;
        $selectCompany = $this->_registerDb->selectCompany();
        $this->view->selectCompany=$selectCompany;
        

        if (!$this->checkSession()) {
        	$this->redirectToIndex();
        
        } else {
        
        	try {
        		$adminuser = array();
        		$dataAddHirachieUser = array();
        		$GetPost = $this->getRequest();
        		if ($GetPost->getPost('btnSave')) {
        			// for check
        			$GetMail = $GetPost->getPost('users_mail');
        			$UserLogin = $GetPost->getPost('users_name');
        			// select all (*)
        			//$data         = '*';
        			$data = array('User_login', 'User_Mail');
        			$where = "User_Mail='" . $GetMail . "' OR User_login='". $UserLogin . "'";
        			$getTableUse = $this->_registerDb->selectUsersCheck($data, $where);
        			foreach ($getTableUse as $reRow) {
        				$User_Mail = $reRow['User_Mail'];
        				$Username = $reRow['User_login'];
        				if (($User_Mail == $GetMail)|| ($Username == $UserLogin)) {
        					$lan = $this->_getParam('lang');
        					if ($User_Mail == $GetMail) {
        						$this->_redirect($lan. '/index/adduser/?error=1');
        					}
        					if ($Username == $UserLogin) {
        						$this->_redirect($lan. '/index/adduser/?error=2');
        					}
        
        				}
        			}
        			$getCodGeneration = self::RandomActiveMail();
        			$photoProfile = "profile_photo.jpg";
        			$adminuser = array(
        					'User_login' => $GetPost->getPost('users_name'),
        					'User_password' => $GetPost->getPost('txtpassword'),
        					'User_titre' => $GetPost->getPost('users_title'),
        					'User_fonction' => $GetPost->getPost('users_fonction'),
        					'User_Lastname' => $GetPost->getPost('users_lastname'),
        					'User_Firstname' => $GetPost->getPost('users_firstname'),
        					'User_Mobilephone' => $GetPost->getPost('users_mobilephone'),
        					'User_Officephone' => $GetPost->getPost('users_officephone'),
        					'User_Mail' => $GetPost->getPost('txtemail'),
        					'User_Statut' => $GetPost->getPost('users_statut'),
        					'User_createdate' => date('d-m-Y'),
        					'User_Refcode' => $GetPost->getPost('users_refcode'),
        					'User_level' => $GetPost->getPost('users_level'),
        					'Com_Id' => $GetPost->getPost('comId'),
        					'User_Photo'=>$photoProfile,
        					'activated' => $getCodGeneration);
        			$GetLastUserId = $this->_registerDb->addAdminUser($adminuser);
        			//for send mail to confirm
        			$lan = $this->_getParam('lang');
        			$base = "http://" . $_SERVER["SERVER_NAME"]. $this->getLibBaseUrl->baseUrl();
        			require_once 'Zend/SendEmail.php';
        			$sendemail = new SendEmail();
        			$name = $GetPost->getPost('users_firstname');
        			$header = "Interactid active your account <contact@interactid.com>";
        			$subjects = "Hello";
        			$BodyHeader = "ACTIVE YOUR ACCOUNT NOW!";
        			$BodyMessage = 'Click on this link to activate your account: <a href="'. $base . '/' . $lan . '/index/confirm?email='
        					. $GetMail . '&activated=' . $getCodGeneration
        					. '">Active Now!</a>';
        			$sendemail = $sendemail->SendMail($name, $GetMail, $base, $header,$subjects, $BodyHeader, $BodyMessage);
        			$this->_redirect($lan . '/index/administrator?success=1');
        			exit();
        			//end check
        		}
        		//end from btnSave
        
        	} catch (ErrorException $ex) {
        		echo "Message Error:" . $ex->getMessage();
        
        	}
        	try {
        		$userManagement = $this->_registerDb->selectForUserManagement();
        		$this->view->userManagement = $userManagement;
        	} catch (ErrorException $ex) {
        		echo "Message Error:" . $ex->getMessage();
        	}
        }
    }
    /************* end add new user by Socheat ***********/
    
	/*Starting of delete action in index controller*/
	public function deleteAction() {
		if (!$this->checkSession()) {
			$this->redirectToIndex();
		} else {
			$lan = $this->_getParam('lang');
			$id = $this->_getParam('id');
			$process=$this->_getParam('process');
			//$this->getRequest()->getPost("process") ==1
			if ($process =='delete') {
				$sucess = $this->_registerDb->deleteUserAdmin($id);
				if ($sucess == TRUE) {
					$this->_redirect($lan . '/index/administrator?success=delete');
					exit();
				}
			}
			if ($this->getRequest()->getPost("BtnApply")) {
				if ($this->getRequest()->getPost("multiAction")) {
					$id = $this->getRequest()->getPost('checkRow');
					$this->_registerDb->multiDeleteUser($id);
					$this->_redirect($lan . '/index/administrator');
					exit();
				}
			}
		}
	}
	/*Ending of delete action in index controller*/

	/*Starting of editting user in adminstrator*/
	public function editAction() {
		if (!$this->checkSession()) {
			$this->redirectToIndex();
		} else {
			if ($this->_getParam('process') == "edit") {
				$id = $this->_getParam('id');
				$gettingUserList = $this->_registerDb->selectionEditUser($id);
				$this->view->gettingUserLists = $gettingUserList;
				
				$Usertitle = $this->_registerDb->selectSex();
				$this->view->usertitle=$Usertitle;
				$UserFunction = $this->_registerDb->selectCodeFunction();
				$this->view->selectCodeFunction=$UserFunction;
				$UserStatus = $this->_registerDb->selectUserStatus();
				$this->view->Userstatus=$UserStatus;
				$UserRefCode = $this->_registerDb->selectUserRecode();
				$this->view->UserRefCode=$UserRefCode;
				$UserLevel = $this->_registerDb->selectUserLevel();
				$this->view->UserLevel=$UserLevel;
			}

			if ($this->getRequest()->getPost("btnSaveUpdate")) {
				$id = $this->getRequest()->getPost("idHidden");
				$lan = $this->_getParam('lang');
				$GetPost = $this->getRequest();
				$AdminUserData = array();
				$dataAddHirachieUser = array();
				require_once 'Zend/ResizeClassImage.php';
				$fname = isset ( $_FILES ['fileupload'] ['name'] ) ? $_FILES ['fileupload'] ['name'] : '';
				$fsize = $_FILES ['fileupload'] ['size'];
				$ftmp = $_FILES ['fileupload'] ['tmp_name'];
				$ftype = $_FILES ['fileupload'] ['type'];
				$image = new ResizeClassImage ();
				$baseUpload = $this->basePathUpload ();
				if ($fname == "" || $fname == false) {
					$AdminUserData = array(
							'User_login' => $GetPost->getPost('users_name'),
							'User_password' => $GetPost->getPost('users_password'),
							'User_titre' => $GetPost->getPost('users_title'),
							'User_fonction' => $GetPost->getPost('users_fonction'),
							'User_Lastname' => $GetPost->getPost('users_lastname'),
							'User_Firstname' => $GetPost
							->getPost('users_firstname'),
							'User_Mobilephone' => $GetPost
							->getPost('users_mobilephone'),
							'User_Officephone' => $GetPost
							->getPost('users_officephone'),
							'User_Mail' => $GetPost->getPost('users_mail'),
							'User_Statut' => $GetPost->getPost('users_statut'),
							'User_modifdate' => date('d-m-Y'),
							'User_Refcode' => $GetPost->getPost('users_refcode'),
							'User_level' => $GetPost->getPost('users_level'));
					$this->_registerDb->updateUserInadmin($id, $AdminUserData);
				}else{
					$check_type = $image->checkType ( $ftype ); // check
					// file
					// type
					$check_size = $image->checkSize ( $fsize ); // check
					// file
					// size
					if (true == $check_type) {
						if (true == $check_size) {
							$image->load ( $ftmp );
							$image->resize ( 500, 500 );
							// resize to width = 500px and
							// height =500p
							if (file_exists ( $baseUpload . '/' . $fname )) {
								$fname = $image->random ( 5 ) . '-' . $fname;
								$image->save ( $baseUpload . '/' . $fname ); // =
								// move_upload_file()
								// create
								// thumbnail
								$image->resize ( 70, 70 );
								$image->save ( $baseUpload . '/thumb/' . $fname );
							} else {
								$image->save ( $baseUpload . '/' . $fname ); // =
								// move_upload_file()
								// create
								// thumbnail
								$image->resize ( 70, 70 );
								$image->save ( $baseUpload . '/thumb/' . $fname );
							}
							
							$AdminUserData = array(
									'User_login' => $GetPost->getPost('users_name'),
									'User_password' => $GetPost->getPost('users_password'),
									'User_titre' => $GetPost->getPost('users_title'),
									'User_fonction' => $GetPost->getPost('users_fonction'),
									'User_Lastname' => $GetPost->getPost('users_lastname'),
									'User_Firstname' => $GetPost
									->getPost('users_firstname'),
									'User_Mobilephone' => $GetPost
									->getPost('users_mobilephone'),
									'User_Officephone' => $GetPost
									->getPost('users_officephone'),
									'User_Mail' => $GetPost->getPost('users_mail'),
									'User_Statut' => $GetPost->getPost('users_statut'),
									'User_modifdate' => date('d-m-Y'),
									'User_Refcode' => $GetPost->getPost('users_refcode'),
									'User_level' => $GetPost->getPost('users_level'),
							        'User_Photo'=>$fname);
							$this->_registerDb->updateUserInadmin($id, $AdminUserData);
						}
					}
				}
				
				$this->_redirect($lan . "/index/administrator?success=update");
                exit();
			}
		}
	}
	/*Ending of editing user in administrator*/
	public function redirectToIndex() {
		$lan = $this->_getParam('lang');
		$this->_redirect($lan . '/index');
		exit();
	}

	// this is function for check session
	private function checkSession() {
		$SessionName = $_SESSION['UserSession'];
		if (isset($SessionName)) {
			return $SessionName;
		}
	}

}//close class

