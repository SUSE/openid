<?php
require_once 'openid.inc.php';
getLogger()->log("endpoint", Zend_Log::DEBUG);
$provider = new iChain_OpenId_Provider('secure/', 'trust.php');

$sreg = new iChain_OpenId_Sreg(array(
        'username' => iChain_OpenId_User::_getHeader(HEADER_USERNAME),
        'websynchid' => iChain_OpenId_User::_getHeader(HEADER_USERID),
        'first_name' => iChain_OpenId_User::_getHeader(HEADER_FIRST_NAME),
        'last_name' => iChain_OpenId_User::_getHeader(HEADER_LAST_NAME),
        'fullname' => iChain_OpenId_User::_getHeader(HEADER_FIRST_NAME) . " " .
         iChain_OpenId_User::_getHeader(HEADER_LAST_NAME),
        'email' => iChain_OpenId_User::_getHeader(HEADER_EMAIL)
    ));

getLogger()->log("endpoint-- get: ".print_r($_GET, true)." post: ".print_r($_POST, true)." sreg: ".print_r($sreg, true), Zend_Log::DEBUG);

$ret = $provider->handle(null, $sreg);

getLogger()->log("server->handle()\n".$ret, Zend_Log::DEBUG);
getLogger()->log("sreg->getProperties()\n".print_r($sreg->getProperties(), true), Zend_Log::DEBUG);

header('Content-Type: text/plain; charset=UTF-8');
if (is_string($ret)) {
    echo $ret;
} else if ($ret !== true) {
    header('HTTP/1.0 403 Forbidden');
    //echo 'Forbidden';
	var_dump($ret);
} else {
    echo 'Approved! (You should not be seeing this.)';
}
?>
