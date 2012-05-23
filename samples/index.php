<?php
require_once("../library/Zend/OpenId/Consumer.php");
$status = "";
if (isset($_POST['openid_action']) &&
		$_POST['openid_action'] == "login" &&
		!empty($_POST['openid_identifier'])) {

	$consumer = new Zend_OpenId_Consumer();
	if (!$consumer->login($_POST['openid_identifier'])) {
		$status = "OpenID login failed.";
	}
} else if (isset($_GET['openid_mode'])) {
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
			<legend>OpenID Login Form</legend>
			<input type="text" name="openid_identifier" value="http://alanbdee.myopenid.com/" /> 
			<input type="submit" name="openid_action" value="login" />
		</fieldset>
	</form>
	<a href="authedpage.php">View Page that requries Authorization</a>
</body>
</html>
