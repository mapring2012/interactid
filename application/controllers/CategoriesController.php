<?php
/**
 * @developer Socheat
 * @Module  addnew site
 * @Company Mapring
 * @copyright 2013
 */

require_once 'Zend/function.php';
require_once 'Zend/Controller/Plugin/Abstract.php';
class CategoriesController extends Zend_Controller_Action {
	private $_Categories = NULL;
	public function init() {
		$this->view->controller = $this->_request->getParam ( 'controller' );
		$this->view->action = $this->_request->getParam ( 'action' );
		$this->_Categories = new Application_Model_ModCatTerm ();
		
		// call function for dynamic sidebar
		$parent_id = $this->_getParam ( 'controller' );
		$this->view->secondSideBar = $this->_Categories->showCateParent ( $parent_id );
	}
	public function indexAction() {
		$GetPost = $this->getRequest ();
		if ($GetPost->getPost ( 'CateSubmit' )) {
			$insertCat = array (
					'name' => $GetPost->getPost ( 'txtcateName' ),
					'slug' => $GetPost->getPost ( 'txtslugName' ) 
			);
			$insertdata = $this->_Categories->insertcat ( $insertCat );
		}
		
		// show categories
		$this->view->Categories = $this->_Categories->showCateAll ();
		$this->view->CategorieList = $this->_Categories->showCateInList ();
		$ifparent = $GetPost->getPost ( 'cboParent' );
		if (! empty ( $ifparent )) {
			if ($ifparent) {
				$insertTax = array (
						'term_id' => $insertdata,
						'taxonomy' => 'category',
						'parent' => $GetPost->getPost ( 'cboParent' ) 
				);
				$inserttax = $this->_Categories->insertTax ( $insertTax );
			}
		}
	}
}

