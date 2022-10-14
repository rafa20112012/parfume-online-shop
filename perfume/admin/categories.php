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
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;">Administration section :: Category administration</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
					<br> &nbsp; &nbsp; &nbsp; <a class="genLinkReverse" href="addcategory.php">Add category</a><hr>
					<?php
						$strSQL = "SELECT * FROM tcategorii";
						$result = mysql_query($strSQL);
						echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"600\" class=\"modelspecs\">\n";
						$intCount = 0;
						echo "<tr align=\"center\" style=\"font-weight: bold;\">";
						echo "<td width=\"300\">Name category</td>";
						echo "<td width=\"100\">Subcategory</td>";
						echo "<td width=\"100\">Edit</td>";
						echo "<td width=\"100\">Clear</td>";
						echo "</tr>";
						while ($row = mysql_fetch_array($result)) {
							$intIdCategorie = $row['fIdCategorie'];
							$strNume = $row['fNumeCategorie'];

							if ($intCount % 2 == 0) {
								echo "<tr bgcolor=\"#C1C1FF\">";
							} else {
								echo "<tr bgcolor=\"#C1C1FF\">";
							}
							echo "<td width=\"300\"><b>$strNume</b></td>\n";
							echo "<td align=\"center\" width=\"100\"><a href=\"subcategories.php?intIdCategorie=$intIdCategorie\"><img src=\"../images/details.gif\" border=\"0\"></a></td>\n";
							echo "<td align=\"center\" width=\"100\"><a href=\"editcategory.php?intIdCategorie=$intIdCategorie\"><img src=\"../images/edit.gif\" border=\"0\"></a></td>\n";
							echo "<td align=\"center\" width=\"100\"><a onclick=\"return confirmSubmit('Confirmati stergerea categoriei?')\" href=\"execute.php?action=stergerecategorie&intIdCategorie=$intIdCategorie\"><img src=\"../images/delete.gif\" border=\"0\"></a></td>\n";
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