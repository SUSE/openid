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
			$userString = "";
			print_r($user, $userString);
			$storageString = "";
			print_r($storage, $storageString);
			getLogger()->log("Provider Init: \nloginUrl: ".$loginUrl."\ntrustUrl: ".$trustUrl."\nuser: ".$userString."\nstorage: ".$storageString."\nsessionTtl:".$sessionTtl, Zend_Log::DEBUG);	
		}
		
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
		global $logger;
		if(isset($logger)){
			getLogger()->log("Storage Constructed", Zend_Log::DEBUG);
		}
		$user = $this->getLoggedInUser();
		if ($user) {
			$params['openid_identity'] = $params['openid_claimed_id'] = $user;
		}

		return parent::_checkId($version, $params, $immediate, $extensions, $response);
	}
}
