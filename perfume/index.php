<?php
	session_start();
	include_once("./include/functions.inc.php");
	$myConn = fDBConnect();
	fSetProductOfTheDayID();
 $intIdCategorieCautare =isset($_GET['intIdCategorieCautare']) ? $_GET['intIdCategorieCautare'] : '';
//$intIdUtilizator =isset($_SESSION['intIdUtilizator']) ? $_SESSION['intIdUtilizator'] : '';
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php fInsertDocType(); ?>
<head>

<?php fInsertMetaTags(); ?>
<?php fInsertCSS(); ?>
<?php fInsertJS(); ?>
<style>
body {
  font-family: Arial;
  margin: 0;
}

* {
  box-sizing: border-box;
}

img {
  vertical-align: middle;
}

/* Position the image container (needed to position the left and right arrows) */
.container {
  position: relative;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Add a pointer when hovering over the thumbnail images */
.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* Container for image text */
.caption-container {
  text-align: center;
  background-color: #222;
  padding: 2px 16px;
  color: white;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Six columns side by side */
.column {
  float: left;
  width: 16.66%;
}

/* Add a transparency effect for thumnbail images */
.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}




h2 {
  text-align: center;
  text-transform: uppercase;
  color: #4CAF50;
}

p {
  text-indent: 50px;
  text-align: justify;
  letter-spacing: 2px;
}





</style>


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
					
					
<tr><td>
<div class="container">
  <div class="mySlides">
    <div class="numbertext">1 / 6</div>
    <img src="img1.jpg" style="width: 700px; height: 450px;" >
  </div>

  <div class="mySlides">
    <div class="numbertext">2 / 6</div>
    <img src="img2.jpg" style="width: 700px; height: 450px;">
  </div>

  <div class="mySlides">
    <div class="numbertext">3 / 6</div>
    <img src="img3.jpg" style="width: 700px; height: 450px;">
  </div>
    
  <div class="mySlides">
    <div class="numbertext">4 / 6</div>
    <img src="img4.jpg" style="width: 700px; height: 450px;">
  </div>

  <div class="mySlides">
    <div class="numbertext">5 / 6</div>
    <img src="img5.jpg" style="width: 700px; height: 450px;">
  </div>
    
 <div class="mySlides">
    <div class="numbertext">6 / 6</div>
    <img src="img6.jpg" style="width: 700px; height: 450px;">
  </div>
    
  <a class="prev" onclick="plusSlides(-1)">?</a>
  <a class="next" onclick="plusSlides(1)">?</a>

  <div class="caption-container">
    <p id="caption"></p>
  </div>



</td>
<td>

<table style="width: 100%;">
						<tr>
			<h2>Perfumes</h2><br>
<p>You found us right here. Parfumeria.ro offers you an exciting shopping experience, inspired by the experience in our stores.

<p>Here you will find all our products, plus inspiration for new and personal combinations.
			
						</tr>
						</table>
</td></tr>








<tr>
  <div class="row">
    <div class="column">
      <img class="demo cursor" src="img1.jpg" style="width: 224px; height: 150px;" onclick="currentSlide(1)" alt="poza">
    </div>
    <div class="column">
      <img class="demo cursor" src="img2.jpg" style="width: 224px; height: 150px;" onclick="currentSlide(2)" alt="poza">
    </div>
    <div class="column">
      <img class="demo cursor" src="img3.jpg" style="width: 224px; height: 150px;" onclick="currentSlide(3)" alt="poza">
    </div>
    <div class="column">
      <img class="demo cursor" src="img4.jpg" style="width: 224px; height: 150px;" onclick="currentSlide(4)" alt="poza">
    </div>
    <div class="column">
      <img class="demo cursor" src="img5.jpg" style="width: 224px; height: 150px;" onclick="currentSlide(5)" alt="poza">
    </div>    
    <div class="column">
      <img class="demo cursor" src="img6.jpg" style="width: 224px; height: 150px;" onclick="currentSlide(6)" alt="poza">
    </div>  
  </div>
</div>

</tr>



				</table>











			</td></tr>
		<tr>
			<td id="footer">
			
			<?php fInsertBottomStdText(); ?>
			</td>
		</tr>
	</table>
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
 
}
</script>
</body>
</html>
<?php fDBClose($myConn); ?>