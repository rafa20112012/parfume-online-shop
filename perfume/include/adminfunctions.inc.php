<?php
require("config.inc.php");
//-----------------------------------------------------------------------------------------------------------------
function fCheckAdminLogin() {
	$intIdAdmin= isset($_SESSION['intIdAdmin'])? $_SESSION['intIdAdmin'] : '';
	//if (($_SESSION['intIdAdmin'] == "") || (!isset($_SESSION['intIdAdmin']))) {
if (($intIdAdmin == "") || (!$intIdAdmin)) {
		return false;
	} else {
		return true;
	}
}
//-----------------------------------------------------------------------------------------------------------------
function fCheckUserPassAdmin($strUsername, $strPassword) {
	$strSQL = "SELECT fIdAdmin, fUsername FROM tadmins WHERE fUsername='$strUsername' AND fPassword='$strPassword'";
	$result = mysql_query($strSQL); 
	if (mysql_num_rows($result) < 1) {
		return false;
	} else {
		$row = mysql_fetch_array($result);
		$_SESSION['intIdAdmin'] = $row['fIdAdmin'];
		$_SESSION['strUsername'] = $row['fUsername'];
		return true;
	}
}
//-----------------------------------------------------------------------------------------------------------------
function fPrintLoginAreaAdmin($bIsLoggedIn, $strError) {
	if ($bIsLoggedIn) { 
		// the admin is logged in, say HI and display link to cart and link to logout
		$strUsername = $_SESSION['strUsername'];
		echo "<table class=\"modelspecs\"><tr><td>\n";
		echo "<br />Administrator  <b>$strUsername</b><br /><br />";
		echo "<a class=\"btn-group\" href=\"passwordchange.php\"><button class=\"button\" style=\"width: 200px;\">Change password </button></a><br />";

		echo "<a class=\"btn-group\" href=\"production.php\"><button class=\"button1\" style=\"width: 200px;\">Manufacturer administration</button></a>";
		echo "<a class=\"btn-group\" href=\"categories.php\"><button class=\"button1\" style=\"width: 200px;\">Category administration</button></a>";
		echo "<a class=\"btn-group\" href=\"subcategories.php\"><button class=\"button1\" style=\"width: 200px;\">Subcategory administration</button></a>";
		echo "<a class=\"btn-group\" href=\"products.php\"><button class=\"button1\" style=\"width: 200px;\">Product management</button></a><br>";
		echo "<a class=\"btn-group\" href=\"users.php\"><button class=\"button1\" style=\"width: 200px;\">User administration</button></a>";
		echo "<a class=\"btn-group\" href=\"orders.php\"><button class=\"button1\" style=\"width: 200px;\">Invoice management</button></a>";
                                 echo "<a class=\"btn-group\" href=\"reports.php\"><button class=\"button1\" style=\"width: 200px;\">Sales Report</button></a>";
echo "<a class=\"btn-group\" href=\"reports1.php\"><button class=\"button1\" style=\"width: 200px;\">Customer Sales Report</button></a>";
echo "<a class=\"btn-group\" href=\"reports2.php\"><button class=\"button1\" style=\"width: 200px;\">Calendar interval sales report</button></a>";
echo "<a class=\"btn-group\" href=\"reports3.php\"><button class=\"button1\" style=\"width: 200px;\">Clothing sales</button></a>";
		
		echo "<a class=\"gbtn-group\" href=\"execute.php?action=logout\"><button class=\"button1\" style=\"width: 200px;\">Output</button></a>";
		echo "</td></tr></table>\n";
	} else {
		// the admin is not logged in, display the login/register form
		echo "<form name=\"frmLogin\" method=\"post\" action=\"execute.php?action=login\" onsubmit=\"return fValidateLogin();\">\n";
		if ($strError == "loginerror") {
			echo "<font color=\"red\"><b><center>Login error!</b></center></font>\n";
		}
		echo "<table class=\"modelspecs\"><tr><td>User:<br />\n";
		echo "<input class=\"text\" type=\"text\" style=\"width: 200px;\" name=\"txtUsername\" id=\"txtUsername\" maxlength=\"32\"><br />\n";
		echo "Password:<br />\n";
		echo "<input class=\"text\" type=\"password\" style=\"width: 200px;\" name=\"txtPassword\" id=\"txtPassword\" maxlength=\"32\"><br /><br />\n";
		echo "<input class=\"btn-group\" type=\"submit\" style=\"width: 200px;\" name=\"cmdLogin\" id=\"cmdLogin\" value=\"Login\"><br /><br />\n";
		echo "</td></tr></table></form>\n";
	}
}
//-----------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------

?>