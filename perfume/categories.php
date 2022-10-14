<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
	$intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';
$mode = isset($_GET['mode'])? $_GET['mode'] : '';
	if ($mode == "main") { // afiseaza categoriile si subcategoriile
		$strSQL = "SELECT * FROM tcategorii";
		$result = mysql_query($strSQL);
		$strTitle = "Product categories : ";
		$bFirst = true;
		while ($row = mysql_fetch_array($result)) {
			if (!$bFirst) {
				$strTitle .= ", ";
			} else {
				$bFirst = false;
			}
			$strTitle .= $row['fNumeCategorie'];
		}
	} else { // afiseaza categoria selectata
		$intIdCategorie = isset($_GET['intIdCategorie'])? $_GET['intIdCategorie'] : '';
		$strSQL = "SELECT fNumeCategorie FROM tcategorii WHERE fIdCategorie=$intIdCategorie";
		$result = mysql_query($strSQL);
		if (mysql_num_rows($result) > 0) { // categorie valida
			$row = mysql_fetch_array($result);
			$strNumeCategorie = $row['fNumeCategorie'];
			$strTitle = "Products from the category $strNumeCategorie";
		} else { // categorie invalida
			$strNumeCategorie = "Invalid Category";
			$strTitle = "Invalid Category";
		}
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
						<?php if ($mode != "main")  { ?>
						<div id="path">
						<a class="BottomLink" href="index.php">Home</a> &nbsp; &nbsp; | &nbsp; &nbsp; 
						<a class="BottomLink" href="categories.php?intIdCategorie=<?php echo $intIdCategorie; ?>"><?php echo $strNumeCategorie; ?></a> &nbsp; &nbsp; | &nbsp; &nbsp; 
						</div>
						<?php } ?>
						<h1 class="pageheader"><?php echo  $strTitle; ?></h1>
<?php

if ($mode == "main") { // afiseaza categoriile si subcategoriile
	$strSQL = "SELECT * FROM tcategorii";
	$result = mysql_query($strSQL);
	if (mysql_num_rows($result) > 0) { // afiseaza categoriile
		echo "<table style=\"width: 100%; background-color: #FFFFFF; border: 2px #B1C9B1  solid; font-size: 9pt;\">\n";
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
			// start afisare subcategorii
			if (mysql_num_rows($resultSub) > 0) { // exista subcategorii
				while ($rowSub = mysql_fetch_array($resultSub)) {
					$intIdSubcategorie = $rowSub['fIdSubcategorie'];
					$strNumeSubcategorie = $rowSub['fNumeSubcategorie'];
					echo "<a class=\"ProdNameLink\" href=\"subcategories.php?intIdSubcategorie=$intIdSubcategorie\">$strNumeSubcategorie</a><br />\n";
				}
			} else { // nu exista subcategorii
				echo "There are no subcategories.";
			}
			// end afisare subcategorii
			echo " </td>\n";

			echo "</tr>\n";
		}
		echo "</table>\n";
	} else {
		echo "<p style=\"font-size: 9pt; font-weight: bold; text-align: center;\">Sorry, there are currently no categories in the database.</p>\n";
	}
} else { // afiseaza categoria selectata
	$strToday = date("Ymd");
	$strSQL = "SELECT tproduse.*, tcategorii.fIdCategorie FROM (tproduse INNER JOIN tsubcategorii ON tproduse.fIdSubcategorie = tsubcategorii.fIdSubcategorie) INNER JOIN tcategorii ON tsubcategorii.fIdCategorie = tcategorii.fIdCategorie where tcategorii.fIdCategorie=$intIdCategorie";

	$result = mysql_query($strSQL);
	if (mysql_num_rows($result) > 0) { // exista produse in promotie
		echo "<table style=\"width: 100%; background-color: #FFFFFF; border: 2px #B1C9B1 solid; font-size: 9pt;\">";
		$i = 1;
		while ($row = mysql_fetch_array($result)) {
			$i =$i+1;
			$intIdProdus = $row['fIdProdus'];
			$strNumeProdus = $row['fNumeProdus'];
			$strDescriere = $row['fDescriere'];
			$strImagine = $row['fImagine'];
			$strNormalPrice = $row['fPret'];

			$strToday = date("Ymd");
			
echo " <div class=\"responsive\"><div class=\"gallery\">";
			
			echo "<a href=\"product_details.php?intIdProdus=$intIdProdus\"><center><img alt=\"$strNumeProdus\" src=\"./images/products/$strImagine\" style=\"width: 240px; height: 200px; border: 2px #B1C9B1 solid;\" /></a>";
			 echo "<div class=\"desc\"><a class=\"ProdNameLink\" href=\"product_details.php?intIdProdus=$intIdProdus\">$strNumeProdus</a></div>";
			//echo "<span>$strDescriere</span><br /><br />\n";

			
				echo "Price without VAT: $strNormalPrice RON<br />";
				echo "Price with VAT: " . round(($strNormalPrice * 1.19),2) . "RON<br />";
			

			echo "<br /><form action=\"execute.php?action=addtocart\" method=\"post\" style=\"display: inline;\">";
			echo "<fieldset style=\"padding: 0px; border: 0px;\">";
			echo "<input type=\"hidden\" name=\"hddIntIdProdus\" value=\"$intIdProdus\" />";
			echo "<input type=\"submit\" alt=\"Adauga in cos\" class=\"loginbutton\" name=\"cmdAddToCart\" value=\"Add to shopping cart\" />";
			echo "</fieldset>";
			echo "</form></div>";

			echo "</div></div>";
		}
		echo "</table>\n";
	} else { // nu exista produse in promotie
		echo "<p style=\"font-size: 9pt; font-weight: bold; text-align: center;\">
Sorry, there are currently no products in this category.</p>\n";
	}
}
?>
						<!--END CONTENT-->
						</td></tr>
						</table>
						<!--END MAIN CONTENT-->
						
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