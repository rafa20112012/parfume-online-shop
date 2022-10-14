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
						
						echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"1\" width=\"700\" class=\"modelspecs\">\n";

                                               echo "<tr align=\"center\" style=\"font-weight: bold;\">";
						echo "<td width=\"350\">Clothing item</td>";
						echo "<td width=\"150\">Number products sold</td>";
						echo "<td width=\"200\">Total sale amount</td>";
						echo "</tr>";

$strSQL = "SELECT  * FROM tproduse";
$result = mysql_query($strSQL);
$max1 = 0; $s= 0;$nume="";
while ($row = mysql_fetch_array($result)) {
      $fNumeProdus  = $row['fNumeProdus'];
      $intIdProdus  = $row['fIdProdus'];
      $pret= $row['fPret'];
      $intCount = 0;$intsuma = 0; 
       $strSQL1 = "SELECT tcomenzi.fIdComanda,  tprodusecomenzi.fIdComanda, tprodusecomenzi.fCantitate, tprodusecomenzi.fIdProdus  FROM  tcomenzi, tprodusecomenzi WHERE tcomenzi.fIdComanda = tprodusecomenzi.fIdComanda AND tprodusecomenzi.fIdProdus= $intIdProdus";
       $result1 = mysql_query($strSQL1);

 while ($row = mysql_fetch_array($result1)) {
            $fCantitate=$row['fCantitate'];

            $intCount =$intCount +$fCantitate; $intsuma = $intsuma + ($pret * 1.19) * $fCantitate;
             //$intnrimob = 0;
           //$inttotal = 0;                       
}     
        if($intCount>$max1) { $max1= $intCount; $nume=$fNumeProdus ;$s= $intsuma;}
               //else if($intCount=$max1 and $intsuma>$s  ) { $max1= $intCount; $nume=$fNumeProdus ;$s= $intsuma;}
                        if($intCount>0){
                                        echo "<tr align=\"center\" style=\"font-weight: bold;\">";
						echo "<td width=\"50\"> $fNumeProdus</td>";
						echo "<td width=\"50\"> $intCount</td>";
							
						echo "<td width=\"375\">$intsuma</td>";
                                               echo "</tr>";
                                        }
   }


	
     echo "</table>\n";	echo "<br>";	echo "<br>";

       


echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"1\" width=\"700\" class=\"modelspecs\" >\n";
echo "<tr align=\"left\" style=\"font-weight: bold;\"> BEST SELLING PRODUCT</tr>\n";
echo "<tr align=\"left\" style=\"font-weight: bold;\">";
						echo "<td width=\"80\">TOTAL NUMBER OF ITEMS SOLD</td>";
						echo "<td width=\"20\">$max1</td>";
echo "</tr>\n";

echo "<tr align=\"left\" style=\"font-weight: bold;\">";
						echo "<td width=\"70\">CLOTHING ITEM</td>";
						echo "<td width=\"30\">$nume </td>";
echo "</tr>\n";
echo "<tr align=\"left\" style=\"font-weight: bold;\">";
						echo "<td width=\"70\">SALES MADE</td>";
						echo "<td width=\"30\">$s </td>";
echo "</tr>\n";
echo "</table>\n";	echo "<br>";	echo "<br>";	echo "<br>";	

?>


</td>
			</tr>



</table>


				
	</body>
</html>