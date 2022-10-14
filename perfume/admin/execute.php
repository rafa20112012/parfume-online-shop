<?php
	session_start();
	include_once("../include/mysql.inc.php");
	include_once("../include/functions.inc.php");
	include_once("../include/adminfunctions.inc.php");
	$bIsLoggedIn = fCheckAdminLogin();
	$myConn = fDBConnect();
	$aActions = array('default', 'login', 'logout', 'chpass', 'adaugareproducator', 'modificareproducator', 'stergereproducator', 'adaugarecategorie', 'modificarecategorie', 'stergerecategorie', 'adaugaresubcategorie', 'modificaresubcategorie', 'stergeresubcategorie', 'adaugareprodus', 'modificareprodus', 'stergereprodus', 'adaugarecupon', 'modificarecupon', 'stergerecupon', 'aprobacomentariu', 'dezaprobacomentariu', 'stergerecomentariu', 'adaugarepromotie', 'modificarepromotie', 'stergerepromotie', 'stergereutilizator', 'stergerecomanda');
	$strAction = htmlspecialchars(trim($_GET['action']));
	
	$key = array_search($strAction, $aActions);
	if ($key > 0) { // valid action specified
		//Login
		if ($strAction == "login") {
			$strUsername = htmlspecialchars(trim($_POST['txtUsername']));
			$strPassword = htmlspecialchars(trim($_POST['txtPassword']));
			if (fCheckUserPassAdmin($strUsername, $strPassword)) {
				$intIdAdmin = $_SESSION['intIdAdmin'];
				Header('location:index.php');
			} else {
				Header('location:index.php?error=loginerror');
			}
		}
		//---------------------------------------------------------------------------------------------------
		//                    CHECK IF THE ADMIN IS LOGGED IN FOR THE FOLLOWING FUNCTIONS
		if (!$bIsLoggedIn) {
			Header("Location:index.php");
		}
//------------------------------------------------------------------------------------------------
	if ($action == "inregistrare1") {
		$strData1 = htmlspecialchars(trim($_POST['txtNumeInregistrare']));
	$strData2 = htmlspecialchars(trim($_POST['txtNume1Inregistrare']));	
		Header("Location: reports.php");
	}

		//---------------------------------------------------------------------------------------------------
		//Logout
		if ($strAction == "logout") {
			$_SESSION['intIdAdmin'] = "";
			$_SESSION['strUsername'] = "";
			session_destroy();
			Header('location:index.php');
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "chpass") {
			$strPassword = htmlspecialchars(trim($_POST['txtChPassword']));
			$intIdAdmin = $_SESSION['intIdAdmin'];
			$strSQL = "UPDATE tadmins SET fPassword='$strPassword' WHERE fIdAdmin=$intIdAdmin";
			mysql_query($strSQL);
			Header("location:passwordmodified.php");
		}
		// PRODUCATORI
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "adaugareproducator") {
			$strNume = htmlspecialchars(trim($_POST['txtNume']));
			$strURL = htmlspecialchars(trim($_POST['txtURL']));
			$strDescriere = htmlspecialchars(trim($_POST['txtDescriere']));

			$strSQL = "INSERT INTO tproducatori (fNumeProducator, fUrl, fDescriere) VALUES ('$strNume', '$strURL', '$strDescriere')";
			mysql_query($strSQL);
			Header("location:production.php");
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "stergereproducator") {
			$intIdProducator = htmlspecialchars(trim($_GET['intIdProducator']));
			$strSQL = "DELETE FROM tproducatori WHERE fIdProducator=$intIdProducator";
			mysql_query($strSQL);

			//TODO: delete from products, reviews, votes, etc

			Header("location:production.php");
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "modificareproducator") {
			$intIdProducator = $_POST['intIdProducator'];

			$strNume = htmlspecialchars(trim($_POST['txtNume']));
			$strURL = htmlspecialchars(trim($_POST['txtURL']));
			$strDescriere = htmlspecialchars(trim($_POST['txtDescriere']));

			$strSQL = "UPDATE tproducatori SET fNumeProducator='$strNume', fUrl='$strURL', fDescriere='$strDescriere' WHERE fIdProducator=$intIdProducator";
			mysql_query($strSQL);
			Header("location:production.php");
		}

		//CATEGORII
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "adaugarecategorie") {
			$strNume = htmlspecialchars(trim($_POST['txtNume']));

			$strSQL = "INSERT INTO tcategorii (fNumeCategorie) VALUES ('$strNume')";
			mysql_query($strSQL);
			Header("location:categories.php");
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "modificarecategorie") {
			$intIdCategorie = $_POST['intIdCategorie'];
			$strNume = htmlspecialchars(trim($_POST['txtNume']));
			$strSQL = "UPDATE tcategorii SET fNumeCategorie='$strNume' WHERE fIdCategorie=$intIdCategorie";
			mysql_query($strSQL);
			Header("location:categories.php");
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "stergerecategorie") {
			$intIdCategorie = htmlspecialchars(trim($_GET['intIdCategorie']));
			$strSQL = "DELETE FROM tcategorii WHERE fIdCategorie=$intIdCategorie";
			mysql_query($strSQL);
			//TODO: delete from products, reviews, votes, etc
			Header("location:categories.php");
		}

		//SUBCATEGORII
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "adaugaresubcategorie") {
			$intIdCategorie = htmlspecialchars(trim($_POST['selCategorie']));
			$strNume = htmlspecialchars(trim($_POST['txtNume']));
			$strSQL = "INSERT INTO tsubcategorii (fIdCategorie, fNumeSubcategorie) VALUES ($intIdCategorie, '$strNume')";
			mysql_query($strSQL);
			Header("location:subcategories.php");
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "modificaresubcategorie") {
			$intIdSubcategorie = $_POST['intIdSubcategorie'];
			$intIdCategorie = $_POST['selCategorie'];
			$strNume = htmlspecialchars(trim($_POST['txtNume']));
			$strSQL = "UPDATE tsubcategorii SET fIdCategorie=$intIdCategorie, fNumeSubcategorie='$strNume' WHERE fIdSubcategorie=$intIdSubcategorie";
			mysql_query($strSQL);
			Header("location:subcategories.php");
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "stergeresubcategorie") {
			$intIdSubcategorie = htmlspecialchars(trim($_GET['intIdSubcategorie']));
			$strSQL = "DELETE FROM tsubcategorii WHERE fIdSubcategorie=$intIdSubcategorie";
			mysql_query($strSQL);
			//TODO: delete from products, reviews, votes, etc
			Header("location:subcategories.php");
		}

		// PRODUSE
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "adaugareprodus") {
			$intIdCategorie = htmlspecialchars(trim($_POST['selCategorie']));
			$intIdSubcategorie = htmlspecialchars(trim($_POST['selSubcategorie']));
			$intIdProducator = htmlspecialchars(trim($_POST['selProducator']));
			$strNume = htmlspecialchars(trim($_POST['txtNume']));
			$strCod = htmlspecialchars(trim($_POST['txtCod']));
			$strDescriere = htmlspecialchars(trim($_POST['txtDescriere']));
			$strSpecificatii = htmlspecialchars(trim($_POST['txtSpecificatii']));
			$strPret = htmlspecialchars(trim($_POST['txtPret']));
		

			require("../include/fileupload-class.php");
			$path = "../images/products/";
			$upload_file_name = "imagineprodus";
			$acceptable_file_types = "image/gif|image/jpeg|image/pjpeg";
			$default_extension = "";
			$mode = 2;
			$my_uploader = new uploader("en");
			$my_uploader->max_filesize(50000000);
			$my_uploader->max_image_size(1500, 1500);
			if ($my_uploader->upload($upload_file_name, $acceptable_file_types, $default_extension)) {
				$my_uploader->save_file($path, $mode);
			}
			if ($my_uploader->error) {
				$strHref = "location:addproduct.php?mode=error";
				$strHref .= "&intIdCategorie=$intIdCategorie";
				$strHref .= "&intIdSubcategorie=$intIdSubcategorie";
				$strHref .= "&intIdProducator=$intIdProducator";
				$strHref .= "&strNume=$strNume";
				$strHref .= "&strCod=$strCod";
				$strHref .= "&strDescriere=$strDescriere";
				$strHref .= "&strSpecificatii=$strSpecificatii";
				$strHref .= "&strPret=$strPret";
			
				$strHref .= "&error=" . $my_uploader->error;
				Header($strHref);
			} else {
				$strImagine = $my_uploader->file['name'];
				$strSQL = "INSERT INTO tproduse (fIdSubcategorie, fIdProducator, fNumeProdus, fCodProdus, fImagine, fDescriere, fSpecificatii, fPret) VALUES ($intIdSubcategorie, $intIdProducator, '$strNume', '$strCod', '$strImagine', '$strDescriere', '$strSpecificatii', '$strPret')";
				mysql_query($strSQL);
				Header("location:products.php");
			}
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "modificareprodus") {
			$intIdProdus = htmlspecialchars(trim($_POST['intIdProdus']));

			$intIdCategorie = htmlspecialchars(trim($_POST['selCategorie']));
			$intIdSubcategorie = htmlspecialchars(trim($_POST['selSubcategorie']));
			$intIdProducator = htmlspecialchars(trim($_POST['selProducator']));
			$strNume = htmlspecialchars(trim($_POST['txtNume']));
			$strCod = htmlspecialchars(trim($_POST['txtCod']));
			$strDescriere = htmlspecialchars(trim($_POST['txtDescriere']));
			$strSpecificatii = htmlspecialchars(trim($_POST['txtSpecificatii']));
			$strPret = htmlspecialchars(trim($_POST['txtPret']));

			require("../include/fileupload-class.php");
			$path = "../images/products/";
			$upload_file_name = "imagineprodus";
			$acceptable_file_types = "image/gif|image/jpeg|image/pjpeg";
			$default_extension = "";
			$mode = 2;
			$my_uploader = new uploader("en");
			$my_uploader->max_filesize(50000000);
			$my_uploader->max_image_size(1500, 1500);
			if ($my_uploader->upload($upload_file_name, $acceptable_file_types, $default_extension)) {
				$my_uploader->save_file($path, $mode);
			}
			if (($my_uploader->error) && ("Nici un fisier incarcat." != $my_uploader->error)){
				$strHref = "location:editproduct.php?mode=error";
				$strHref .= "&intIdProdus=$intIdProdus";
				$strHref .= "&intIdCategorie=$intIdCategorie";
				$strHref .= "&intIdSubcategorie=$intIdSubcategorie";
				$strHref .= "&intIdProducator=$intIdProducator";
				$strHref .= "&strNume=$strNume";
				$strHref .= "&strCod=$strCod";
				$strHref .= "&strDescriere=$strDescriere";
				$strHref .= "&strSpecificatii=$strSpecificatii";
				$strHref .= "&strPret=$strPret";
				
				$strHref .= "&error=" . $my_uploader->error;
				Header($strHref);
			} else {
				$strFilename = $my_uploader->file['name'];
				if ($strFilename != "") {
					$strSQL = "SELECT fImagine FROM tproduse WHERE fIdProdus=$intIdProdus";
					$result = mysql_query($strSQL);
					$row = mysql_fetch_array($result);
					$strImagine = $row['fImagine'];
					$strCaleImagine = "../images/products/$strImagine";
					if (file_exists($strCaleImagine)) {
						unlink($strCaleImagine);
					}
				}
				$strSQL = "UPDATE tproduse SET     fIdSubcategorie=$intIdSubcategorie,   fIdProducator=$intIdProducator,  fNumeProdus='$strNume',  fCodProdus='$strCod',    fDescriere='$strDescriere',   fSpecificatii='$strSpecificatii',  fPret='$strPret',  fImagine='$strFilename'  WHERE fIdProdus=$intIdProdus ";
				
		
				mysql_query($strSQL);
				Header("location:products.php");
			}
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "stergereprodus") {
			$intIdProdus = $_GET['intIdProdus'];
			$strSQL = "SELECT fImagine FROM tproduse WHERE fIdProdus=$intIdProdus";
			$result = mysql_query($strSQL);
			$row = mysql_fetch_array($result);
			$strImagine = $row['fImagine'];
			$strCaleImagine = "../images/products/$strImagine";
			if (file_exists($strCaleImagine)) {
				unlink($strCaleImagine);
			}
			$strSQL = "DELETE FROM tproduse WHERE fIdProdus=$intIdProdus";
			mysql_query($strSQL);
			Header("location:products.php");
		}

		
		//COMENTARII
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "aprobacomentariu") {
			$intIdComentariu = htmlspecialchars(trim($_GET['intIdComentariu']));
			$strSQL = "UPDATE tcomentarii SET fAprobat=1 WHERE fIdComentariu=$intIdComentariu";
			mysql_query($strSQL);
			Header("location:comments.php");
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "dezaprobacomentariu") {
			$intIdComentariu = htmlspecialchars(trim($_GET['intIdComentariu']));
			$strSQL = "UPDATE tcomentarii SET fAprobat=0 WHERE fIdComentariu=$intIdComentariu";
			mysql_query($strSQL);
			Header("location:comments.php");
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "stergerecomentariu") {
			$intIdComentariu = htmlspecialchars(trim($_GET['intIdComentariu']));
			$strSQL = "DELETE FROM tcomentarii WHERE fIdComentariu=$intIdComentariu";
			mysql_query($strSQL);
			Header("location:comments.php");
		}

		
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "stergereutilizator") {
			$intIdUtilizator = htmlspecialchars(trim($_GET['intIdUtilizator']));
			$strSQL = "DELETE FROM tutilizatori WHERE fIdUtilizator=$intIdUtilizator";
			mysql_query($strSQL);
			Header("location:users.php");
		}
		//---------------------------------------------------------------------------------------------------
		if ($strAction == "stergerecomanda") {
			$intIdComanda = htmlspecialchars(trim($_GET['intIdComanda']));
			$strSQL = "DELETE FROM tcomenzi WHERE fIdComanda=$intIdComanda";
			mysql_query($strSQL);
			$strSQL = "DELETE FROM tprodusecomenzi WHERE fIdComanda=$intIdComanda";
			mysql_query($strSQL);
			Header("location:orders.php");
		}
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------
	} else {
		echo "invalid action";
	}
?>