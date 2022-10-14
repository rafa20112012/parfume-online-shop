<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
	$intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';
$intIdUtilizator =isset($_SESSION['intIdUtilizator']) ? $_SESSION['intIdUtilizator'] : '';

	$intIdProdus = $_GET['intIdProdus'];
	$strSQL = "SELECT tproducatori.*, tproduse.*, tsubcategorii.*, tcategorii.* FROM ((tproduse INNER JOIN tsubcategorii ON tproduse.fIdSubcategorie = tsubcategorii.fIdSubcategorie) INNER JOIN tcategorii ON tsubcategorii.fIdCategorie = tcategorii.fIdCategorie) INNER JOIN tproducatori ON tproduse.fIdProducator = tproducatori.fIdProducator WHERE tproduse.fIdProdus=$intIdProdus";
	$result = mysql_query($strSQL);
	if (mysql_num_rows($result) > 0) {
		$row = mysql_fetch_array($result);
		$strName = $row['fNumeProdus'];
		$strNormalPrice = $row['fPret'];
		$strSpecs = $row['fSpecificatii'];
		$strDescription = $row['fDescriere'];
		$strImage = $row['fImagine'];
		//$intLuniGarantie = $row['fLuniGarantie'];

		$intIdCategorie = $row['fIdCategorie'];
		$strNumeCategorie = $row['fNumeCategorie'];

		$intIdSubcategorie = $row['fIdSubcategorie'];
		$strNumeSubcategorie = $row['fNumeSubcategorie'];

		$intIdProducator = $row['fIdProducator'];
		$strNumeProducator = $row['fNumeProducator'];

		/*$strToday = date("Ymd");
		$strSQLPromo = "SELECT * FROM tpromotii WHERE fIdProdus=$intIdProdus AND (fDataInceput <= '$strToday') AND (fDataSfarsit >= '$strToday')";
		$resultPromo = mysql_query($strSQLPromo);
		if (mysql_num_rows($resultPromo) > 0) { // produsul se afla in promotie
			$bHasPromo = true;
			$rowPromo = mysql_fetch_array($resultPromo);
			$strPromoPrice = $rowPromo['fPretRedus'];
		} else { // produsul nu se afla in promotie
			$bHasPromo = false;
		}*/
	} else { // produsul nu a fost gasit
		$strName = "The product is not available";
	}

