<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
	$intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';
$intIdUtilizator =isset($_SESSION['intIdUtilizator']) ? $_SESSION['intIdUtilizator'] : '';
?>
<?php fInsertDocType(); ?>
<head>
<title>shopping cart</title>
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
						<h1 class="pageheader">
The contents of the shopping cart</h1>
						<?php if ($intIdUtilizator > 0) { // userul este logat 
							$intIdUtilizator = $_SESSION['intIdUtilizator'];
							$strIdSesiune = session_id();
							$strSQL = "SELECT tcos.*, tproduse.fNumeProdus, tproduse.fPret FROM tcos, tproduse WHERE tcos.fIdProdus=tproduse.fIdProdus AND fIdUtilizator=$intIdUtilizator AND fIdSesiune='$strIdSesiune'";
							$result = mysql_query($strSQL);
							$itemsno = mysql_num_rows($result);
							if ($itemsno > 0) { // utilizatorul are produse in cos
								echo "<table style=\"width: 100%; background-color: #FFFFFF; border: 2px #B1C9B1 solid; font-size: 9pt;\"><tr><td>\n";
								echo "<form action=\"execute.php?action=updatecart\" method=\"post\" style=\"display: inline;\">\n";
								echo "<fieldset style=\"border: 0px;\">\n";
								echo "<table style=\"width: 100%; border: 0px;\"><tr><td>\n";
								echo "<tr style=\"font-size: 9pt; font-weight: bold;\">\n";
								echo "<td>Product name</td>\n";
								echo "<td>Amount</td>\n";
								echo "<td>Unit price</td>\n";
								echo "<td>Total</td>\n";
								echo "</tr>\n";
								$intIndex = 1;
								$intTotalCos = 0;
								while ($row = mysql_fetch_array($result)) {
									$intTotalProdus = 0;
									$intIndex = 3 - $intIndex;
									$intIdProdus = $row['fIdProdus'];
									$strNumeProdus = $row['fNumeProdus'];
									$intCantitate = $row['fCantitate'];

									//start check for promo
									/*$strToday = date("Ymd");
									$strSQLPromo = "SELECT * FROM tpromotii WHERE fIdProdus=$intIdProdus AND (fDataInceput <= '$strToday') AND (fDataSfarsit >= '$strToday')";
									$resultPromo = mysql_query($strSQLPromo);
									if (mysql_num_rows($resultPromo) > 0) { //produsul este in promotie
										$rowPromo = mysql_fetch_array($resultPromo);
										$intPret = $rowPromo['fPretRedus'];
									} else { // produsul nu este in promotie
                                                                         */
										$intPret = $row['fPret'];
									//}
									$intTotalProdus = ($intPret * 1.19) * $intCantitate;
									//end check for promo									
									if ($intIndex == 1) {
										echo "<tr class=\"cartrow1\">\n";
									} else {
										echo "<tr class=\"cartrow2\">\n";
									}									
									echo "<td style=\"text-align: left;\">$strNumeProdus</td>\n";
									echo "<td><input type=\"text\" maxlength=\"3\" onkeypress=\"return numeralsOnly(event)\" class=\"qtyText\" value=\"$intCantitate\" id=\"txt$intIdProdus\" name=\"txt$intIdProdus\" /> <input type=\"button\" class=\"delcartbutton\" value=\"Sterge\" onclick=\"if (confirm('Doriti sa stergeti acest produs din cos ?')) { location.href='execute.php?action=delfromcart&amp;intIdProdus=$intIdProdus'; } \" /></td>\n";
									echo "<td>$intPret RON</td>\n";
									echo "<td>$intTotalProdus RON</td>\n";
									echo "</tr>\n";
									$intTotalCos = $intTotalCos + $intTotalProdus;
								}
								echo "<tr>\n";
								echo "<td>&nbsp;</td>\n";
								echo "<td><input type=\"submit\" class=\"updatebutton\" value=\"Updated\" /></td>\n";
								echo "<td style=\"font-size: 7.5pt;\">RON fara TVA</td>\n";
								echo "<td style=\"font-size: 7.5pt;\">RON cu TVA</td>\n";
								echo "</tr>\n";

								echo "<tr style=\"font-weight: bold;\">\n";
								echo "<td class=\"cartrow2\" style=\"font-size: 10pt; text-align: right;\" colspan=\"4\">Total (including VAT): $intTotalCos RON</td>\n";
								echo "</tr>\n";

								echo "<tr>\n";
								echo "<td colspan=\"4\"><input type=\"button\" class=\"emptycartbutton\" value=\"Empty shopping cart\" onclick=\"if (confirm('You want to delete the contents of the basket ?')) { location.href='execute.php?action=emptycart'; } \"/></td>\n";
								echo "</tr>\n";

								echo "</table>\n";
								echo "</fieldset>\n";
								echo "</td></tr></table>\n";
								echo "<br />";
								echo "</form>\n";
								//campuri comanda

								$strSQL = "SELECT * FROM tutilizatori WHERE fIdUtilizator=$intIdUtilizator";
								$result = mysql_query($strSQL);
								$row = mysql_fetch_array($result);
								$strNumeCumparator = $row['fNumeUtilizator'];
								$strEmailCumparator = $row['fEmail'];
								$strAdresaCumparator = $row['fAdresa'];

								echo "<form name=\"frmComanda\" id=\"frmComanda\" method=\"post\" action=\"confirmation.php\"  onsubmit=\"return fValidareComanda();\">";
								echo "<table style=\"width: 100%; background-color: #FFFFFF; border: 2px #B1C9B1 solid; font-size: 9pt;\"><tr><td>\n";

								
								echo "<tr>";
								echo "<td width=\"35%\" align=\"right\"><b>Buyer Name:</td>";
								echo "<td align=\"left\">";
								echo "<input type=\"text\" name=\"txtNumeCumparator\" id=\"txtNumeCumparator\" value=\"$strNumeCumparator\" class=\"qtyText\" maxlength=\"255\" style=\"text-align: left; width: 300px;\">";
								echo "</td>";
								echo "</tr>";

								echo "<tr>";
								echo "<td width=\"35%\" align=\"right\"><b>Email adress:</td>";
								echo "<td align=\"left\">";
								echo "<input type=\"text\" name=\"txtEmailCumparator\" id=\"txtEmailCumparator\" value=\"$strEmailCumparator\" class=\"qtyText\" maxlength=\"255\" style=\"text-align: left; width: 300px;\">";
								echo "</td>";
								echo "</tr>";

								echo "<tr>";
								echo "<td width=\"35%\" align=\"right\"><b>Email Address Confirmation:</td>";
								echo "<td align=\"left\">";
								echo "<input type=\"text\" name=\"txtEmailCumparator2\" id=\"txtEmailCumparator2\" value=\"$strEmailCumparator\" class=\"qtyText\" maxlength=\"255\" style=\"text-align: left; width: 300px;\">";
								echo "</td>";
								echo "</tr>";

								echo "<tr>";
								echo "<td width=\"35%\" align=\"right\" valign=\"top\"><b>Adress:</td>";
								echo "<td align=\"left\">";
								echo "<textarea name=\"txtAdresaCumparator\" id=\"txtAdresaCumparator\" class=\"qtyText\" style=\"text-align: left; width: 300px; height: 100px\">$strAdresaCumparator</textarea>";
								echo "</td>";
								echo "</tr>";

								echo "<tr><td colspan=\"2\">";
								echo "<input type=\"submit\" class=\"loginbutton\" value=\"Order the products\">";
								echo "</td></tr>";

								echo "</table>";
								echo "</form>\n";
							} else { // utilizatorul nu are nici un produs in cos
								echo "<p style=\"font-size: 9pt; font-weight: bold; text-align: center;\">Your shopping cart is empty.</p>\n";
							}
						?>
						<?php } else { // userul nu este logat ?>
						<p style="font-size: 9pt; color: red; font-weight: bold; text-align: center;">
						
Error ! To access the shopping cart you must log in.
						</p>
						<?php } ?>
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