<?php
require_once 'openid.inc.php';
header('Content-Type: text/html; charset=UTF-8');
$endpoint = Zend_OpenId::absoluteUrl('/openid/endpoint.php');
$localid = null;
if (isset($_SERVER['PATH_INFO'])) {
	$localid = Zend_OpenId::absoluteUrl('user/'.ltrim($_SERVER['PATH_INFO'],'/'));
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
<?= $localid ?>
<p>You should not be seeing this.</p>
</body>
</html>
