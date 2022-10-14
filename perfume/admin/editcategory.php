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
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;">Administration section :: Change category</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
					<form name="frmModificareCategorie" id="frmModificareCategorie" method="post" action="execute.php?action=modificarecategorie" onSubmit="return fValidareAdaugareCategorie();">
						<table cellpadding="5" cellspacing="0" border="0" width="700" class="modelspecs">
							<tr>
								<td align="center" colspan="2" style="font-family: Tahoma, Verdana, Arial; font-weight: bold; font-size: 11pt;"><br>Change category<br><br></td>
							</tr>
							<?php
								$intIdCategorie = $_GET['intIdCategorie'];
								$strSQL = "SELECT * FROM tcategorii WHERE fIdCategorie=$intIdCategorie";
								$result = mysql_query($strSQL);
								$row = mysql_fetch_array($result);

								$strNume = $row['fNumeCategorie'];

							?>
							<input type="hidden" name="intIdCategorie" value="<?php echo $intIdCategorie; ?>">
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Name Category:</td>
								<td width="450"><input type="text" value="<?php echo $strNume; ?>" name="txtNume" id="txtNume" class="text" maxlength="255" style="width: 300px;"></td>
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