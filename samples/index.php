<?php
require_once("../library/Zend/OpenId/Consumer.php");
$status = "";
if (isset($_POST['openid_action']) &&
		$_POST['openid_action'] == "login" &&
		!empty($_POST['openid_identifier'])) {
	echo "Try to log in";
	$consumer = new Zend_OpenId_Consumer();
	if (!$consumer->login($_POST['openid_identifier'])) {
		$status = "OpenID login failed.";
	}
} else if (isset($_GET['openid_mode'])) {
	echo "Authenticate Result";
	if ($_GET['openid_mode'] == "id_res") {
		$consumer = new Zend_OpenId_Consumer();
		if ($consumer->verify($_GET, $id)) {
			$status = "VALID " . htmlspecialchars($id);
		} else {
			$status = "INVALID " . htmlspecialchars($id);
		}
	} else if ($_GET['openid_mode'] == "cancel") {
		$status = "CANCELLED";
	}
}
?>

<html>
<body>
	<?php echo "$status<br>" ?>
	<form method="post">
		<fieldset>
			<legend>Set login server:</legend>
			<input type="text" name="openid_identifier" value="http://<?php echo $_SERVER['SERVER_NAME'];?>/openid/" /> 
			<input type="submit" name="openid_action" value="login" />
		</fieldset>
	</form>
	<p>For development purposes. The text box allows you to set which openid server to hit. By default it will come back to itself. However, to test the login process of an external server enter that server. You should get a "Authenticate Result VALID" response.</p>
</body>
</html>
