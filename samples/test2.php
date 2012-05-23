<?php
include("openid.inc.php");
//require_once ('library/Zend/OpenId.php');

// Set up test identity
define("TEST_SERVER", Zend_OpenId::absoluteURL("example-8.php"));
define("TEST_ID", Zend_OpenId::selfURL());
define("TEST_PASSWORD", "123");
$server = new Zend_OpenId_Provider();
if (!$server->hasUser(TEST_ID)) {
    $server->register(TEST_ID, TEST_PASSWORD);
}
$ichainUser = new iChain_OpenId_User();
?>
<html><head>
<link rel="openid.server" href="<?php echo TEST_SERVER;?>" />
</head><body>
<?php echo TEST_ID;?>
<p><?php echo $ichainUser->getPrefix();?></p>
</body></html>