<?php
require_once 'openid.inc.php';
getLogger()->log("user", Zend_Log::DEBUG);
header('Content-Type: text/html; charset=UTF-8');
$endpoint = Zend_OpenId::absoluteUrl('/openid/endpoint.php');
$localid = null;
if (isset($_SERVER['PATH_INFO'])) {
	$localid = Zend_OpenId::absoluteUrl('/openid/user/'.ltrim($_SERVER['PATH_INFO'],'/'));
}
getLogger()->log("endpoint: ".$endpoint, Zend_Log::DEBUG);
getLogger()->log("localid: ".$localid, Zend_Log::DEBUG);
?>
<html>
<head>
<title>OpenId Provider</title>
<link rel="openid2.provider" href="<?php echo $endpoint; ?>">
<?php if ($localid) { ?>
<link rel="openid2.local_id" href="<?php echo $localid; ?>">
<?php } ?>
</head>
<body>
<p>You should not be seeing this.</p>
</body>
</html>
