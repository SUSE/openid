<?php
require_once 'openid.inc.php';
getLogger()->log("endpoint", Zend_Log::DEBUG);
$provider = new iChain_OpenId_Provider('secure/', 'trust.php');

$ret = $provider->handle();
getLogger()->log("server->handle()\n".$ret, Zend_Log::DEBUG);
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
