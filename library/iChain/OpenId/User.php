<?php
class iChain_OpenId_User extends Zend_OpenId_Provider_User
{
	private $_prefix;

	public function __construct(){
		$this->_prefix = HTTP_HOST.$_SERVER['SERVER_NAME']."/openid/user/";
		global $logger;
		if(isset($logger)){
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): User Constructed, prefix set: ".$this->_prefix." ", Zend_Log::DEBUG);
		}
	}

	public static function _getHeader($h) {
		static $headers = null;
		if (!is_array($headers)) {
			$headers = array_change_key_case(apache_request_headers());
		}
		$h = strtolower($h);
		$response = isset($headers[$h]) ? $headers[$h] : false;
		getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): header requested: ".$h." found: ".$response, Zend_Log::DEBUG);		
		return $response;
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


