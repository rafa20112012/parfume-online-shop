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
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;">Administration section :: Product details</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
					<table cellpadding="5" cellspacing="0" border="0" width="700" class="modelspecs">
						<tr>
							<td align="center" colspan="2" style="font-family: Tahoma, Verdana, Arial; font-weight: bold; font-size: 11pt;"><br>Product details<br><br></td>
						</tr>
						<?php
							$intIdProdus = $_GET['intIdProdus'];
							$strSQL = "SELECT tproduse.*, tsubcategorii.fNumeSubcategorie, tproducatori.fNumeProducator, tproducatori.fUrl, tcategorii.fIdCategorie, tcategorii.fNumeCategorie FROM tproduse, tproducatori, tcategorii, tsubcategorii WHERE tproduse.fIdProducator=tproducatori.fIdProducator AND tproduse.fIdSubcategorie=tsubcategorii.fIdSubcategorie AND tcategorii.fIdCategorie=tsubcategorii.fIdCategorie AND tproduse.fIdProdus=$intIdProdus";
							$result = mysql_query($strSQL);
							$row = mysql_fetch_array($result);

							$intIdProducator = $row['fIdProducator'];
							$intIdCategorie = $row['fIdCategorie'];
							$intIdSubcategorie = $row['fIdSubcategorie'];
							$strNumeProdus = $row['fNumeProdus'];
							$strNumeCategorie = $row['fNumeCategorie'];
							$strNumeSubcategorie = $row['fNumeSubcategorie'];
							$strNumeProducator = $row['fNumeProducator'];
							$strURL = $row['fUrl'];

							$strCod = $row['fCodProdus'];
							$strImagine = $row['fImagine'];
							$strDescriere = $row['fDescriere'];
							$strSpecificatii = $row['fSpecificatii'];
							$strPret = $row['fPret'];
							
						?>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Product Name:</td>
							<td width="450"><b><?php echo $strNumeProdus; ?></b></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Manufacturer Name:</td>
							<td width="450"><a class="genLinkReverse" target="_blank" href="manufacturerdetails.php?intIdProducator=<?php echo $intIdProducator; ?>"><?php echo $strNumeProducator; ?></a></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Website Manufacturer:</td>
							<td width="450"><a class="genLinkReverse" target="_blank" href="<?php echo $strURL; ?>"><?php echo $strURL; ?></a></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Category:</td>
							<td width="450"><?php echo $strNumeCategorie; ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Subcategory:</td>
							<td width="450"><?php echo $strNumeSubcategorie; ?></td>
						</tr>

						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Product code:</td>
							<td width="450"><?php echo $strCod; ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250" valign="top">Image:</td>
							<td width="450">
							<?php 
								$strCaleImagine = "../images/products/$strImagine";
								if (file_exists($strCaleImagine)) {
									echo "<img src=\"$strCaleImagine\" border=\"0\">";
								} else {
									echo "The image was not uploaded.";
								}
							?>
							</td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Description:</td>
							<td width="450"><?php echo $strDescriere; ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250" valign="top">Specifications:</td>
							<td width="450"><?php echo nl2br($strSpecificatii); ?></td>
						</tr>
						<tr bgcolor="#C1C1FF">
							<td align="right" width="250">Price:</td>
							<td width="450"><?php echo $strPret; ?> RON</td>
						</tr>
						
						<tr bgcolor="#C1C1FF">
							<td align="center" colspan="2">
								<a href="products.php" class="genLink" style="width: 100px;"> &nbsp; Back &nbsp; </a><br><br>
								</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>