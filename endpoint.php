<?php
require_once 'openid.inc.php';
$server = new iChain_OpenId_Provider('secure/', 'trust.php');
$ret = $server->handle();
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
