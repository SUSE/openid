<?php
/**
 * Properties file that contains application specific information
 *
 */

/**
 * ZendLog Priorities
 *  const EMERG   = 0;  // Emergency: system is unusable
 const ALERT   = 1;  // Alert: action must be taken immediately
 const CRIT    = 2;  // Critical: critical conditions
 const ERR     = 3;  // Error: error conditions
 const WARN    = 4;  // Warning: warning conditions
 const NOTICE  = 5;  // Notice: normal but significant condition
 const INFO    = 6;  // Informational: informational messages
 const DEBUG   = 7;  // Debug: debug messages
 * @var unknown_type
 */
define ("LOG_PRIORITY", 4);
//define ("LOG_FILE", "/var/log/apps/openid/openidwrapper.log");
define ("LOG_FILE", APPLICATION_PATH."/openidwrapper.log");
define ("ERROR_LEVEL", E_ALL);


//define ("OPENID_SERVER", "apexedi.cougarpc.net");
//define ("OPENID_USERNAME", "n0v3110p3n1ds3rv3r@n0v311.c0m");
//define ("OPENID_PASSWORD", "sup3rs3cur3p@ssw0rd4n0v3110p3n1ds3rv3r@n0v311.c0m");

/**
 * This adds a static list of authorized sites. a test for "novell.com" will match "www.novell.com" or "innerweb.novell.com" etc. 
 * Here is a sample of what is matched for "novell.com":
 * check 
 * 	url: 			http://istudio.nue.suse.com/openid/samples/ 
 * 	trusted site: 	http://*.novell.com/ 
 * 	regexp			/^http\:\/\/[A-Za-z1-9_\.]+?\.novell\.com\//
 * @author alan
 *
 */
class TrustedSites{
	public static $DOMAINS = array(
			'novell.com',
                        'lab.novell.com',
                        'xen80.virt.lab.novell.com',
			'opensuse.org',
			'suse.com',
			'susestudio.com',
			'suse.de',
			'suse.de:3000',
			'suse.cz',
			'qa.suse.cz',
                        'happy-customer.herokuapp.com',
			'happy-customer.heroku.com', //Staging system for suse dev team
			'localhost', 
                        'localhost:3000',
                        '127.0.0.1', 
                        '127.0.0.1:3000',
                        '127.0.0.1:31337'
	);
}
define ("HEADER_USERNAME", "x-username");
define ("HEADER_USERID", "x-webidsynchid");
define ("HEADER_EMAIL", "x-email");
define ("HEADER_FIRST_NAME", "x-firstname");
define ("HEADER_LAST_NAME", "x-lastname");
//print_r($_SERVER);
