<?php
	require_once("config.inc.php");
	switch ($connType) {
		case "local" : {
			$server_name = "localhost";
			$db_name = "perfume";
			$db_user = "root";
			$db_pass = "";
			break;
		}
	}
//----------------------------------------------------------------------------------------
function fDBConnect() {
	global $server_name;
	global $db_user;
	global $db_pass;
	global $db_name;
	$myConn = mysql_connect($server_name, $db_user, $db_pass) or
		die("Error while connecting to db: " . mysql_error());
	$res = mysql_select_db($db_name);
	if (!$res) 
		die ("Error while opening the db");
	return $myConn;
}
//----------------------------------------------------------------------------------------
function fDBClose($link) {
	mysql_close ($link);
}
?>