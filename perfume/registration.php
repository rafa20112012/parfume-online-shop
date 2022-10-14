<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
	$intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';


?>
<?php fInsertDocType(); ?>
<head>
<title>New account</title>
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
						<tr><td>
						<!--START CONTENT-->
						<h1 class="pageheader">New account</h1>
						<p class="pagecontent">
						<form name="frmInregistrare" id="frmInregistrare" action="execute.php?action=inregistrare" method="post" onsubmit="return fValidareInregistrare();">
						<table cellpadding="5" cellspacing="0" border="0" width="600" class="modelspecs" style="margin-left: auto; margin-right: auto;">
							
							<tr bgcolor="#E7F2E7">
								<td align="right" width="250">User name:</td>
								<td width="350">
								<input type="text" name="txtNumeInregistrare" id="txtNumeInregistrare" class="qtyText" maxlength="255" style="width: 300px; text-align: left;">
								</td>
							</tr>
							<tr bgcolor="#E7F2E7">
								<td align="right" width="250">Password:</td>
								<td width="350">
								<input type="password" name="txtParolaInregistrare" id="txtParolaInregistrare" class="qtyText" maxlength="255" style="width: 300px; text-align: left;">
								</td>
							</tr>
							<tr bgcolor="#E7F2E7">
								<td align="right" width="250">Password confirmation:</td>
								<td width="350">
								<input type="password" name="txtParolaInregistrare2" id="txtParolaInregistrare2" class="qtyText" maxlength="255" style="width: 300px; text-align: left;">
								</td>
							</tr>
							<tr bgcolor="#E7F2E7">
								<td align="right" width="250">Email adress:</td>
								<td width="350">
								<input type="text" name="txtEmail" id="txtEmail" class="qtyText" maxlength="255" style="width: 300px; text-align: left;">
								</td>
							</tr>
							<tr bgcolor="#E7F2E7">
								<td align="right" width="250">Email Address Confirmation:</td>
								<td width="350">
								<input type="text" name="txtEmail2" id="txtEmail2" class="qtyText" maxlength="255" style="width: 300px; text-align: left;">
								</td>
							</tr>
							<tr bgcolor="#E7F2E7">
								<td align="right" width="250">Adress:</td>
								<td width="350">
								<textarea name="txtAdresa" id="txtAdresa" class="qtyText" style="width: 300px; height: 100px; text-align: left;"></textarea>
								</td>
							</tr>
							<tr bgcolor="#E7F2E7">
								<td align="center" colspan="2">
								<input class="buttons" type="reset" name="cmdReset" id="cmdReset" value="Cancel changes"> &nbsp; 
								<input class="buttons" type="submit" name="cmdGo" id="cmdGo" value="Registration">
								</td>
							</tr>
						</table>
						</form>
						</p>
						<!--END CONTENT-->
						</td></tr>
						</table>
						<!--END MAIN CONTENT-->
						</td>
						
					</tr>
				</table>
			</td></tr>
		<tr>
			<td id="footer">
			<!--START BOTTOM MENU-->
			<?php fInsertBottomMenu(); ?>
			<!--END BOTTOM MENU-->
			<?php fInsertBottomStdText(); ?>
			</td>
		</tr>
	</table>

</body>
</html>
<?php fDBClose($myConn); ?>