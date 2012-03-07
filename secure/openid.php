<?
$server = "apexedi.cougarpc.net";
$username = "n0v3110p3n1ds3rv3r@n0v311.c0m";
$password = "sup3rs3cur3p@ssw0rd4n0v3110p3n1ds3rv3r@n0v311.c0m";



//$session = $client->GetSession($username,$password,$_REQUEST["key"]);
//$key = $client->GetKey($username,$password,$_REQUEST["key"]);

$key = simplexml_load_file('http://apexedi.cougarpc.net/API.asmx/GetKey?username='.$username.'&password='.$password.'&key='.$_REQUEST["key"]);
$session = simplexml_load_file('http://apexedi.cougarpc.net/API.asmx/GetSession?username='.$username.'&password='.$password.'&key='.$_REQUEST["key"]);

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
$toret = "Location:http://".$server."/(S(".$session."))/login.aspx?ReturnUrl=%2fdecide.aspx&gkey=".$key."&uname=".$userid;
//die($toret."key: ". $_REQUEST["key"]);
header($toret);	
