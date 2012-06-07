<?php
//keep cookie of last selected server
$default_server = "";
if(isset($_POST['openid_identifier'])){
	setcookie("openid_sample_default_server", $_POST['openid_identifier'], 0, "/");
	$default_server = $_POST['openid_identifier'];
} else if(isset($_COOKIE['openid_sample_default_server'])){
	$default_server = $_COOKIE['openid_sample_default_server'];
}



set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/../library');
require_once("../openid.inc.php");
require_once("../library/Zend/OpenId/Consumer.php");
getLogger()->log("Sample page start", Zend_Log::DEBUG);

$defaultUrls = array(
		"http://".$_SERVER['SERVER_NAME']."/openid",
		"http://mydevbox.novell.com/openid/",
		"http://wwwstage.provo.novell.com/openid/",
		"http://www.novell.com/openid/novell-openid/",
		"http://www.novell.com/openid/",
		"http://badurl.provo.novell.com/openid/",
);
$outputdata = "";
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
		$id = "";
		$outputdata .="Verify Cunsumer: id: ".$id." params: ".print_r($_GET, true);
		$outputdata .= print_r($consumer, true);
		if ($consumer->verify($_GET, $id)) {
			$status = "VALID at " . htmlspecialchars($id);
		} else {
			$status = "INVALID at " . htmlspecialchars($id);
			$status .="<br>Error: ".$consumer->getError();
		}
		$outputdata .= "id = ".$id;
	} else if ($_GET['openid_mode'] == "cancel") {
	}
}

?>

<html>
<body>
	<?php echo "$status<br>" ?>
	<form method="post">
		<fieldset>
			<legend>Set login server:</legend>
			<select type=select name="openid_identifier">
				<?php foreach($defaultUrls as $url):?>
				<option value="<?php echo $url;?>" <?php echo ($default_server==$url?" selected=selected":"");?>>
					<?php echo $url;?>
				</option>
				<?php endforeach;?>
			</select> <input type="submit" name="openid_action" value="login" />
		</fieldset>
	</form>
	<h2>How to Test</h2>
	<p>To test the openid login download it from the repository and install on your local machine.</p>
	<p>Update your local hosts file with the following. This will allow you to see your local machine as a subdomain.</p>
	<pre>
127.0.0.1       mydevbox.novell.com
127.0.0.1       mydevbox.opensuse.org
127.0.0.1       mydevbox.suse.com
127.0.0.1       mydevbox.susestudio.com
127.0.0.1       mydevbox.suse.de
127.0.0.1       mydevbox.suse.cz
127.0.0.1       mydevbox.qa.suse.cz
127.0.0.1       happy-customer.heroku.com
</pre>
	<p>Then use the following links to view your local implimentor</p>
	<ul>
		<li><a href="http://mydevbox.novell.com/openid/samples/">mydevbox.novell.com</a></li>
		<li><a href="http://mydevbox.opensuse.org/openid/samples/">mydevbox.opensuse.org</a></li>
		<li><a href="http://mydevbox.suse.com/openid/samples/">mydevbox.suse.com</a></li>
		<li><a href="http://mydevbox.susestudio.com/openid/samples/">mydevbox.susestudio.com</a></li>
		<li><a href="http://mydevbox.suse.de/openid/samples/"> mydevbox.suse.de</a></li>
		<li><a href="http://mydevbox.suse.cz/openid/samples/">mydevbox.suse.cz</a></li>
		<li><a href="http://mydevbox.qa.suse.cz/openid/samples/">mydevbox.qa.suse.cz</a></li>
		<li><a href="http://happy-customer.heroku.com/openid/samples/">happy-customer.heroku.com</a></li>
	</ul>
	<p>If everything is setup correctly you should see a "Authenticate Result VALID" result at the top.

</body>
</html>


