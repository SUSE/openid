<?php
require_once '../openid.inc.php';

$isloggedin = false;
if ( isset($_SERVER['HTTP_X_WEBIDSYNCHID']) && $_SERVER['HTTP_X_WEBIDSYNCHID'] != '' ){
  $isloggedin = true;
}

if ( !($isloggedin) ){
  setcookie("openid", $_SERVER['REQUEST_URI'], 0, "/openid/", "novell.com");
  header( 'Location: http://www.novell.com/common/util/secure/login.php?r=http://www.novell.com/openid/secure/' ) ; 
}
else {
  if ( isset($_COOKIE["openid"]) ){
    header( "Location: " . $_COOKIE["openid"] );
    setcookie("openid", "", time()-60000, "/openid/", "novell.com");
  }
  else {
    $server = new iChain_OpenId_User();
    $_GET["nuserid"] = $server->_getHeader('X-Webidsynchid');
    Zend_OpenId::redirect("/openid/endpoint.php",$_GET);
  }
}
?>
