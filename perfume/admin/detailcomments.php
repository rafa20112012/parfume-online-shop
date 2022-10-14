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
		<title>Sectiunea de administrare</title>
		<link rel="stylesheet" href="../css/admin.css" type="text/css">
		<script language="javascript" src="../js/functions.js"></script>
	</head>
	<body>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
			<tr style="height: 50px; width: 100%;">
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;">Sectiunea de administrare :: Detalii comentariu</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
					<table cellpadding="5" cellspacing="0" border="0" width="700" class="modelspecs">
						<tr>
							<td align="center" colspan="2" style="font-family: Tahoma, Verdana, Arial; font-weight: bold; font-size: 11pt;"><br>Detalii comentariu<br><br></td>
						</tr>
						<?php
							$intIdComentariu = $_GET['intIdComentariu'];
							$strSQL = "SELECT tcomentarii.*, tproduse.fNumeProdus, tutilizatori.fNumeUtilizator FROM tcomentarii, tproduse, tutilizatori WHERE tcomentarii.fIdProdus=tproduse.fIdProdus AND tcomentarii.fIdUtilizator=tutilizatori.fIdUtilizator AND tcomentarii.fIdComentariu=$intIdComentariu";
							$result = mysql_query($strSQL);
							$row = mysql_fetch_array($result);
							$intIdProdus = $row['fIdProdus'];
							$intIdUtilizator = $row['fIdUtilizator'];
							$strNumeProdus = $row['fNumeProdus'];
							$strNumeUtilizator = $row['fNumeUtilizator'];
							$strData = $row['fData'];
							$intAprobat = $row['fAprobat'];
							$strComentariu = $row['fComentariu'];
							switch ($intAprobat) {
								case 1:
									$strAprobat = "<b><font color=\"green\">Da</b>";
									$strLinkAproba = "<a onclick=\"return confirm('Confirmati dezaprobarea comentariului?')\" href=\"execute.php?action=dezaprobacomentariu&intIdComentariu=$intIdComentariu\"><img src=\"../images/disable.gif\" border=\"0\"></a>";
									break;
								case 0:
									$strAprobat = "<b><font color=\"red\">Nu</b>";
									$strLinkAproba = "<a onclick=\"return confirm('Confirmati aprobarea comentariului?')\" href=\"execute.php?action=aprobacomentariu&intIdComentariu=$intIdComentariu\"><img src=\"../images/approve.gif\" border=\"0\"></a>";
									break;
							}
						?>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Nume Produs:</td>
							<td width="450"><?php echo $strNumeProdus; ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Nume Utilizator:</td>
							<td width="450"><?php echo $strNumeUtilizator; ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Data Comentariu:</td>
							<td width="450"><?php echo $strData; ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250" valign="top">Comentariu:</td>
							<td width="450"><?php echo nl2br($strComentariu); ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Aprobat?</td>
							<td width="450"><?php echo $strAprobat; ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Aproba/Dezaproba:</td>
							<td width="450"><?php echo $strLinkAproba; ?></td>
						</tr>
						
						<tr bgcolor="#C1C1FF">
							<td align="center" colspan="2">
								<a href="comments.php" class="genLink" style="width: 100px;"> &nbsp; Inapoi &nbsp; </a><br><br>
								</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>