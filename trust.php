<?php
require_once 'openid.inc.php';
/*Zend_OpenId::redirect($_GET['openid_return_to'],
                      array('openid.mode'=>'cancel'));*/
header('Content-Type: text/html; charset=UTF-8');
trigger_error('Attemping to request trust.', E_USER_WARNING);
?>
<html>
<head><title>Trust Denied</title></head>
<body>
<p>Trusting external sites is disabled.</p>
</body>
