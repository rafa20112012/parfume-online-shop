<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
	$intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';
?>
<?php fInsertDocType(); ?>
<head>
<title>Contact Information</title>
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
						<p align="center"><strong>CONTACT INFORMATION  </strong></p>
						<p align="left">&nbsp;</p>
						<table style="width: 100%; background-color: #FFFFFF; border: 2px #B1C9B1 solid; font-size: 10pt;">
							<tr class="listprodrow1" style="height: 100px;">
							  <td style="width: 550px; text-align: center;">
							  
							 <div class=\"ft ft1\">
                               <h3 class=\"footertitle\">SC Moderna SRL  <br>
 RO17497245 J40/7115/2007<br>
                                    <br>
                                    Cluj-Romania</h4>
                               <h3 class=\"inf\"><span class=\"bold\"> Tel: 0742 567 654 </span><br><br></h4>
 <h3 class=\"inf\"><span class=\"bold\"> Fax: +40-21.000.00.78</span><br><br></h4>
 <h3 class=\"inf\"><span class=\"bold\">  Mob:+40-726.000.000</span><br><br></h4>
                                   
                               <h3 class=\"inf\"><span class=\"bold\">Email:</span> office@fashion.ro</a></h4>
							 </div>
 
							  
							  
							  
							  &nbsp;</td>
								<td style="vertical-align: middle; text-align: justify; padding: 10px;\">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2849.6998772142583!2d26.09414631552269!3d44.418803979102506!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b1ff0e5e0f99a7%3A0xc8f5e8eca3fe8cc2!2zQnVsZXZhcmR1bCBNxINyxIPImWXImXRpIDcsIEJ1Y3VyZciZdGk!5e0!3m2!1sro!2sro!4v1547760314189" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>



								
								
								
								
								
								</td>
							</tr>
						</table>
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
			
			<?php fInsertBottomStdText(); ?>
			</td>
		</tr>
	</table>

</body>
</html>
<?php fDBClose($myConn); ?>