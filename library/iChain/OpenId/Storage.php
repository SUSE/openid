<?php

/* Our storageless implementation */
class iChain_OpenId_Storage extends Zend_OpenId_Provider_Storage_File
{
	public function __construct(){
		global $logger;
		if(isset($logger)){
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): Storage Constructed", Zend_Log::DEBUG);
		}
		parent::__construct();
	}
	/* Users are not stored here, so always fail */
	public function addUser($id, $password) {
		global $logger;
		if(isset($logger)){
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): addUser called: ".E_USER_WARNING, Zend_Log::ERR);
		}
		trigger_error('iChain OpenID addUser called', E_USER_WARNING);
		return false;
	}

 	// We have all users (until we check to see if the user matches 
	public function hasUser($id) {
		global $logger;
		if(isset($logger)){
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): ".E_USER_WARNING, Zend_Log::INFO);
		}
		return true;
	}
 
	/* Users are not stored here, so always fail */
	public function checkUser($id, $password) {
		global $logger;
		if(isset($logger)){
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): iChain OpenID checkUser called ".E_USER_WARNING, Zend_Log::ERR);
		}
		trigger_error('iChain OpenID checkUser called', E_USER_WARNING);
		return false;
	}

	/* All users have the same trusted sites */
	public function getTrustedSites($id) {
		$sites = array();
		foreach (TrustedSites::$DOMAINS as $d) {
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
		global $logger;
		if(isset($logger)){
			getLogger()->log(__CLASS__." ".__FUNCTION__." (".__LINE__."): iChain OpenID addSite called ".E_USER_WARNING, Zend_Log::ERR);
		}
		trigger_error('iChain OpenID addSite called', E_USER_WARNING);
		return false;
	}
}	
