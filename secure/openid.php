<?php
exit();
require_once '../openid.inc.php';
if(isset($logger)){
	getLogger()->log("secure/openid", Zend_Log::DEBUG);	
}

//$session = $client->GetSession($username,$password,$_REQUEST["key"]);
//$key = $client->GetKey($username,$password,$_REQUEST["key"]);
//$keypath = 'https://'.OPENID_SERVER.'/API.asmx/GetKey?username='.OPENID_USERNAME.'&password='.OPENID_PASSWORD.'&key='.$_REQUEST["key"];
//$key = simplexml_load_file($keypath);
//$sessionpath = 'https://'.OPENID_SERVER.'/API.asmx/GetSession?username='.OPENID_USERNAME.'&password='.OPENID_PASSWORD.'&key='.$_REQUEST["key"];
//$session = simplexml_load_file($sessionpath);

getLogger()->log("key: ".$keypath." result\n".$key, Zend_Log::DEBUG);
getLogger()->log("session: ".$sessionpath." result\n".$session, Zend_Log::DEBUG);

//die ("Session:".$session."Key:".$key);

 
$userid = iChain_OpenId_User::_getHeader(HEADER_USERNAME);
$email = iChain_OpenId_User::_getHeader(HEADER_EMAIL);
$fname = iChain_OpenId_User::_getHeader(HEADER_FIRST_NAME);
$lname = iChain_OpenId_User::_getHeader(HEADER_LAST_NAME);

//$toret = "Location:https://".OPENID_SERVER."/(S(".$session."))/login.aspx?ReturnUrl=%2fdecide.aspx&gkey=".$key."&uname=".$userid;
//getLogger()->log("toret: ".$toret, Zend_Log::DEBUG);
//header($toret);	
