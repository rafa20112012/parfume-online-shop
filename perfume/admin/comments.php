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
		<table cellpadding="0" cellspacing="0" border="1" width="100%" height="100%">
			<tr style="height: 50px; width: 100%;">
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;">Sectiunea de administrare :: Administrare comentarii</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
					<?php
						$strSQL = "SELECT tcomentarii.*, tproduse.fNumeProdus, tutilizatori.fNumeUtilizator FROM tcomentarii, tproduse, tutilizatori WHERE tcomentarii.fIdProdus=tproduse.fIdProdus AND tcomentarii.fIdUtilizator=tutilizatori.fIdUtilizator";
						$result = mysql_query($strSQL);
						echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"700\" class=\"modelspecs\">\n";
						$intCount = 0;
						echo "<tr align=\"center\" style=\"font-weight: bold;\">";
						echo "<td width=\"200\">Utilizator</td>";
						echo "<td width=\"200\">Produs</td>";
						echo "<td width=\"100\">Aprobat?</td>";
						echo "<td width=\"100\">Aproba/Dezaproba</td>";
						echo "<td width=\"100\">Detalii</td>";
						echo "<td width=\"100\">Stergere</td>";
						echo "</tr>";
						while ($row = mysql_fetch_array($result)) {
							$intIdComentariu = $row['fIdComentariu'];
							$intIdProdus = $row['fIdProdus'];
							$intIdUtilizator = $row['fIdUtilizator'];
							$strNumeUtilizator = $row['fNumeUtilizator'];
							$strNumeProdus = $row['fNumeProdus'];
							$intAprobat = $row['fAprobat'];
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

							if ($intCount % 2 == 0) {
								echo "<tr bgcolor=\"#C1C1FF\">";
							} else {
								echo "<tr bgcolor=\"#C1C1FF\">";
							}
							echo "<td align=\"center\" width=\"200\"><a target=\"_blank\" class=\"genLinkReverse\" href=\"userdetails.php?intIdUtilizator=$intIdUtilizator\">$strNumeUtilizator</a></td>\n";
							echo "<td align=\"center\" width=\"200\"><a target=\"_blank\" class=\"genLinkReverse\" href=\"productdetails.php?intIdProdus=$intIdProdus\">$strNumeProdus</a></td>\n";

							echo "<td align=\"center\" width=\"100\">$strAprobat</td>\n";
							echo "<td align=\"center\" width=\"100\">$strLinkAproba</td>\n";
							
							echo "<td align=\"center\" width=\"100\"><a  href=\"detailcomments.php?intIdComentariu=$intIdComentariu\"><img src=\"../images/view.gif\" border=\"0\"></a></td>\n";

							echo "<td align=\"center\" width=\"100\"><a onclick=\"return confirmSubmit('Confirmati stergerea comentariului?')\" href=\"execute.php?action=stergerecomentariu&intIdComentariu=$intIdComentariu\"><img src=\"../images/delete.gif\" border=\"0\"></a></td>\n";
							echo "</tr>\n";
							$intCount++;
						}
						echo "</table>\n";
					?>
				</td>
			</tr>
		</table>
	</body>
</html>