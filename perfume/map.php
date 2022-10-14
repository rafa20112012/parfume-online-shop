<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
	$intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';


	$strSQL = "SELECT * FROM tcategorii";
		$result = mysql_query($strSQL);
		$strTitle = "Product categories: ";
		$bFirst = true;
		while ($row = mysql_fetch_array($result)) {
			if (!$bFirst) {
				$strTitle .= ", ";
			} else {
				$bFirst = false;
			}
			$strTitle .= $row['fNumeCategorie'];
		}
?>
<?php fInsertDocType(); ?>
<head>
<title>Harta site</title>
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
						<h1 class="pageheader">Site map</h1>
						<p class="pagecontent">
						<?php
						$strSQL = "SELECT * FROM tcategorii";
						$result = mysql_query($strSQL);
						if (mysql_num_rows($result) > 0) { // afiseaza categoriile
							echo "<table style=\"width: 100%; background-color: #FFFFFF; border: 2px #B1C9B1 solid; font-size: 9pt;\">\n";
							$intIndex = 1;
							while ($row = mysql_fetch_array($result)) {
								$intIndex = 3 - $intIndex;
								$intIdCategorie = $row['fIdCategorie'];
								$strNumeCategorie = $row['fNumeCategorie'];
								$strSQLSub = "SELECT * FROM tsubcategorii WHERE fIdCategorie=$intIdCategorie";
								$resultSub = mysql_query($strSQLSub);
								if ($intIndex == 1) {
									echo "<tr class=\"categlistrow1\">\n";
								} else {
									echo "<tr class=\"categlistrow2\">\n";
								}
								echo "<td style=\"width: 200px; text-align: left;\"><a class=\"ProdNameLink\" href=\"categories.php?intIdCategorie=$intIdCategorie\">$strNumeCategorie</a></td>\n";

								echo "<td style=\"vertical-align: top; text-align: justify; padding: 10px;\">\n";
								echo "<table width=\"100%\" border=\"0\">";
								// start afisare subcategorii
								if (mysql_num_rows($resultSub) > 0) { // exista subcategorii
									while ($rowSub = mysql_fetch_array($resultSub)) {
										echo "<tr>";
										$intIdSubcategorie = $rowSub['fIdSubcategorie'];
										$strNumeSubcategorie = $rowSub['fNumeSubcategorie'];
										echo "<td width=\"50%\">";
										echo "<a class=\"ProdNameLink\" href=\"subcategories.php?intIdSubcategorie=$intIdSubcategorie\">$strNumeSubcategorie</a><br />\n";
										echo "</td>";
										echo "<td>";
										$strSQLProduse = "SELECT * FROM tproduse WHERE fIdSubcategorie=$intIdSubcategorie";
										$resultProduse = mysql_query($strSQLProduse);
										if (mysql_num_rows($resultProduse) > 0) {
											//exista produse
											while ($rowProduse = mysql_fetch_array($resultProduse)) {
												$intIdProdus = $rowProduse['fIdProdus'];
												$strNumeProdus = $rowProduse['fNumeProdus'];
												echo "<a class=\"ProdNameLink\" href=\"product_details.php?intIdProdus=$intIdProdus\">$strNumeProdus</a><br />\n";
											}
										} else {
											//nu exista produse
											echo "&nbsp;";
										}
										echo "</td>";
										echo "</tr>";
									}
								} else { // nu exista subcategorii
									echo "&nbsp;";
								}
								echo "</table>";
								// end afisare subcategorii
								echo " </td>\n";

								echo "</tr>\n";
							}
							echo "</table>\n";
						}
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