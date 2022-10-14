<?php
require_once("mysql.inc.php");
//--------------------------------------------------------------------------------------------------------
function fInsertMetaTags() {
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\n";
	echo "<meta name=\"Revisit-after\" content=\"2 days\" />\n";
	echo "<meta name=\"Robots\" content=\"index, follow\" />\n";
	echo "<meta name=\"Description\" content=\"cumpara.ro description\" />\n";
	echo "<meta name=\"Keywords\" content=\"electronice, magazin\" />\n";
	echo "<meta name=\"Language\" content=\"ro\" />\n";
	echo "<meta name=\"Generator\" content=\"editplus\" />\n";
	echo "<meta name=\"Author\" content=\"Radu\" />\n";
	echo "<meta name=\"Copyright\" content=\"copyright 2022\" />\n";
	echo "<meta name=\"Rating\" content=\"General\" />\n";
}
//--------------------------------------------------------------------------------------------------------
function fInsertCSS() {
	echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"./css/style.css\" />\n";
echo "<link type=\"text/css\" rel=\"stylesheet\" href=\"./css/style1.css\" />\n";

}
//--------------------------------------------------------------------------------------------------------
function fInsertJS() {
	echo "<script type=\"text/javascript\" src=\"./js/functions.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"./js/login.js\"></script>\n";
}
//--------------------------------------------------------------------------------------------------------
function fInsertDocType() {
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"     \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
}
//--------------------------------------------------------------------------------------------------------
function fInsertLoginArea() {
	echo "<div id=\"loginarea\">\n";
	$intIdUtilizator =isset($_SESSION['intIdUtilizator']) ? $_SESSION['intIdUtilizator'] : '';
	if ($intIdUtilizator  > 0) { // user is authenticated, display name & logout link
		echo "Welcome " . $_SESSION['strNumeUtilizator'] . " &nbsp; <a class=\"TopMyAccountLink\" href=\"my_account.php\">:: My account</a> &nbsp; | &nbsp; <a class=\"LogoutLink\" href=\"execute.php?action=logout\">:: Output</a>\n";
	} else { // user is not authenticated, display login form
		echo "<form action=\"execute.php?action=login\" method=\"post\" style=\"display: inline;\" onsubmit=\"return fValidateLogin();\">\n";
		echo "<fieldset style=\"padding: 0px; border: 0px;\">\n";
		echo "<label class=\"loginlabel\" for=\"txtNumeUtilizator\">User:</label>\n";
		echo "<input class=\"logininput\" type=\"text\" name=\"txtNumeUtilizator\" id=\"txtNumeUtilizator\" maxlength=\"32\" />\n";
		echo "<label class=\"loginlabel\" for=\"txtParola\">Password:</label>\n";
		echo "<input class=\"logininput\" type=\"password\" name=\"txtParola\" id=\"txtParola\" maxlength=\"32\" />\n";
		echo "<input type=\"submit\" alt=\"Autentificare\" class=\"loginbutton\" name=\"cmdLogin\" id=\"cmdLogin\" value=\"Login\" />\n";
		echo "<input type=\"button\" alt=\"Cont nou\" class=\"loginbutton\" onclick=\"location.href='registration.php'\" name=\"cmdRegister\" id=\"cmdRegister\" value=\"New account\" />\n";
		echo "</fieldset>\n";
		echo "</form>\n";
	}
	echo "</div>\n";
}
//--------------------------------------------------------------------------------------------------------
function fInsertTopMenu() {

$strSQL = "SELECT * FROM tcategorii ORDER BY fIdCategorie";
	$result = mysql_query($strSQL);
	if (mysql_num_rows($result) > 0) { // categories fou

while ($row = mysql_fetch_array($result)) {

echo "<div class=\"dropdown\">\n";

$intIdCategorie = $row['fIdCategorie'];
echo "<a href=\"categories.php?intIdCategorie=" . $row['fIdCategorie'] . "\">  <button class=\"button1\" >  " . $row['fNumeCategorie'] . "</button></a>\n";
		
 $strSQLSub = "SELECT * FROM tsubcategorii WHERE fIdCategorie=$intIdCategorie";
			$resultSub = mysql_query($strSQLSub);
echo "<div class=\"dropdown-content\">\n";

if (mysql_num_rows($resultSub) > 0) { // exista subcategorii

				while ($rowSub = mysql_fetch_array($resultSub)) {
					$intIdSubcategorie = $rowSub['fIdSubcategorie'];
					$strNumeSubcategorie = $rowSub['fNumeSubcategorie'];
				
echo "<a href=\"subcategories.php?intIdSubcategorie=$intIdSubcategorie\">$strNumeSubcategorie</a>\n";
			            }
echo "</div>\n";
echo "</div>\n";  } 

}		
	} else { // no category found
		echo "<div style=\"padding: 10px; text-align: center;\">No product type </div>\n";
	}

	echo "</div>\n";
}
//--------------------------------------------------------------------------------------------------------
function fInsertQuickSearch($intIdCategorieCautare) {
echo "<CENTER><table id=\"searchtable\">\n";
	echo "<tr><td id=\"searchtabletop\"></td></tr>\n";
	echo "<tr><td id=\"searchtablemain\">\n";
	echo "<form action=\"sresults.php\" method=\"post\" style=\"display: inline;\" onsubmit=\"return fValidateQuickSearch();\">\n";
	echo "<fieldset style=\"padding: 0px; border: 0px;\">\n";
	echo "<label class=\"label\" for=\"selCateg\">CATEGORY::</label> ";
	//$_SERVER['PHP_SELF']
	echo "<select onChange=\"document.location='" . $_SERVER['PHP_SELF'] . "?intIdCategorieCautare=' + this.options[this.selectedIndex].value;\" class=\"select\" style=\"width: 200px;\" name=\"selCateg\" id=\"selCateg\">\n";
	echo "<option value=\"0\">Toate</option>\n";
	$strSQL = "SELECT * FROM tcategorii";
	$result = mysql_query($strSQL);
	while ($row = mysql_fetch_array($result)) {
		$intIdCategorie = $row['fIdCategorie'];
		$NumeCategorie = $row['fNumeCategorie'];
		echo "<option value=\"$intIdCategorie\"";
		if ($intIdCategorieCautare == $intIdCategorie) {
			echo " selected ";
		}
		echo ">$NumeCategorie</option><br></br>\n";
	}
	echo "</select><br></br><br></br>\n";
	echo "<label class=\"label\" for=\"selSubCateg\">SUBCATEGORY :</label>";
	echo "<select class=\"select\" style=\"width: 200px;\" name=\"selSubCateg\" id=\"selSubCateg\">\n";
	echo "<option value=\"0\">Toate</option>\n";
	if ($intIdCategorieCautare > 0) {
		$strSQL = "SELECT * FROM tsubcategorii WHERE fIdCategorie=$intIdCategorieCautare";
		$result = mysql_query($strSQL);
		while ($row = mysql_fetch_array($result)) {
			$intIdSubcategorie = $row['fIdSubcategorie'];
			$NumeSubcategorie = $row['fNumeSubcategorie'];
			echo "<option value=\"$intIdSubcategorie\">$NumeSubcategorie</option>\n";
		}
	}
	echo "</select><br /><br /><br></br>\n";
	echo "<input type=\"submit\" alt=\"Perform the quick search\" class=\"buttonsearch\" name=\"cmdSearch\" id=\"cmdSearch\" value=\"SEARCH\" />\n";
	echo "</fieldset>\n";
	echo "</form>\n";
	echo "</td></tr><br></br>\n";
	echo "<tr><td id=\"searchtablebottom\"></td></tr>\n";
	echo "</table>\n";
}
//--------------------------------------------------------------------------------------------------------
function fInsertCategLeftMenu() {

echo "<div class=\"btn-group\">\n";

echo "<a href=\"index.php\"> <button class=\"button\">Home</button></a>\n";
 echo "<a href=\"admin/index.php\"><button class=\"button\">Administration</button></a>\n";
	
echo "<a href=\"search.php\"> <button class=\"button\">Search</button></a>\n";

echo "<a href=\"contact.php\"><button class=\"button\">Contact</button></a>\n";	

}
//--------------------------------------------------------------------------------------------------------
function fInsertInfoLeftMenu() {
	
}
//--------------------------------------------------------------------------------------------------------
function fInsertOthersLeftMenu() {
	
}
//--------------------------------------------------------------------------------------------------------
function fInsertBottomMenu() {
	
}
//--------------------------------------------------------------------------------------------------------
function fInsertBottomStdText() {

print '<div class="footer">
 <div class="ft ft1">
      <p class="inf"><span class="bold">Phone:</span>  0233678567</p>
      <p class="inf"><span class="bold">Adress:</span> Sediul str. Dumitru Martinas 12, Bucuresti sector 4</p>
<p class="inf"><span class="bold">Email:</span> office@yahoo.com</p>
   </div>
  <div class="ft ft3">
    <p class="footertitle">Social networks</p>
    <ul class="footericons">
      <li class="footericon">
 <a target="_blank" href="https://www.facebook.com/aaaaa/">
<div class="icon1"></div></a></li>
      <li class="footericon"><a href="#"><div class="icon2"></div></a></li>
    </ul>
   </div>
</div>';

}
//--------------------------------------------------------------------------------------------------------
function fInsertProdOfTheDayBox() {
	
}
//--------------------------------------------------------------------------------------------------------
function fInsertPromotionsBox() {
	
}
//--------------------------------------------------------------------------------------------------------
function fInsertProdLeft($intIdProdus) {
	$strSQL = "SELECT tproduse.* FROM tproduse WHERE fIdProdus=$intIdProdus";
	$result = mysql_query($strSQL);
	$row = mysql_fetch_array($result);
	$strName = $row['fNumeProdus'];
	$strImage = $row['fImagine'];
	$strSpecs = $row['fSpecificatii'];
	$strPrice = $row['fPret'];

	echo "<td style=\"width: 50%; text-align: center; vertical-align: top;\">\n";
	echo "<table class=\"prodsumtable\">\n";
	echo "<tr><td class=\"prodsumtop\"></td></tr>\n";
	echo "<tr><td class=\"prodsummain\">\n";
	echo "<span style=\"font-weight: bold;\"><a href=\"detalii_produs.php?intIdProdus=$intIdProdus\" class=\"ProdNameLink\">$strName</a></span><br /><br />\n";
	echo "<a href=\"detalii_produs.php?intIdProdus=$intIdProdus\"><img alt=\"$strName\" src=\"./images/produse/$strImage\" style=\"width: 240px; height: 200px; border: 1px #9EB79E solid;\" /></a><br />\n";
	echo "<p style=\"text-align: left; padding: 4px;\">\n";
	//echo nl2br($strSpecs);
	echo "</p>\n";
	echo "<span style=\"font-weight: bold;\">$strPrice RON</span><br /><br />\n";
	echo "<a href=\"detalii_produs.php?intIdProdus=$intIdProdus\" class=\"DetailsLink\">detalii</a>\n";
	echo "</td></tr>\n";
	echo "<tr><td class=\"prodsumbottom\"></td></tr>\n";
	echo "</table>\n";
	echo "</td>\n";
}
//--------------------------------------------------------------------------------------------------------
function fInsertProdRight($intIdProdus) {
	$strSQL = "SELECT tproduse.* FROM tproduse WHERE fIdProdus=$intIdProdus";
	$result = mysql_query($strSQL);
	$row = mysql_fetch_array($result);
	$strName = $row['fNumeProdus'];
	$strImage = $row['fImagine'];
	$strSpecs = $row['fSpecificatii'];
	$strPrice = $row['fPret'];

	echo "<td style=\"width: 50%; text-align: center; vertical-align: top;\">\n";
	echo "<table class=\"prodsumtable\">\n";
	echo "<tr><td class=\"prodsumtop\"></td></tr>\n";
	echo "<tr><td class=\"prodsummain\">\n";
	echo "<span style=\"font-weight: bold;\"><a href=\"detalii_produs.php?intIdProdus=$intIdProdus\" class=\"ProdNameLink\">$strName</a></span><br /><br />\n";
	echo "<a href=\"detalii_produs.php?intIdProdus=$intIdProdus\"><img alt=\"$strName\" src=\"./images/produse/$strImage\" style=\"width: 240px; height: 200px; border: 1px #9EB79E solid;\" /></a><br />\n";
	echo "<p style=\"text-align: left; padding: 4px;\">\n";
	//echo nl2br($strSpecs);
	echo "</p>\n";
	echo "<span style=\"font-weight: bold;\">$strPrice RON</span><br /><br />\n";
	echo "<a href=\"detalii_produs.php?intIdProdus=$intIdProdus\" class=\"DetailsLink\">detalii</a>\n";
	echo "</td></tr>\n";
	echo "<tr><td class=\"prodsumbottom\"></td></tr>\n";
	echo "</table>\n";
	echo "</td>\n";
}
//--------------------------------------------------------------------------------------------------------
	function fSetProductOfTheDayID() {
$intProdofDay =isset($_SESSION['intProdofDay']) ? $_SESSION['intProdofDay'] : '';
		if ($intProdofDay == "") {
			$strFilename = "./cronjobs/prodofday.txt";
			$delim = "\n";
			$fp = fopen($strFilename, "r");
			$contents = fread($fp, filesize($strFilename));
			$aIDs = explode($delim, $contents);
			fclose($fp);
			$intTodayIndex = intval(date("d")) - 1;
			$intTodayId = $aIDs[$intTodayIndex];
			$_SESSION['intProdofDay'] = $intTodayId;
		}
	}
//--------------------------------------------------------------------------------------------------------
function fInsertCartLink() {
	echo "<table id=\"cart\"><tr><td>\n";
	echo "<a href=\"my_account.php\"><img alt=\"My account\" src=\"./images/cart.gif\" /></a>\n";
	echo "</td></tr></table>\n";
}
//--------------------------------------------------------------------------------------------------------
function fClearCart($intIdUtilizator) { // goleste cosul
	$strSQL = "DELETE FROM tcos WHERE fIdUtilizator=$intIdUtilizator";
	mysql_query($strSQL);
}
//--------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------

?>