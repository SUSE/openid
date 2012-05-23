<?php
require_once '../openid.inc.php';
getLogger()->log("secure/index", Zend_Log::DEBUG);
$isloggedin = false;
if ( isset($_SERVER['HTTP_X_WEBIDSYNCHID']) && $_SERVER['HTTP_X_WEBIDSYNCHID'] != '' ){
	$isloggedin = true;
}

getLogger()->log("isUserTrusted: ".$isloggedin, Zend_Log::DEBUG);


if ( !($isloggedin) ){
	//user is not logged in, redirect to login page.
	setcookie("openid", $_SERVER['REQUEST_URI'], 0, "/openid/", "novell.com");
	$url = 'http://'.$_SERVER['SERVER_NAME'].'/common/util/secure/login.php?r=http://'.$_SERVER['SERVER_NAME'].'/openid/secure/';
	getLogger()->log("Not Logged in, redirect to: ".$url, Zend_Log::DEBUG);
	header( 'Location: ' .$url ) ;
}
else {
	//
	if ( isset($_COOKIE["openid"]) ){
		getLogger()->log("Cookie Set, redirect to: ".$_COOKIE["openid"], Zend_Log::DEBUG);
		header( "Location: " . $_COOKIE["openid"] );
		setcookie("openid", "", time()-60000, "/openid/", "novell.com");
	}
	else {
		$server = new iChain_OpenId_User();
		$_GET["nuserid"] = $server->_getHeader('X-Webidsynchid');
		$serverString = print_r($server, true);
		getLogger()->log("Get info from iChain_OpenId nuserid=".$_GET["nuserid"].", redirect to /openid/endpoint.php\n".$serverString, Zend_Log::DEBUG);
		Zend_OpenId::redirect("/openid/endpoint.php",$_GET);
	}
}
?>
