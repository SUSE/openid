<?php
require_once 'openid.inc.php';
header('Content-Type: text/html; charset=UTF-8');
$endpoint = Zend_OpenId::absoluteUrl('/openid/endpoint.php');
$localid = null;
getLogger()->debug("/index.endpoint: ".$endpoint." HTTP_HOST: ".HTTP_HOST);

if (isset($_SERVER['PATH_INFO'])) {
	$localid = Zend_OpenId::absoluteUrl('user/'.ltrim($_SERVER['PATH_INFO'],'/'));
	getLogger()->log("localid: ".$localid, Zend_Log::DEBUG);
}
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
	<p>Novell OpenId Provider: <?php echo $endpoint; ?></p>
</body>
</html>
