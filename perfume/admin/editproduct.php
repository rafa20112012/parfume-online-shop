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

	$intIdProdus = $_GET['intIdProdus'];
	
	$mode = isset($_GET['mode'])? $_GET['mode'] : '';
	if ($mode == "error") {
		$intIdCategorie = $_GET['intIdCategorie'];
		$intIdSubcategorie = $_GET['intIdSubcategorie'];
		$intIdProducator = $_GET['intIdProducator'];
		$strNume = $_GET['strNume'];
		$strCod = $_GET['strCod'];
		$strDescriere = $_GET['strDescriere'];
		$strSpecificatii = $_GET['strSpecificatii'];
		$strPret = $_GET['strPret'];
		

		$strSQL = "SELECT fImagine FROM tproduse WHERE tproduse.fIdProdus=$intIdProdus";
		$result = mysql_query($strSQL);
		$row = mysql_fetch_array($result);
		$strImagine = $row['fImagine'];
	} else {
		$strSQL = "SELECT tproduse.*, tsubcategorii.fIdCategorie FROM tproduse, tsubcategorii WHERE tproduse.fIdSubcategorie=tsubcategorii.fIdSubcategorie AND tproduse.fIdProdus=$intIdProdus";
		$result = mysql_query($strSQL);
		$row = mysql_fetch_array($result);
		$intIdCategorie = $row['fIdCategorie'];
		$intIdSubcategorie = $row['fIdSubcategorie'];
		$intIdProducator = $row['fIdProducator'];
		$strNume = $row['fNumeProdus'];
		$strCod = $row['fCodProdus'];
		$strImagine = $row['fImagine'];
		$strDescriere = $row['fDescriere'];
		$strSpecificatii = $row['fSpecificatii'];
		$strPret = $row['fPret'];
		
	}
	if ($mode == "refresh") {
		$intIdCategorie = $_GET['intIdCategorie'];
	}
