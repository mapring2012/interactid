<?php
require_once 'Zend/function.php';
require_once 'Zend/Controller/Plugin/Abstract.php';
class AccountController extends Zend_Controller_Action {
	public $getLibBaseUrl = null;
	private $_registerDb = null;
	public function init() {
	   $this->view->controller = $this->_request->getParam ( 'controller' );
		$this->view->action = $this->_request->getParam ( 'action' );
		$this->view->assign ( 'actions', 'account' );
		$this->_registerDb = new Application_Model_Register ();
		$this->getLibBaseUrl = new Zend_View_Helper_BaseUrl (); 
	}
	public function indexAction() {
		// action body
	}
	public function recoveryAction() {
		if ($this->getRequest ()->getPost ( 'txtemail' )) {
			// select in (activated)
			$data = array (
					'activated',
					'User_Firstname',
					'User_Mail' 
			);
			// select where (User_Mail=xxxx@gamil.com)
			$where = "User_Mail='" . $this->getRequest ()->getPost ( 'txtemail' ) . "'";
			$formMail = $this->getRequest ()->getPost ( 'txtemail' );            
			$lan = $this->_getParam ( 'lang' );
			$getTableUse = $this->_registerDb->selectUsersCheck ( $data, $where );
			$base = "http://" . $_SERVER ["SERVER_NAME"] . $this->getLibBaseUrl->baseUrl ();
			foreach ( $getTableUse as $reRow ) {
				$name = $reRow ['User_Firstname'];
				$User_active = $reRow ['activated'];
				$User_Mail = $reRow ['User_Mail']; 
                echo $formMail;               
				if ($User_Mail == $formMail) {
					$lan = $this->_getParam ( 'lang' );
					$GetPost = $this->getRequest ();
					require_once 'Zend/SendEmail.php';
					$sendemail = new SendEmail ();
					$header = "Interactid reset your password <contact@interactid.com>";
					$subjects = "Hello";
					$BodyHeader = "RESET NEW PASSWORD!";
					$BodyMessage = 'Click on this link to reset your password: <a href="' . $base . '/' . $lan . '/account/resetpw?email=' . $formMail . '&confirm=' . $User_active . '">Confirm!</a>';
					$sendemail = $sendemail->SendMail ( $name, $User_Mail, $base, $header, $subjects, $BodyHeader, $BodyMessage );
					$this->_redirect ( $lan . '/index/index?success=1' );
				} else {
                    $this->_redirect ( $lan . '/index/index?success=3' );
				}
			}
		}
	}
	public function resetpwAction() {
		$lan = $this->_getParam ( 'lang' );
		$GetMail = $this->_getParam ( "email" );
		$this->view->getEmail = $GetMail;
		$GetConfirm = $this->_getParam ( 'confirm' );
		if ($GetMail != "" && $GetConfirm != "") {
			$data = '*';
			$where = "User_Mail='" . $this->_getParam ( "email" ) . "'";
			$getTableUse = $this->_registerDb->selectUsersCheck ( $data, $where );
			foreach ( $getTableUse as $reRow ) {
				$accitve = $reRow ['activated'];
				if ($accitve == $GetConfirm) {
					$this->view->confirm = $GetConfirm;
				} else {
					$this->_redirect ( $lan . '/index/index?success=4' );
				}
			}
		} else {
			$this->_redirect ( $lan . '/index/index?success=4' );
		}
	}
	public function newpasswordAction() {
		$lan = $this->_getParam ( 'lang' );
		$getPostReset = $this->getRequest ();
		if ($getPostReset->getPost ( 'SubmitAddNewPassword' )) {
			$PasswordReset = $getPostReset->getPost ( 'PasswordReset' );
			$ConfirmPasswordReset = $getPostReset->getPost ( 'ConfirmPasswordReset' );
			if ($PasswordReset == $ConfirmPasswordReset) {
				$email = $this->getRequest ()->getPost ( 'GetEmail' );
				$confirm = $this->getRequest ()->getPost ( 'confirm' );
				if ($email) {
					$data = array (
							'User_password' => $PasswordReset 
					);
					$where = "User_Mail='" . $email . "'";
					$es = $this->_registerDb->updateUser ( $data, $where );
					if ($es) {
						$this->_redirect ( $lan . '/index/index?success=5' );
					} else {
						$this->_redirect ( $lan . '/index/index?success=4' );
					}
				}
			} else {
				$this->_redirect ( $lan . '/account/resetpw?email' . $email . '=&confirm=' . $confirm . '&success=4' );
			}
		}
	}
}