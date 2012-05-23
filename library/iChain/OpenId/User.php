<?php
class iChain_OpenId_User extends Zend_OpenId_Provider_User
{
	private $_prefix = "http://wwwstage.provo.novell.com/openid/user/";

	public function __construct(){
		$this->_prefix = "http://".$_SERVER['SERVER_NAME']."/openid/user/";
		global $logger;
		if(isset($logger)){
			getLogger()->log("User Constructed, prefix set: ".$this->_prefix." ", Zend_Log::DEBUG);
		}
		
	}

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
			$user = $this->getPrefix() . $wisi;
		}
		return $user;
	}

	public function delLoggedInUser() {
		trigger_error('iChain OpenID delLoggedinUser called', E_USER_WARNING);
		return true;
	}
	
	public function getPrefix(){
		return $this->_prefix;
	}


}


