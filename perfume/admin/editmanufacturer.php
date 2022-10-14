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
		<title>Administration section</title>
		<link rel="stylesheet" href="../css/admin.css" type="text/css">
		<script language="javascript" src="../js/functions.js"></script>
	</head>
	<body>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
			<tr style="height: 50px; width: 100%;">
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;">Administration section :: Manufacturer change</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
					<form name="frmModificareProducator" id="frmModificareProducator" method="post" action="execute.php?action=modificareproducator" onSubmit="return fValidareAdaugareProducator();">
						<table cellpadding="5" cellspacing="0" border="0" width="700" class="modelspecs">
							<tr>
								<td align="center" colspan="2" style="font-family: Tahoma, Verdana, Arial; font-weight: bold; font-size: 11pt;"><br>Manufacturer change<br><br></td>
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
							<input type="hidden" name="intIdProducator" value="<?php echo $intIdProducator; ?>">
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Manufacturer Name:</td>
								<td width="450"><input type="text" value="<?php echo $strNume; ?>" name="txtNume" id="txtNume" class="text" maxlength="255" style="width: 300px;"></td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Site Web:</td>
								<td width="450"><input type="text" value="<?php echo $strURL; ?>" name="txtURL" id="txtURL" class="text" maxlength="255" style="width: 300px;"></td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Description:</td>
								<td width="450"><textarea name="txtDescriere" id="txtDescriere" class="text" style="width: 300px; height: 150px;"><?php echo $strDescriere; ?></textarea></td>
							</tr>
							
							<tr bgcolor="#C1C1FF">
								<td align="center" colspan="2">
								<input class="buttons" type="reset" name="cmdReset" id="cmdReset" value="Cancel changes"> &nbsp; 
								<input class="buttons" type="submit" name="cmdGo" id="cmdGo" value="Change">
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	</body>
</html>