?>
<html>
	<head>
		<title>Administration section</title>
		<link rel="stylesheet" href="../css/admin.css" type="text/css">
		<script language="javascript" src="../js/functions.js"></script>
	</head>
	<script language="javascript">
		function PageChanger(intIdCategorie) {
			document.location = 'editproduct.php?mode=refresh&intIdProdus=<?php echo $intIdProdus; ?>&intIdCategorie=' + intIdCategorie;
		}
	</script>
	<body>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
			<tr style="height: 50px; width: 100%;">
				<td colspan="2" style="font-weight: bold; text-align: center; height: 50px; width: 100%; font-family: Tahoma, Verdana, Arial; font-size: 10pt;">Administration section :: Product modification</td>
			</tr>
			<tr>
				<td style="width: 200px;" valign="top">
					<?php fPrintLoginAreaAdmin($bIsLoggedIn, $strError); ?>
				</td>
				<td style="width: 700px;" valign="top" align="center">
					<form enctype="multipart/form-data" name="frmModificaProdus" id="frmModificaProdus" method="post" action="execute.php?action=modificareprodus" onSubmit="return fValidareAdaugareProdus();">
						<input type="hidden" name="intIdProdus" id="intIdProdus" value="<?php echo $intIdProdus; ?>">
						<table cellpadding="5" cellspacing="0" border="0" width="700" class="modelspecs">
							<tr>
								<td align="center" colspan="2" style="font-family: Tahoma, Verdana, Arial; font-weight: bold; font-size: 11pt;"><br>Product change<br><br></td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Category:</td>
								<td width="450">
								<select onChange="PageChanger(this.options[this.selectedIndex].value);" name="selCategorie" id="selCategorie" style="width: 300px;" class="text">
								<option value="select">Select category</option>
								<?php
									$strSQL = "SELECT * FROM tcategorii";
									$result = mysql_query($strSQL);
									while ($row = mysql_fetch_array($result)) {
										$intIdCateg = $row['fIdCategorie'];
										$strNumeCategorie = $row['fNumeCategorie'];
										echo "<option value=\"$intIdCateg\"";
										if ($intIdCategorie == $intIdCateg) {
											echo " selected ";
										}
										echo ">$strNumeCategorie</option>";
									}
								?>
								</select>
								</td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Subcategory:</td>
								<td width="450">
								<select name="selSubcategorie" id="selSubcategorie" style="width: 300px;" class="text">
								<option value="select">Select subcategory</option>
								<?php
									$strSQL = "SELECT * FROM tsubcategorii WHERE fIdCategorie=$intIdCategorie";
									$result = mysql_query($strSQL);
									while ($row = mysql_fetch_array($result)) {
										$intIdSubcateg = $row['fIdSubcategorie'];
										$strNumeSubcategorie = $row['fNumeSubcategorie'];
										echo "<option value=\"$intIdSubcateg\"";
										if ($intIdSubcategorie == $intIdSubcateg) {
											echo " selected ";
										}
										echo ">$strNumeSubcategorie</option>";
									}
								?>
								</select>
								</td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Producer:</td>
								<td width="450">
								<select name="selProducator" id="selProducator" style="width: 300px;" class="text">
								<option value="select">Select manufacturer</option>
								<?php
									$strSQL = "SELECT * FROM tproducatori";
									$result = mysql_query($strSQL);
									while ($row = mysql_fetch_array($result)) {
										$intIdProd = $row['fIdProducator'];
										$strNumeProducator = $row['fNumeProducator'];
										echo "<option value=\"$intIdProd\"";
										if ($intIdProducator == $intIdProd) {
											echo " selected ";
										}
										echo ">$strNumeProducator</option>";
									}
								?>
								</select>
								</td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Name Product:</td>
								<td width="450"><input type="text" value="<?php echo $strNume; ?>" name="txtNume" id="txtNume" class="text" maxlength="255" style="width: 300px;"></td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Product code:</td>
								<td width="450"><input type="text" value="<?php echo $strCod; ?>" name="txtCod" id="txtCod" class="text" maxlength="255" style="width: 300px;"></td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250" valign="top">Image:</td>
								<td width="450">
								<?php 
									if (trim($strImagine) == "") {
										echo "The image was not uploaded.";
									} else {
										$strCaleImagine = "../images/produse/$strImagine";
										if (file_exists($strCaleImagine)) {
											echo "<img src=\"$strCaleImagine\" border=\"0\">";
										} else {
											echo "The image was not uploaded.";
										}
									}
								?>
								<br><input type="file" name="imagineprodus" class="field"/><br>Supported files: GIF / JPG <br /> Maximum size: 5000kb <br /> Maximum dimensions: 1500px/1500px</td>
							</tr>
							<?php 
								if ($mode == "error") {
									echo "<tr bgcolor=\"##C1C1FF\">";
									echo "<td colspan=\"2\">";
									echo "<p style=\"width: 90%; text-align: center; color: red; padding: 5px; border: red 2px dotted; font-family: Verdana; font-size: 10pt; font-weight: bold;\">";
									$error = $_GET['error'];
									echo "<img alt=\"Eroare\" src=\"../images/icon_error.gif\" border=\"0\" align=\"middle\"> &nbsp; ";
									echo "Image upload error.<br>Motivul: $error";
									echo "</p></td></tr>";
								}
							?>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Product Description:</td>
								<td width="450"><input type="text" value="<?php echo $strDescriere; ?>" name="txtDescriere" id="txtDescriere" class="text" maxlength="255" style="width: 300px;"></td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250" valign="top">Specifications:</td>
								<td width="450"><textarea name="txtSpecificatii" id="txtSpecificatii" class="text" style="width: 300px; height: 100px;"><?php echo $strSpecificatii; ?></textarea></td>
							</tr>
							<tr bgcolor="#C1C1FF">
								<td align="right" width="250">Price (Lei):</td>
								<td width="450"><input value="<?php echo $strPret; ?>" type="text" name="txtPret" id="txtPret" class="text" maxlength="255" style="width: 300px;"></td>
							</tr>
							

							<tr bgcolor="#C1C1FF">
								<td align="center" colspan="2">
								<input class="buttons" type="reset" name="cmdReset" id="cmdReset" value="Cancel changes"> &nbsp; 
								<input class="buttons" type="submit" name="cmdGo" id="cmdGo" value="Change">
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	</body>
</html>