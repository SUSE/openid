<?php 

require_once(APPLICATION_PATH."/library/Zend/OpenId/Provider.php");

class iChain_OpenId_Provider extends Zend_OpenId_Provider
{
	public function __construct($loginUrl = null,
                                $trustUrl = null,
                                Zend_OpenId_Provider_User $user = null,
                                Zend_OpenId_Provider_Storage $storage = null,
                                $sessionTtl = 3600)
	{
		global $logger;
		if(isset($logger)){
			$userString = print_r($user, true);
			$storageString = print_r($storage, true);
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Provider Init: loginUrl: ".$loginUrl, Zend_Log::DEBUG);	
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Provider Init: trustUrl: ".$trustUrl, Zend_Log::DEBUG);
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Provider Init: user: ".$userString, Zend_Log::DEBUG);
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Provider Init: storage: ".$storageString, Zend_Log::DEBUG);
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Provider Init: sessionTtl:".$sessionTtl, Zend_Log::DEBUG);
		}
		
		if ($user === null) {
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Create User: ", Zend_Log::DEBUG);
			$user = new iChain_OpenId_User();
		}
		if ($storage === null) {
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Create Storage: ", Zend_Log::DEBUG);
			$storage = new iChain_OpenId_Storage();
		}
		parent::__construct($loginUrl, $trustUrl, $user, $storage, $sessionTtl);
	}

	protected function _checkId($version, $params, $immediate, $extensions=null, Zend_Controller_Response_Abstract $response = null)
	{
		global $logger;
		if(isset($logger)){
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Storage Constructed", Zend_Log::DEBUG);
		}
		$user = $this->getLoggedInUser();
		if ($user) {
			$params['openid_identity'] = $params['openid_claimed_id'] = $user;
		}

		return parent::_checkId($version, $params, $immediate, $extensions, $response);
	}
	
	public function getSiteRoot($params)
	{
		$site = parent::getSiteRoot($params);
		getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Return ".$site, Zend_Log::DEBUG);
		return $site;
	}
}
