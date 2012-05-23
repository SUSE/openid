<?php
/* Ensure we have PATH_SEPARATOR defined */
if (!defined('PATH_SEPARATOR')) {
	if (isset($_ENV['OS']) && strpos($_ENV['OS'], 'Win') !== false ) {
		define('PATH_SEPARATOR', ';');
	} else {
		define('PATH_SEPARATOR', ':');
	}
}

/* Utility function to add to the include path */
function add_include_path ()
{
	foreach (func_get_args() as $path) {
		if (!is_dir($path)) {
			trigger_error("Include path '$path' does not exist or is not a directory", E_USER_WARNING);
		}
		$paths = explode(PATH_SEPARATOR, get_include_path());
		 
		if (array_search($path, $paths) === false) {
			array_push($paths, $path);
		}
		set_include_path(implode(PATH_SEPARATOR, $paths));
	}
}
function exception_handler($exception) {
	$exceptionString = print_r($exception, true);
	getLogger()->log("Uncaught Exception: ".$exception->getMessage(), Zend_Log::ERR);
	getLogger()->log("Exception Output: ".$exceptionString, Zend_Log::DEBUG);
}
function getLogger(){
	global $logger;
	if(!isset($logger)){
		$writer = new Zend_Log_Writer_Stream(LOG_FILE);
		$logger = new Zend_Log($writer);
		$filter = new Zend_Log_Filter_Priority(LOG_PRIORITY);
		$logger->addFilter($filter);		
	}
	return $logger;
}

set_exception_handler('exception_handler');

/* Add our library path */
define("APPLICATION_PATH", dirname(__FILE__));
add_include_path(APPLICATION_PATH . '/library');

require_once 'Zend/Log.php';
require_once 'Zend/Log/Writer/Stream.php';
require_once 'Zend/OpenId/Provider/User/Session.php';
require_once 'Zend/OpenId/Provider/Storage/File.php';
include(APPLICATION_PATH."/properties.php");

require_once 'iChain/OpenId/Provider.php';
require_once 'iChain/OpenId/User.php';
require_once 'iChain/OpenId/Storage.php';

getLogger()->info("\n\n\nApplication Start: Request URl: ".$_SERVER['REQUEST_URI']);


?>
