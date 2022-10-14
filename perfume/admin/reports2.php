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
		<title>Administration section</title>
		<link rel="stylesheet" href="../css/admin.css" type="text/css">
		<script language="javascript" src="../js/functions.js"></script>
	</head>
	<body>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
			<tr style="height: 50px; width: 100%;">
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;">Report management</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
<?php					
echo " CALENDAR PERIOD( 2022-02-28) ";
?>

<form action="#"  method="post">

<table cellpadding="5" cellspacing="0" border="0" width="600" class="modelspecs" style="margin-left: auto; margin-right: auto;">
							
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Start date:</td>
								<td width="350">
								<input type="text" name="txtNumeInregistrare" id="txtNumeInregistrare" class="qtyText" maxlength="255" style="width: 300px; text-align: left;">
								</td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">End date:</td>
								<td width="350">
								<input type="text" name="txtNume1Inregistrare" id="txtNume1Inregistrare" class="qtyText" maxlength="255" style="width: 300px; text-align: left;">
								</td>
							</tr>
<tr bgcolor="#C1C1FF">
								
								<td colspan="2" align="center" height="80"><input type="submit" name="submit" value="Display">  </td>

								
							</tr>
						</table>
						</form>



<?php if(isset($_POST['submit'])){

$strData1 = htmlspecialchars(trim($_POST['txtNumeInregistrare']));
	$strData2 = htmlspecialchars(trim($_POST['txtNume1Inregistrare']));	





$strSQL = "SELECT tcomenzi.*, tutilizatori.fNumeUtilizator FROM tcomenzi, tutilizatori WHERE tcomenzi.fIdUtilizator=tutilizatori.fIdUtilizator ";
						$result = mysql_query($strSQL);
						echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"1\" width=\"700\" class=\"modelspecs\">\n";
						$intCount = 0;
$intnrimob = 0;
$inttotal = 0;
						echo "<tr align=\"center\" style=\"font-weight: bold;\">";
						echo "<td width=\"50\">User</td>";
						echo "<td width=\"50\">Order Date</td>";

							
						echo "<td width=\"375\">Product name</td>";
						
echo "<td width=\"120\">Unit price</td>";
						echo "<td width=\"130\">Total</td>";
						echo "</tr>";
						while ($row = mysql_fetch_array($result)) {
							$intIdComanda = $row['fIdComanda'];
							$intIdUtilizator = $row['fIdUtilizator'];
							$strNumeUtilizator = $row['fNumeUtilizator'];
							$strDataComanda = $row['fDataComanda'];
	if ($strDataComanda>=$strData1 && $strDataComanda<=$strData2){
							if ($intCount % 2 == 0) {
								echo "<tr bgcolor=\"#C1C1FF\">";
							} else {
								echo "<tr bgcolor=\"#C1C1FF\">";
							}
							echo "<td align=\"center\" width=\"200\"><a target=\"_blank\" class=\"genLinkReverse\" href=\"userdetails.php?intIdUtilizator=$intIdUtilizator\">$strNumeUtilizator</a></td>\n";
							
							echo "<td align=\"center\" width=\"200\">$strDataComanda</td>\n";

	
							
							//echo "<td align=\"center\" width=\"100\"><a  href=\"detailcommand.php?intIdComanda=$intIdComanda\"><img src=\"../images/view.gif\" border=\"0\"></a></td>\n";

							$strSQL1 = "SELECT tprodusecomenzi.*, tproduse.fNumeProdus, tproduse.fPret FROM tprodusecomenzi, tproduse WHERE tprodusecomenzi.fIdProdus=tproduse.fIdProdus AND tprodusecomenzi.fIdComanda=$intIdComanda";
							$result1 = mysql_query($strSQL1);
							$itemsno = mysql_num_rows($result1);
							if ($itemsno > 0) { // utilizatorul are produse in cos


								


								$intIndex = 1;
								$intTotalCos = 0;
								while ($row = mysql_fetch_array($result1)) {
									$intTotalProdus = 0;
									$intIndex = 3 - $intIndex;
									$intIdProdus = $row['fIdProdus'];
									$strNumeProdus = $row['fNumeProdus'];
									$intCantitate = 1;

									
										$intPret = $row['fPret'];
									
									$intTotalProdus = ($intPret * 1.19) * $intCantitate;
																
					
								
									echo "<td style=\"text-align: left;\">$strNumeProdus</td>\n";
									
									echo "<td>$intPret Lei</td>\n";
									echo "<td>$intTotalProdus Lei</td>\n";
									echo "</tr>\n";



									$intTotalCos = $intTotalCos + $intTotalProdus;	
								}



$inttotal = $inttotal+$intTotalProdus;	

						

								
							}$intnrimob=$intnrimob+$intCantitate;





							$intCount++;	


					




						}

} 

	
echo "</table>\n";	









echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"1\" width=\"700\" class=\"modelspecs\" >\n";

echo "<tr align=\"left\" style=\"font-weight: bold;\">";
						echo "<td width=\"80\">TOTAL NUMBER OF INVOICES</td>";
						echo "<td width=\"20\">$intnrimob</td>";
echo "</tr>\n";

echo "<tr align=\"left\" style=\"font-weight: bold;\">";
						echo "<td width=\"70\">TOTAL VALUE WITH VAT </td>";
						echo "<td width=\"30\">$inttotal </td>";
echo "</tr>\n";

echo "</table>\n";	echo "<br>";	echo "<br>";	echo "<br>";	



}?>





</td>
			</tr>



</table>


				
	</body>
</html>