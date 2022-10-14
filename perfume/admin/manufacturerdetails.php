<?php
	session_start();
	include_once("../include/mysql.inc.php");
	include_once("../include/functions.inc.php");
	include_once("../include/adminfunctions.inc.php");
	$bIsLoggedIn = fCheckAdminLogin();
	if (!$bIsLoggedIn) {
		Header("Location:index.php");
	}
	$myConn = fDBConnect();
	$strError  = isset($_GET['strError '])? $_GET['strError '] : '';
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
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;">Administration section :: Manufacturer details</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
					<table cellpadding="5" cellspacing="0" border="0" width="700" class="modelspecs">
						<tr>
							<td align="center" colspan="2" style="font-family: Tahoma, Verdana, Arial; font-weight: bold; font-size: 11pt;"><br>Manufacturer details<br><br></td>
						</tr>
						<?php
							$intIdProducator = $_GET['intIdProducator'];
							$strSQL = "SELECT * FROM tproducatori WHERE fIdProducator=$intIdProducator";
							$result = mysql_query($strSQL);
							$row = mysql_fetch_array($result);

							$strNume = $row['fNumeProducator'];
							$strURL = $row['fUrl'];
							$strDescriere = $row['fDescriere'];
						?>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Manufacturer Name:</td>
							<td width="450"><?php echo $strNume; ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Site Web:</td>
							<td width="450"><a class="genLinkReverse" target="_blank" href="<?php echo $strURL; ?>"><?php echo $strURL; ?></a></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250" valign="top">Description:</td>
							<td width="450"><?php echo nl2br($strDescriere); ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250" valign="top">Products:</td>
							<td width="450"><a href="products.php?intIdProducator=<?php echo $intIdProducator; ?>"><img src="../images/details.gif" border="0"></a></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="center" colspan="2">
								<a href="production.php" class="genLink" style="width: 100px;"> &nbsp; Back &nbsp; </a><br><br>
								</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>