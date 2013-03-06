<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
    protected function _initAutoload(){
    	$moduleLoader= new Zend_Application_Module_Autoloader(array(
    			'namespace'=>'',
    			'basePath'=>APPLICATION_PATH
    			));

    return $moduleLoader;		
    	
    }
    /**
     * @access for languages
     */
    public function _initRoutes(){
    	$frontController=Zend_Controller_Front::getInstance();
    	$router=$frontController->getRouter();
    	$router->setGlobalParam('lang','fr');
    	$router->removeDefaultRoutes();
    	$router->addRoute('langmodcontrolleraction',new  Zend_Controller_Router_Route('/:lang/:module/:controller/:action',
    			 array('lang'=>':lang')));
    	$router->addRoute('langcontrolleraction',new  Zend_Controller_Router_Route('/:lang/:controller/:action',
    			array('lang'=>':lang')));
    	$router->addRoute('langindex',new  Zend_Controller_Router_Route('/:lang',
    			array('lang'=>':lang',
    				  'module'=>'default',
    				  'controller'=>'index',
    				  'action'=>'index')
    			
    			));
    	$router->addRoute('langcontroller',new  Zend_Controller_Router_Route('/:lang/:controller',
    			array('lang'=>':lang',	
    				'module'=>'default',
    				'controller'=>'index',
    				'action'=>'index')
    	));
    }

	
	/**
	 * Global setup
	 * @access public static
	 * @return null
	 */
	public static function setup()
	{
		self::setupConfig();
		self::setupEnvironment();
		self::setupFrontController();
		self::setupView();
		self::setupDatabase();
	}
	
	/**
	 * Setup Database
	 * @access public static
	 * @return null
	 */
	public static function setupDatabase() {
		My_Controller_Plugin_Doctrine::setupDoctrine();
		self::setupFirePHP(Zend_Registry::get('config')->debug);
		My_Controller_Plugin_Doctrine::setupSession();
	
		// or if you don't need database in Bootstrap
		// self::$frontController->registerPlugin(new My_Controller_Plugin_Doctrine());
	}
	protected function _initSidebar()
	{
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->placeholder('sidebar');
	}
}

