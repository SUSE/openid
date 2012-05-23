<?php
if(isset($logger)){
	getLogger()->log("secure/openid", Zend_Log::DEBUG);	
}
//$server = "apexedi.cougarpc.net";
//$username = "n0v3110p3n1ds3rv3r@n0v311.c0m";
//$password = "sup3rs3cur3p@ssw0rd4n0v3110p3n1ds3rv3r@n0v311.c0m";


//$session = $client->GetSession($username,$password,$_REQUEST["key"]);
//$key = $client->GetKey($username,$password,$_REQUEST["key"]);

$key = simplexml_load_file('http://'.OPENID_SERVER.'/API.asmx/GetKey?username='.OPENID_USERNAME.'&password='.OPENID_PASSWORD.'&key='.$_REQUEST["key"]);
$session = simplexml_load_file('http://'.OPENID_SERVER.'/API.asmx/GetSession?username='.OPENID_USERNAME.'&password='.OPENID_PASSWORD.'&key='.$_REQUEST["key"]);

getLogger()->log("key: ".$key, Zend_Log::DEBUG);
getLogger()->log("session: ".$session, Zend_Log::DEBUG);

//die ("Session:".$session."Key:".$key);

 
$userid = "";
$email = "";
$fname = "";
$lname = "";

$headers = getallheaders();
foreach ($headers as $name => $content) {
	if(strtolower($name) == "x-webidsynchid") {
		$userid  = $content;
	}
	if(strtolower($name) == "x-email") {
		$email = urlencode($content);
	}
	if(strtolower($name) == "x-firstname") {
		$fname = urlencode($content);
	}
	if(strtolower($name) == "x-lastname") {
		$lname = urlencode($content);
	}
} 
$toret = "Location:http://".OPENID_SERVER."/(S(".$session."))/login.aspx?ReturnUrl=%2fdecide.aspx&gkey=".$key."&uname=".$userid;
getLogger()->log("toret: ".$toret, Zend_Log::DEBUG);
header($toret);	
