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
define ("LOG_FILE", "/var/log/apps/openid/openidwrapper.log");
define ("LOG_PRIORITY", 7);

define ("OPENID_SERVER", "apexedi.cougarpc.net");
define ("OPENID_USERNAME", "n0v3110p3n1ds3rv3r@n0v311.c0m");
define ("OPENID_PASSWORD", "sup3rs3cur3p@ssw0rd4n0v3110p3n1ds3rv3r@n0v311.c0m");

class TrustedSites{
	public static $DOMAINS = array(
		'novell.com', 
		'opensuse.org', 
		'susestudio.com', 
		'suse.de', 
		'suse.cz', 
		'qa.suse.cz', 
		'istudio.nue.novell.com',
	);
}
