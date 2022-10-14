<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();

	$action = $_GET['action'];

	//------------------------------------------------------------------------------------------------
	if ($action == "login") { // autentificarea utilizatorului. daca datele sunt corecte se asigneaza variabilele sesiune utilizate pentru identificare, altfel se afiseaza mesaj eroare autentificare
		$strNumeUtilizator = trim(htmlspecialchars($_POST['txtNumeUtilizator']));
		$strParola = trim(htmlspecialchars($_POST['txtParola']));
		$strSQL = "SELECT fIdUtilizator, fNumeUtilizator FROM tutilizatori WHERE fNumeUtilizator='$strNumeUtilizator' AND fParola='$strParola'";
		$result = mysql_query($strSQL);
		if (mysql_num_rows($result) > 0) { // login successfull
			$row = mysql_fetch_array($result);
			$_SESSION['intIdUtilizator'] = $row['fIdUtilizator'];
			$_SESSION['strNumeUtilizator'] = $row['fNumeUtilizator'];
			fClearCart($_SESSION['intIdUtilizator']);
			Header("Location:index.php");
		} else { // login fail
			Header("Location:loginerror.php");
		}
	}
	//------------------------------------------------------------------------------------------------
	if ($action == "logout") { // iesire din cont, se sterg variabilele sesiune utilizate pentru identificare
		$_SESSION['intIdUtilizator'] = -1;
		$_SESSION['strNumeUtilizator'] = "";
		Header("Location:index.php");
	}
	//------------------------------------------------------------------------------------------------
	if ($action == "addtocart") { // adauga produs in cosul de cumparaturi
		$intIdUtilizator = $_SESSION['intIdUtilizator'];
		if ($intIdUtilizator > 0) { // userul este logat
		//echo "<br>user logat<br>";
			$intIdProdus = $_POST['hddIntIdProdus'];
			$strIdSesiune = session_id();
			$strSQL = "SELECT * FROM tcos WHERE fIdUtilizator=$intIdUtilizator AND fIdProdus=$intIdProdus AND fIdSesiune='$strIdSesiune'";
			//echo "<br>$strSQL<br>";
			$result = mysql_query($strSQL);
			if (mysql_num_rows($result) > 0) { // produsul se afla deja in cos, incrementam cantitatea
			//echo "<br>deja exista<br>";
				$row = mysql_fetch_array($result);
				$intIdItem = $row['fIdItem'];
				$intCantitate = $row['fCantitate'];
				$intCantitateNoua = $intCantitate + 1;
				$strSQL = "UPDATE tcos SET fCantitate=$intCantitateNoua WHERE fIdUtilizator=$intIdUtilizator AND fIdProdus=$intIdProdus AND fIdSesiune='$strIdSesiune' AND fIdItem=$intIdItem";
				mysql_query($strSQL);
			} else { // produsul nu se afla in cos, il adaugam
			//echo "<br>does not exist<br>";
				$strSQL = "INSERT INTO tcos (fIdUtilizator, fIdProdus, fCantitate, fIdSesiune) VALUES ($intIdUtilizator, $intIdProdus, 1, '$strIdSesiune')";
				mysql_query($strSQL);
			}
		}
		Header("Location: shopping_cart.php");
	}
	//------------------------------------------------------------------------------------------------
	if ($action == "emptycart") {
		$intIdUtilizator = $_SESSION['intIdUtilizator'];
		fClearCart($intIdUtilizator);
		Header("Location: shopping_cart.php");
	}
	//------------------------------------------------------------------------------------------------
	if ($action == "delfromcart") {
		$intIdProdus = $_GET['intIdProdus'];
		$intIdUtilizator = $_SESSION['intIdUtilizator'];
		$strSesiune = session_id();
		$strSQL = "DELETE FROM tcos WHERE fIdUtilizator=$intIdUtilizator AND fIdProdus=$intIdProdus AND fIdSesiune='$strSesiune'";
		mysql_query($strSQL);
		Header("Location: shopping_cart.php");
	}
	//------------------------------------------------------------------------------------------------
	if ($action == "updatecart") {
		$intIdUtilizator = $_SESSION['intIdUtilizator'];
		$strSesiune = session_id();
		$strSQL = "SELECT * FROM tcos WHERE fIdSesiune='$strSesiune' AND fIdUtilizator=$intIdUtilizator";
		$result = mysql_query($strSQL);
		while ($row = mysql_fetch_array($result)) {
			$intIdProdus = $row['fIdProdus'];
			$newval = intval($_POST['txt' . $intIdProdus]);
			if ($newval == 0) { // sterge produs din cos
				$strSQLDelete = "DELETE FROM tcos WHERE fIdSesiune='$strSesiune' AND fIdUtilizator=$intIdUtilizator AND fIdProdus=$intIdProdus";
				mysql_query($strSQLDelete);			
			} else { // actualizeaza cantitatea
				$strSQLUpdate = "UPDATE tcos SET fCantitate=$newval WHERE fIdSesiune='$strSesiune' AND fIdUtilizator=$intIdUtilizator AND fIdProdus=$intIdProdus";
				mysql_query($strSQLUpdate);
			}
		}
		Header("Location: shopping_cart.php");
	}
	//------------------------------------------------------------------------------------------------
	if ($action == "voteproduct") {
		$intIdProdus = intval($_POST['hddIntIdProdus']);
		$intIdUtilizator = $_SESSION['intIdUtilizator'];
		$intVoteValue = intval($_POST['selVoteValue']);
		$strSQL = "SELECT * FROM tvoturi WHERE fIdUtilizator=$intIdUtilizator AND fIdProdus=$intIdProdus";
		$result = mysql_query($strSQL);
		if (mysql_num_rows($result) > 0) {
			Header("Location: product_details.php?intIdProdus=$intIdProdus");
		} else {
			$strSQL = "INSERT INTO tvoturi (fIdProdus, fIdUtilizator, fValoareVot) VALUES ($intIdProdus, $intIdUtilizator, $intVoteValue)";
			mysql_query($strSQL);
			Header("Location: product_details.php?intIdProdus=$intIdProdus");
		}
	}
	//------------------------------------------------------------------------------------------------
	if ($action == "inregistrare") {
		$strNume = htmlspecialchars(trim($_POST['txtNumeInregistrare']));
		$strParola = htmlspecialchars(trim($_POST['txtParolaInregistrare']));
		$strEmail = htmlspecialchars(trim($_POST['txtEmail']));
		$strAdresa = htmlspecialchars(trim($_POST['txtAdresa']));
		$strToday = date("Ymd");

		$strSQL = "INSERT INTO tutilizatori (fNumeUtilizator, fParola, fEmail, fAdresa, fDataInregistrare) VALUES ('$strNume', '$strParola', '$strEmail', '$strAdresa', '$strToday')";
		mysql_query($strSQL);
		Header("Location: congratulations.php");
	}
	//------------------------------------------------------------------------------------------------
	if ($action == "actualizarecont") {
		$intIdUtilizator = $_SESSION['intIdUtilizator'];
		$strParola = htmlspecialchars(trim($_POST['txtParolaInregistrare']));
		$strEmail = htmlspecialchars(trim($_POST['txtEmail']));
		$strAdresa = htmlspecialchars(trim($_POST['txtAdresa']));

		$strSQL = "UPDATE tutilizatori SET fParola='$strParola', fEmail='$strEmail', fAdresa='$strAdresa' WHERE fIdUtilizator=$intIdUtilizator";
		mysql_query($strSQL);
		Header("Location: my_account.php");
	}
	//------------------------------------------------------------------------------------------------
	if ($action == "comanda") {
		$intIdUtilizator = $_SESSION['intIdUtilizator'];
		
		/*$strCupon = $_POST['txtCuponCumparator'];
		$strSQLCupon = "SELECT * FROM tcupoane WHERE fCodCupon='$strCupon'";
		$resultCupon = mysql_query($strSQLCupon);
		if (mysql_num_rows($resultCupon) > 0) { //cupon valid 
			$rowCupon = mysql_fetch_array($resultCupon);
			$intIdCupon = $rowCupon['fIdCupon'];
		} else {
			$intIdCupon = 0;
		}*/

		$strNume = $_POST['txtNumeCumparator'];
		$strEmail = $_POST['txtEmailCumparator'];
		$strAdresa = $_POST['txtAdresaCumparator'];
		$strToday = date("Ymd");

		$strSQL = "INSERT INTO tcomenzi (fIdUtilizator, fNumeCumparator, fEmailCumparator, fAdresaCumparator, fDataComanda) VALUES ($intIdUtilizator,  '$strNume', '$strEmail', '$strAdresa', '$strToday')";
		mysql_query($strSQL);
		$intIdComanda = mysql_insert_id();

		$strIdSesiune = session_id();
		$strSQL = "SELECT * FROM tcos WHERE fIdUtilizator=$intIdUtilizator AND fIdSesiune='$strIdSesiune'";
		$result = mysql_query($strSQL);
		while ($row = mysql_fetch_array($result)) {
			$intIdProdus = $row['fIdProdus'];
			$intCantitate = $row['fCantitate'];
			$strSQLArticole = "INSERT INTO tprodusecomenzi (fIdComanda, fIdProdus, fCantitate) VALUES ($intIdComanda, $intIdProdus, $intCantitate)";
			mysql_query($strSQLArticole);
		}
		$strSQLStergere = "DELETE FROM tcos WHERE fIdUtilizator=$intIdUtilizator";
		mysql_query($strSQLStergere);

		Header("Location: final_command.php");
	}
	//------------------------------------------------------------------------------------------------

	//------------------------------------------------------------------------------------------------

	fDBClose($myConn); 
?>