?>
<?php fInsertDocType(); ?>
<head>
<title><?php echo $strName; ?></title>
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
						<tr><td style="text-align: left;">
						<!--START CONTENT-->
						<?php if ($strName != "The product is not available") { ?>
						<div id="path">
						<a class="BottomLink" href="index.php">Acasa</a> &nbsp; &nbsp; | &nbsp; &nbsp; 
						<a class="BottomLink" href="categories.php?intIdCategorie=<?php echo $intIdCategorie; ?>"><?php echo $strNumeCategorie; ?></a> &nbsp; &nbsp; | &nbsp; &nbsp; 
						<a class="BottomLink" href="subcategories.php?intIdSubcategorie=<?php echo $intIdSubcategorie; ?>"><?php echo $strNumeSubcategorie; ?></a> &nbsp; &nbsp; | &nbsp; &nbsp; 
						<a class="BottomLink" href="production.php?intIdProducator=<?php echo $intIdProducator; ?>"><?php echo $strNumeProducator; ?></a>
						</div>
						<h1 class="pageheader"><?php echo $strName; ?></h1>
						<table style="width: 100%; background-color: #FFFFFF; border: 2px #B1C9B1 solid;">
							<tr>
								<td style="text-align: center; vertical-align: middle; width: 50%;"><img alt="<?php echo $strName; ?>" src="./images/products/<?php echo $strImage; ?>" /></td>
								<td style="font-size: 9pt; vertical-align: top; text-align: right; padding-top: 15px; padding-right: 15px;">
								<?php 



                                                                        echo "Price without VAT: $strNormalPrice RON<br />\n";
									echo "Price with VAT: " . round(($strNormalPrice * 1.19),2) . "RON<br />\n";
								echo "<br /><br />";
								echo "<form action=\"execute.php?action=addtocart\" method=\"post\" style=\"display: inline;\">\n";
								echo "<fieldset style=\"padding: 0px; border: 0px;\">\n";
								echo "<input type=\"hidden\" name=\"hddIntIdProdus\" value=\"$intIdProdus\" />";
								echo "<input type=\"submit\" alt=\"Add to shopping cart\" class=\"loginbutton\" name=\"cmdAddToCart\" id=\"cmdAddToCart\" value=\"Add to shopping cart\" />\n";
								echo "</fieldset>\n";
								echo "</form>\n";
								?>								
								</td>
							</tr>
							<tr>
								<td colspan="2"><hr style="background-color: #B1C9B1; color: #B1C9B1; height: 1px; border: 1px solid #B1C9B1;"/></td>
							</tr>
							<tr>
								<td colspan="2" style="font-size: 9pt;"><span style="font-weight: bold;">Description :</span><br /><?php echo $strDescription; ?></td>
							</tr>
							<tr>
								<td colspan="2"><hr style="background-color: #B1C9B1; color: #B1C9B1; height: 1px; border: 1px solid #B1C9B1;"/></td>
							</tr>
							<tr>
								<td colspan="2" style="font-size: 9pt;"><span style="font-weight: bold;">Product specifications :</span	><br /><?php echo nl2br($strSpecs); ?></td>
							</tr>

							<tr>
								<td colspan="2"><hr style="background-color: #B1C9B1; color: #B1C9B1; height: 1px; border: 1px solid #B1C9B1;"/></td>
							</tr>
							<tr>
								<td colspan="2" style="font-size: 9pt;"><span style="font-weight: bold;">Vote for this product:</span	><br />
								<?php
								if ($intIdUtilizator > 0) { // utilizatorul este logat									
									$strSQL = "SELECT * FROM tvoturi WHERE fIdProdus=$intIdProdus AND fIdUtilizator=$intIdUtilizator";
									$result = mysql_query($strSQL);
									if (mysql_num_rows($result) > 0) { // utilizatorul a votat deja acest produs, se afiseaza rezultatele
										$strSQL = "SELECT SUM(fValoareVot) as totalsum FROM tvoturi WHERE fIdProdus=$intIdProdus";
										$result = mysql_query($strSQL);
										$row = mysql_fetch_array($result);
										$totalsum = $row['totalsum'];

										$strSQL = "SELECT COUNT(*) as numrows FROM tvoturi WHERE fIdProdus=$intIdProdus";
										$result = mysql_query($strSQL); 
										$row = mysql_fetch_array($result);
										$numar_voturi = $row['numrows'];

										$voteresult = round($totalsum / $numar_voturi, 2);

										echo "You have already voted for this product.<br />";
										echo "Result of votes: $voteresult";
									} else { // utilizatorul nu a votat acest produs, se afiseaza formularul de vot
										echo "<form action=\"execute.php?action=voteproduct\" method=\"post\" style=\"display: inline;\">\n";
										echo "<fieldset style=\"padding: 0px; border: 0px;\">\n";
										echo "<input type=\"hidden\" name=\"hddIntIdProdus\" value=\"$intIdProdus\" />";
										echo "<select name=\"selVoteValue\">\n";
										echo "<option value=\"1\">1</option>\n";
										echo "<option value=\"2\">2</option>\n";
										echo "<option value=\"3\">3</option>\n";
										echo "<option value=\"4\">4</option>\n";
										echo "<option value=\"5\" selected=\"selected\">5</option>\n";
										echo "<option value=\"6\">6</option>\n";
										echo "<option value=\"7\">7</option>\n";
										echo "<option value=\"8\">8</option>\n";
										echo "<option value=\"9\">9</option>\n";
										echo "<option value=\"10\">10</option>\n";

										echo "</select>\n";
										echo "<input type=\"submit\" alt=\"Add to shopping cart\" class=\"updatebutton\" name=\"cmdVote\" id=\"cmdVote\" value=\"Vote for this product\" />\n";
										echo "</fieldset>\n";
										echo "</form>\n";
									}
								} else { // utilizatorul nu este logat
									echo "In order to vote for this product, you must log in.";
								}									
								?>
								</td>
							</tr>

							<tr>
								<td colspan="2"><hr style="background-color: #B1C9B1; color: #B1C9B1; height: 1px; border: 1px solid #B1C9B1;"/></td>
							</tr>
							
							
						</table>
						<?php } else { ?>
						<h1 class="pageheader"><?php echo $strName; ?></h1>
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