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

/* Add our library path */
add_include_path(dirname(__FILE__) . '/library');

require_once 'Zend/OpenId/Provider.php';
require_once 'Zend/OpenId/Provider/User/Session.php';
require_once 'Zend/OpenId/Provider/Storage/File.php';

class iChain_OpenId_User extends Zend_OpenId_Provider_User
{
	private $_prefix = 'http://www.novell.com/openid/user/';

	public static function _getHeader($h) {
		static $headers = null;
		if (!is_array($headers)) {
			$headers = array_change_key_case(apache_request_headers());
		}
		$h = strtolower($h);
		return isset($headers[$h]) ? $headers[$h] : false;
	}

	public function setLoggedInUser($id) {
		trigger_error('iChain OpenID setLoggedinUser called', E_USER_WARNING);
		return true;
	}

	public function getLoggedInUser() {
		$user = false;
		$wisi = $this->_getHeader('X-USERNAME');
		//$wisi = $_REQUEST['nuserid'];
		if ($wisi && $wisi != '') {
			$user = $this->_prefix . $wisi;
		}
		return $user;
	}

	public function delLoggedInUser() {
		trigger_error('iChain OpenID delLoggedinUser called', E_USER_WARNING);
		return true;
	}


}

/* Our storageless implementation */
class iChain_OpenId_Storage extends Zend_OpenId_Provider_Storage_File
{
	/* Users are not stored here, so always fail */
	public function addUser($id, $password) {
		trigger_error('iChain OpenID addUser called', E_USER_WARNING);
		return false;
	}

	/* We have all users (until we check to see if the user matches */
	public function hasUser($id) {
		trigger_error('iChain OpenID hasUser called', E_USER_WARNING);
		return true;
	}

	/* Users are not stored here, so always fail */
	public function checkUser($id, $password) {
		trigger_error('iChain OpenID checkUser called', E_USER_WARNING);
		return false;
	}

	/* All users have the same trusted sites */
	public function getTrustedSites($id) {
		$domains = array('novell.com', 'opensuse.org', 'susestudio.com', 'suse.de', 'suse.cz', 'qa.suse.cz', 'istudio.nue.suse.com' );
		$sites = array();
		foreach ($domains as $d) {
			$sites['http://'.$d.'/'] = true;
			$sites['https://'.$d.'/'] = true;
			$sites['http://*.'.$d.'/'] = true;
			$sites['https://*.'.$d.'/'] = true;
		}
		// All other sites starting are not trusted
		// We assume $id is a url starting with h(ttp)
		$sites['h'] = false;
		
		return $sites;
	}

	/* We have a hardcoded list of trusted sites, so fail */
	public function addSite($id, $site, $trusted) {
		trigger_error('iChain OpenID addSite called', E_USER_WARNING);
		return false;
	}
}	

class iChain_OpenId_Provider extends Zend_OpenId_Provider
{
	public function __construct($loginUrl = null,
                                $trustUrl = null,
                                Zend_OpenId_Provider_User $user = null,
                                Zend_OpenId_Provider_Storage $storage = null,
                                $sessionTtl = 3600)
	{
		if ($user === null) {
			$user = new iChain_OpenId_User();
		}
		if ($storage === null) {
			$storage = new iChain_OpenId_Storage();
		}
		parent::__construct($loginUrl, $trustUrl, $user, $storage, $sessionTtl);
	}

	protected function _checkId($version, $params, $immediate, $extensions=null, Zend_Controller_Response_Abstract $response = null)
	{
		$user = $this->getLoggedInUser();
		if ($user) {
			$params['openid_identity'] = $params['openid_claimed_id'] = $user;
		}

		return parent::_checkId($version, $params, $immediate, $extensions, $response);
	}
}

?>
