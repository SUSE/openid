<?php
session_start();
$status = "";
$openid_auth = (isset($_POST['openid_identifier']))?$_POST['openid_identifier']:"";
if ($openid_auth && isset($_GET['openid_mode']) && $_GET['openid_mode']	== "id_res") {
	require_once "Zend/OpenId/Consumer.php";
	$consumer = new Zend_OpenId_Consumer();
	if ($consumer->verify($_GET, $id)) {
		$_SESSION['OPENID_AUTH'] = true;
		$_SESSION['mtype'] = "success";
		$_SESSION['message'] = "Successfully authenticated using".$id;
	}
} else if ($openid_auth && (!isset($_SESSION['OPENID_AUTH']) || $_SESSION['OPENID_AUTH'] == false)) {
	require_once "Zend/OpenId/Consumer.php";
	$consumer = new Zend_OpenId_Consumer();
	$consumer->login("http://".$_SERVER['SERVER_NAME']."/openid/");
}

?>
<html>
<head>
</head>
<body>
	<?php echo "$status<br>" ?>
	<form method="post">
		<fieldset>
			<legend>OpenID Login</legend>
			<input type="text" name="openid_identifier" value="http://alanbdee.myopenid.com/" /> 
			<input type="submit" name="openid_action" value="login" />
		</fieldset>
	</form>
	<hr />
	<pre>
	POST
	<?php print_r($_POST);?>
	Cookies
	<?php print_r($_COOKIE);?>
	Headers: 
	<?php $headers = apache_request_headers();
	print_r($headers);
	?>
	SERVER
	<?php print_r($_SERVER);?>
	</pre>
</body>
</html>
