<?php
	session_start();
	include_once("../include/mysql.inc.php");
	include_once("../include/functions.inc.php");
	include_once("../include/adminfunctions.inc.php");
	$myConn = fDBConnect();
	$bIsLoggedIn = fCheckAdminLogin();
	$strError  = isset($_GET['strError '])? $_GET['strError '] : '';
	//$strError = $_GET['error'];

?>
<html>
	<head>
		<title> Administration section</title>
		<link rel="stylesheet" href="../css/admin.css" type="text/css">
		<script language="javascript" src="../js/functions.js"></script>
	</head>
	<body>
		

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
			<tr style="height: 50px; width: 100%;">
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;"> Administration section</td>
			</tr>
			<tr>
			<td style="width: 200px;"  valign="center">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
					<td align="center" valign="middle"  style="width: 700px; font-family: Verdana, Tahoma, Arial; font-size: 10pt; color: #006699;font-weight: bold;"><span class="style2">ADMINISTRATION AUTHENTICATION SECTION</span></td>
			</tr>
		</table>


	</body>
</html>