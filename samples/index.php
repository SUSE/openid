<?php
//keep cookie of last selected server
$default_server = "";
if(isset($_POST['openid_identifier'])){
	setcookie("openid_sample_default_server", $_POST['openid_identifier'], 0, "/");
	$default_server = $_POST['openid_identifier'];
} else if(isset($_COOKIE['openid_sample_default_server'])){
	$default_server = $_COOKIE['openid_sample_default_server'];
}

define ("APPLICATION_PATH", realpath(dirname(__FILE__)."/../"));

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/../library');
require_once(APPLICATION_PATH."/openid.inc.php");
require_once(APPLICATION_PATH."/library/Zend/OpenId/Consumer.php");
getLogger()->log("samples/index", Zend_Log::DEBUG);

$defaultUrls = array(
		"http://".$_SERVER['SERVER_NAME']."/openid",
		"https://".$_SERVER['SERVER_NAME']."/openid",
		"https://mydevbox.novell.com/openid/",
		"https://wwwstage.provo.novell.com/openid/",
		"https://www.novell.com/openid/novell-openid/",
		"https://www.novell.com/openid/",
		"https://www.suse.com/openid/",
		"https://badurl.provo.novell.com/openid/",
);
$outputdata = "";
$status = "";
$headers_needed = false;
if(strlen(iChain_OpenId_User::_getHeader("x-workforceid"))==0){//if headers aren't being sent accross the utility will just loop.
	$headers_needed = true;
}
else if (isset($_POST['openid_action']) &&
		$_POST['openid_action'] == "login" &&
		!empty($_POST['openid_identifier'])) {
	getLogger()->debug("Try to log in");
	$consumer = new Zend_OpenId_Consumer();
	getLogger()->debug("Create Cunsumer Object");
	getLogger()->debug("Login using identifier: ".$_POST['openid_identifier']);
	$login_reault = $consumer->login($_POST['openid_identifier']);
	if (!$login_reault) {
		getLogger()->debug("set status to login failed");
		$status = "OpenID login failed.";
	} else {
		getLogger()->debug("login successful");
	}
} else if (isset($_GET['openid_mode'])) {
	getLogger()->debug("Authenticate Result");
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
		getLogger()->debug("Status: ".$status);
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
	<?php if($headers_needed):?>
		<p style="color:red;">Warning: headers need to be set before you can use this utility. Please use a plug-in like Modify Headers to mock out your header information if your running this locally.</p>
	<?php endif;?>
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
		<li><a href="https://mydevbox.novell.com/openid/samples/">mydevbox.novell.com</a></li>
		<li><a href="https://mydevbox.opensuse.org/openid/samples/">mydevbox.opensuse.org</a></li>
		<li><a href="https://mydevbox.suse.com/openid/samples/">mydevbox.suse.com</a></li>
		<li><a href="https://mydevbox.susestudio.com/openid/samples/">mydevbox.susestudio.com</a></li>
		<li><a href="https://mydevbox.suse.de/openid/samples/"> mydevbox.suse.de</a></li>
		<li><a href="https://mydevbox.suse.cz/openid/samples/">mydevbox.suse.cz</a></li>
		<li><a href="https://mydevbox.qa.suse.cz/openid/samples/">mydevbox.qa.suse.cz</a></li>
		<li><a href="https://happy-customer.heroku.com/openid/samples/">happy-customer.heroku.com</a></li>
	</ul>
	<p>If everything is setup correctly you should see a "Authenticate Result VALID" result at the top.
	
	
</body>
</html>


