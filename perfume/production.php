<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
	$intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';

	$intIdProducator = isset($_GET['intIdProducator'])? $_GET['intIdProducator'] : '';

	$strSQL = "SELECT fNumeProducator FROM tproducatori WHERE fIdProducator=$intIdProducator";

	$result = mysql_query($strSQL);
	if (mysql_num_rows($result) > 0) { // subcategorie valida
		$row = mysql_fetch_array($result);
		$strNumeProducator = $row['fNumeProducator'];
		$strTitle = "Products from  $strNumeProducator";
	} else { // subcategorie invalida
		$strTitle = "There are no products ";
	}

?>
<?php fInsertDocType(); ?>
<head>
<title><?php echo $strTitle; ?></title>
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
						<div id="path">
						<a class="BottomLink" href="index.php">Acasa</a>
						</div>
						<h1 class="pageheader"><?php echo  $strTitle; ?></h1>
<?php

$strToday = date("Ymd");
$strSQL = "SELECT * FROM tproduse WHERE fIdProducator=$intIdProducator";

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

		echo " <div class=\"responsive\"><div class=\"gallery\">";
			
			echo "<a href=\"product_details.php?intIdProdus=$intIdProdus\"><center><img alt=\"$strNumeProdus\" src=\"./images/products/$strImagine\" style=\"width: 240px; height: 200px; border: 2px #B1C9B1 solid;\" /></a>";
			 echo "<div class=\"desc\"><a class=\"ProdNameLink\" href=\"product_details.php?intIdProdus=$intIdProdus\">$strNumeProdus</a></div>";
			//echo "<span>$strDescriere</span><br /><br />\n";

			
				echo "Price without VAT: $strNormalPrice RON<br />";
				echo "Price with VAT" . round(($strNormalPrice * 1.19),2) . "RON<br />";
			

			echo "<br /><form action=\"execute.php?action=addtocart\" method=\"post\" style=\"display: inline;\">";
			echo "<fieldset style=\"padding: 0px; border: 0px;\">";
			echo "<input type=\"hidden\" name=\"hddIntIdProdus\" value=\"$intIdProdus\" />";
			echo "<input type=\"submit\" alt=\"Add to shopping cart\" class=\"loginbutton\" name=\"cmdAddToCart\" value=\"Add to shopping cart\" />";
			echo "</fieldset>";
			echo "</form></div>";

			echo "</div></div>";
	}
	echo "</table>\n";
} else { // nu exista produse in promotie
	echo "<p style=\"font-size: 9pt; font-weight: bold; text-align: center;\">Sorry, there are currently no products.</p>\n";
}

?>
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
			

			<?php fInsertBottomStdText(); ?>
			</td>
		</tr>
	</table>

</body>
</html>
<?php fDBClose($myConn); ?>