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
						echo "<td width=\"50\">User</td>";
						echo "<td width=\"375\">Number product</td>";
						echo "<td width=\"130\">Total</td>";
						echo "</tr>";

$strSQL = "SELECT  * FROM tutilizatori";
$result = mysql_query($strSQL);
$max1 = 0; $s= 0;$nume="";
while ($row = mysql_fetch_array($result)) {
      //$intIdComanda = $row['fIdComanda'];
      $intIdUtilizator  = $row['fIdUtilizator'];
      $strNumeUtilizator = $row['fNumeUtilizator'];
      $intCount = 0;$intsuma = 0;
       $strSQL1 = "SELECT tcomenzi.fIdComanda, tcomenzi.fIdUtilizator,  tprodusecomenzi.fIdComanda, tprodusecomenzi.fCantitate, tprodusecomenzi.fIdProdus, tproduse.fIdProdus, tproduse.fPret FROM  tcomenzi, tprodusecomenzi, tproduse WHERE tprodusecomenzi.fIdComanda= tcomenzi.fIdComanda AND tcomenzi.fIdUtilizator=$intIdUtilizator  AND tprodusecomenzi.fIdProdus=tproduse.fIdProdus ";
       $result1 = mysql_query($strSQL1);

 while ($row = mysql_fetch_array($result1)) {
            $fCantitate=$row['fCantitate'];
$pret=$row['fPret'];
            $intCount =$intCount +$fCantitate;$intsuma = $intsuma + ($pret * 1.19) * $fCantitate;
             //$intnrimob = 0;
           //$inttotal = 0;                       
}
         if($intsuma>$max1) { $max1= $intsuma; $nume=$strNumeUtilizator ;$s= $intCount;}
                        
                            if($intCount>0){             echo "<tr align=\"center\" style=\"font-weight: bold;\">";
						echo "<td width=\"50\"> $strNumeUtilizator</td>";
						echo "<td width=\"50\"> $intCount</td>";
							
						echo "<td width=\"375\">$intsuma</td>";
                                               echo "</tr>";
                                          }
   }


	
     echo "</table>\n";	

       



echo "<br>";	echo "<br>";

       


echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"1\" width=\"700\" class=\"modelspecs\" >\n";
echo "<tr align=\"left\" style=\"font-weight: bold;\"> THE BEST CUSTOMER</tr>\n";
echo "<tr align=\"left\" style=\"font-weight: bold;\">";
						echo "<td width=\"80\">TOTAL NUMBER OF PERFUMES PURCHASED</td>";
						echo "<td width=\"20\">$s</td>";
echo "</tr>\n";

echo "<tr align=\"left\" style=\"font-weight: bold;\">";
						echo "<td width=\"70\">CLIENT NAME</td>";
						echo "<td width=\"30\">$nume </td>";
echo "</tr>\n";
echo "<tr align=\"left\" style=\"font-weight: bold;\">";
						echo "<td width=\"70\">SALES MADE</td>";
						echo "<td width=\"30\">$max1 </td>";
echo "</tr>\n";
echo "</table>\n";














?>







</td>
			</tr>



</table>


				
	</body>
</html>