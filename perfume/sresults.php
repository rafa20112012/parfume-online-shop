<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
	$intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';
?>
<?php fInsertDocType(); ?>
<head>
<title>Search results</title>
<?php fInsertMetaTags(); ?>
<?php fInsertCSS(); ?>
<?php fInsertJS(); ?>
</head>
<body>

	<table class="maintable">
		
<tr><td><?php fInsertCategLeftMenu();?> 

<?php fInsertLoginArea(); ?> </td></tr>

<tr style="height: 200px;">
			<td id="header">
			<table id="cart">
				<tr>
				<td>
				<a href="shopping_cart.php"><img alt="Cosul de cumparaturi" src="./images/cart.gif" /></a>
				</td>
				</tr>
			</table>
			<!--START TOP MENU-->
			
			<?php fInsertTopMenu(); ?>
			<!--END TOP MENU-->
			</td>


		</tr>


		<tr>
			<td>
				<table class="contenttable">
					<tr>
						<td id="maincontent">
						<!--START MAIN CONTENT-->
						<table style="width: 100%;">
						<tr><td>
						<!--START CONTENT-->
						<h1 class="pageheader">Search results</h1>
						<p class="pagecontent">
						<?php
							$intIdSelSubcateg =isset($_POST['selSubCateg']) ? $_POST['selSubCateg'] : '';

$intIdSelCateg =isset($_POST['intIdSelCateg']) ? $_POST['intIdSelCateg'] : '';
							if ($intIdSelSubcateg > 0) {
								$strSQL = "SELECT tproduse.*, tcategorii.fIdCategorie FROM (tproduse INNER JOIN tsubcategorii ON tproduse.fIdSubcategorie = tsubcategorii.fIdSubcategorie) INNER JOIN tcategorii ON tsubcategorii.fIdCategorie = tcategorii.fIdCategorie where tproduse.fIdSubcategorie=$intIdSelSubcateg";
							} else {
								if ($intIdSelCateg > 0) {
									$strSQL = "SELECT tproduse.*, tcategorii.fIdCategorie FROM (tproduse INNER JOIN tsubcategorii ON tproduse.fIdSubcategorie = tsubcategorii.fIdSubcategorie) INNER JOIN tcategorii ON tsubcategorii.fIdCategorie = tcategorii.fIdCategorie where tcategorii.fIdCategorie=$intIdSelCateg";
								} else {
									$strSQL = "SELECT tproduse.*, tcategorii.fIdCategorie FROM (tproduse INNER JOIN tsubcategorii ON tproduse.fIdSubcategorie = tsubcategorii.fIdSubcategorie) INNER JOIN tcategorii ON tsubcategorii.fIdCategorie = tcategorii.fIdCategorie";
								}
							}

							//-----------------------
							$result = mysql_query($strSQL);
if (mysql_num_rows($result) > 0) { // exista produse in promotie
	echo "<table style=\"width: 100%; background-color: #FFFFFF; border: 2px #B1C9B1 solid; font-size: 9pt;\">\n";
	$intIndex = 1;
	while ($row = mysql_fetch_array($result)) {
		$intIndex = 3 - $intIndex;
		$intIdProdus = $row['fIdProdus'];
		$strNumeProdus = $row['fNumeProdus'];
		$strDescriere = $row['fDescriere'];
		$strImagine = $row['fImagine'];
		$strNormalPrice = $row['fPret'];

		/*$strToday = date("Ymd");
		$strSQLPromo = "SELECT * FROM tpromotii WHERE fIdProdus=$intIdProdus AND (fDataInceput <= '$strToday') AND (fDataSfarsit >= '$strToday')";
		$resultPromo = mysql_query($strSQLPromo);
		$bHasPromo = false;
		if (mysql_num_rows($resultPromo) > 0) { // produsul se afla in promotie
			$bHasPromo = true;
			$rowPromo = mysql_fetch_array($resultPromo);
			$strPromoPrice = $rowPromo['fPretRedus'];
		} else { // produsul nu se afla in promotie
			$bHasPromo = false;
		}*/

		if ($intIndex == 1) {
			echo "<tr class=\"listprodrow1\">\n";
		} else {
			echo "<tr class=\"listprodrow2\">\n";
		}
		echo "<td style=\"width: 150px; text-align: center;\"><a href=\"product_details.php?intIdProdus=$intIdProdus\"><img alt=\"$strNumeProdus\" src=\"./images/products/$strImagine\" style=\"width: 80px; height: 80px; border: 2px #B1C9B1 solid;\" /></a></td>\n";
		echo "<td style=\"vertical-align: top; text-align: justify; padding: 10px;\"><span><a class=\"ProdNameLink\" href=\"product_details.php?intIdProdus=$intIdProdus\">$strNumeProdus</a></span><br /><br />\n";
		echo "<span>$strDescriere</span><br /><br />\n";

		/*if ($bHasPromo == true) { // produsul se afla in promotie
			echo "Pret vechi fara TVA: <span class=\"oldprice\">$strNormalPrice</span> RON<br />\n";
			echo "Pret vechi cu TVA: <span class=\"oldprice\">" . round(($strNormalPrice * 1.19),2) . "</span> RON<br />\n";
			echo "Pret nou fara TVA: <span class=\"normalprice\">$strPromoPrice</span> RON<br />\n";
			echo "Pret nou cu TVA: <span class=\"normalprice\">" . round(($strPromoPrice * 1.19),2) . "</span> RON<br />\n";
		} else { // produsul nu se afla in promotie*/
			echo "Price without VAT: $strNormalPrice RON<br />\n";
			echo "Price with VAT: " . round(($strNormalPrice * 1.19),2) . "RON<br />\n";
		//}

		echo "<br /><form action=\"execute.php?action=addtocart\" method=\"post\" style=\"display: inline;\">\n";
		echo "<fieldset style=\"padding: 0px; border: 0px;\">\n";
		echo "<input type=\"hidden\" name=\"hddIntIdProdus\" value=\"$intIdProdus\" />";
		echo "<input type=\"submit\" alt=\"Add to shopping cart\" class=\"loginbutton\" name=\"cmdAddToCart\" value=\"Add to shopping cart\" />\n";
		echo "</fieldset>\n";
		echo "</form>\n";

		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</table>\n";
} else { // nu exista produse in promotie
	echo "<p style=\"font-size: 9pt; font-weight: bold; text-align: center;\">Sorry, there are currently no products in this category.</p>\n";
}
							//-----------------------
						?>
						</p>
						<!--END CONTENT-->
						</td></tr>
						</table>
						<!--END MAIN CONTENT-->
						</td>
						
					</tr>
				</table>
			</td></tr>
		<tr>
			<td id="footer">
			<!--START BOTTOM MENU-->
			<?php fInsertBottomMenu(); ?>
			<!--END BOTTOM MENU-->
			<?php fInsertBottomStdText(); ?>
			</td>
		</tr>
	</table>

</body>
</html>
<?php fDBClose($myConn); ?>