<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
	$intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';
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
?>
<?php fInsertDocType(); ?>
<head>
<title>Harta site</title>
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
						<tr>
									<td>
									<!--START QUICK SEARCH-->
									<?php fInsertQuickSearch($intIdCategorieCautare); ?>
									<!--END QUICK SEARCH-->
									</td>
								</tr>
						
						</table>
						<!--END MAIN CONTENT-->
						</td>
						
					</tr>
				</table>
			</td></tr>
		<tr>
			<td id="footer">
			
			<?php fInsertBottomStdText(); ?>
			</td>
		</tr>
	</table>

</body>
</html>
<?php fDBClose($myConn); ?>