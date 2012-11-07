<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initNamespaces()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('AI_');
    }

	protected function _initAutoload()
	{
		$moduleLoader = new Zend_Application_Module_Autoloader(array(
			'namespace' => '',
			'basePath' => APPLICATION_PATH));
		
        //$autoloader = Zend_Loader_Autoloader::getInstance();
        //$autoloader->setFallbackAutoloader(true);	
		
		return $moduleLoader;
	}

}
