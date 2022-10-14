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
	$intIdProducator = isset($_GET['intIdProducator'])? $_GET['intIdProducator'] : '';

$intIdSubcategorie  = isset($_GET['intIdSubcategorie'])? $_GET['intIdSubcategorie'] : '';
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
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;"> Administration section :: Product administration</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
					<br> &nbsp; &nbsp; &nbsp; <a class="genLinkReverse" href="addproduct.php">Add product</a><hr>
					<?php
						$strSQL = "SELECT tproduse.*, tsubcategorii.fNumeSubcategorie, tproducatori.fNumeProducator, tcategorii.fIdCategorie, tcategorii.fNumeCategorie FROM tproduse, tproducatori, tcategorii, tsubcategorii WHERE tproduse.fIdProducator=tproducatori.fIdProducator AND tproduse.fIdSubcategorie=tsubcategorii.fIdSubcategorie AND tcategorii.fIdCategorie=tsubcategorii.fIdCategorie ";
						if ($intIdProducator > 0) {
							$strSQL .= " AND tproduse.fIdProducator=$intIdProducator ";
						}
						if ($intIdSubcategorie > 0) {
							$strSQL .= " AND tproduse.fIdSubcategorie=$intIdSubcategorie ";
						}
						$result = mysql_query($strSQL);
						echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"1100\" class=\"modelspecs\">\n";
						$intCount = 0;
						echo "<tr style=\"font-weight: bold;\">";
						echo "<td width=\"200\">Product name</td>";
						echo "<td width=\"200\">Producer</td>";
						echo "<td width=\"200\">Category</td>";
						echo "<td width=\"200\">Subcategory</td>";
						echo "<td align=\"center\" width=\"100\">Details</td>";
						echo "<td align=\"center\" width=\"100\">Edit</td>";
						echo "<td align=\"center\" width=\"100\">Clear</td>";
						echo "</tr>";
						while ($row = mysql_fetch_array($result)) {
							$intIdProdus = $row['fIdProdus'];
							$intIdProducator = $row['fIdProducator'];
							$intIdCategorie = $row['fIdCategorie'];
							$intIdSubcategorie = $row['fIdSubcategorie'];
							$strNumeProdus = $row['fNumeProdus'];
							$strNumeCategorie = $row['fNumeCategorie'];
							$strNumeSubcategorie = $row['fNumeSubcategorie'];
							$strNumeProducator = $row['fNumeProducator'];

							if ($intCount % 2 == 0) {
								echo "<tr bgcolor=\"#C1C1FF\">";
							} else {
								echo "<tr bgcolor=\"#C1C1FF\">";
							}
							echo "<td width=\"200\"><b>$strNumeProdus</b></td>\n";
							echo "<td width=\"200\"><b><a target=\"_blank\" class=\"genLinkReverse\" href=\"manufacturerdetails.php?intIdProducator=$intIdProducator\">$strNumeProducator</a></b></td>\n";
							echo "<td width=\"200\"><b>$strNumeCategorie</b></td>\n";
							echo "<td width=\"200\"><b>$strNumeSubcategorie</b></td>\n";

							echo "<td align=\"center\" width=\"100\"><a href=\"productdetails.php?intIdProdus=$intIdProdus\"><img src=\"../images/view.gif\" border=\"0\"></a></td>\n";
							echo "<td align=\"center\" width=\"100\"><a href=\"editproduct.php?intIdProdus=$intIdProdus\"><img src=\"../images/edit.gif\" border=\"0\"></a></td>\n";
							echo "<td align=\"center\" width=\"100\"><a onclick=\"return confirmSubmit('Confirm the deletion of the product?')\" href=\"execute.php?action=stergereprodus&intIdProdus=$intIdProdus\"><img src=\"../images/delete.gif\" border=\"0\"></a></td>\n";
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