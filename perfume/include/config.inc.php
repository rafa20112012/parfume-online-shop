<?php
	$bDebug = true;
	if ($bDebug) { //debug is true -> local
		$hostname = "localhost"; // mail host name
		$connType = "local";
		$strAdminEmail = "";	
	} else { //debug is false -> client
		$hostname = "localhost"; // mail host name
		$connType = "local";
		$strAdminEmail = "";
	}
?>