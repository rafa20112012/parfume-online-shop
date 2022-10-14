<?php
	session_start();
	$strFilename = "prodofday.txt";
	include_once("functions.inc.php");
	$myConn = fDBConnect();
	$strSQL = "SELECT fIdProdus, fIdProdus*0+RAND() as rnd_id FROM tproduse ORDER BY rnd_id LIMIT 31";
	$result = mysql_query($strSQL);
	$strIDs = "";
	while ($row = mysql_fetch_array($result)) {
		//echo $row['fIdProdus'] . "<br>";
		$strIDs .= $row['fIdProdus'] . "\n";
	}
	$fp = fopen($strFilename, "w");
	fwrite($fp, $strIDs);
	fclose($fp);
	fDBClose($myConn); 
?>