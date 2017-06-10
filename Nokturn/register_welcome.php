<?php

	session_start();

	if(!isset($_SESSION['successfulRegister'])) {
		header('Location: index.php');
		exit();
	} else {
		unset($_SESSION['successfulRegister']);
	}

	//Delete all variables, which remembered data inputed in form
	if(isset($_SESSION['f_name'])) unset($_SESSION['f_name']);
	if(isset($_SESSION['f_surname'])) unset($_SESSION['f_surname']);
	if(isset($_SESSION['f_email'])) unset($_SESSION['f_email']);
	if(isset($_SESSION['f_password'])) unset($_SESSION['f_password']);
	if(isset($_SESSION['f_password2'])) unset($_SESSION['f_password2']);
	if(isset($_SESSION['f_phone'])) unset($_SESSION['f_phone']);
	if(isset($_SESSION['f_street'])) unset($_SESSION['f_street']);
	if(isset($_SESSION['f_post_code'])) unset($_SESSION['f_post_code']);
	if(isset($_SESSION['f_city'])) unset($_SESSION['f_city']);
	if(isset($_SESSION['f_country'])) unset($_SESSION['f_country']);
	if(isset($_SESSION['f_terms'])) unset($_SESSION['f_terms']);

	//Delete all error variables
	if(isset($_SESSION['e_name'])) unset($_SESSION['e_name']);
	if(isset($_SESSION['e_surname'])) unset($_SESSION['e_surname']);
	if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if(isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
	if(isset($_SESSION['e_terms'])) unset($_SESSION['e_terms']);
	if(isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nokturn - Online Shop</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="apple-touch-icon" href="img/favicon.ico">
	<!-- Bootstrap, JQuery, JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<!-- Our main CSS -->
	<link rel="stylesheet" href="style.css" type="text/css">
	<!-- Contact CSS (for form) -->
	<link rel="stylesheet" href="style-contact.css" type="text/css">
	<!-- Register CSS -->
	<link rel="stylesheet" href="style-register.css" type="text/css">
	<!-- Google Fonts, Font Awesome -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700|Montserrat:400,700&amp;subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>
	<section class="container-main">
	<!-- Navigation -->
		<header>
			<nav class="container-nav navbar" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
						<span class="sr-only">Menu</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="index.php">
						<div id="mainlogo">
							<img src="img/main_logo.png" width="100" height="100"/>
							<p>Nokturn</p>
						</div>
					</a>
				</div>
				<div id="menu" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.php">Home</a></li>
						<li><a href="products.php">Products</a></li>
						<li><a href="about.php">About</a></li>
						<li><a href="contact.php">Contact</a></li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Login, Register -->
		<section class="container-login">
			<div id="regbar">
				<div id="navthing">
					<h2><a href="#" id="loginform">Login</a> | <a href="register_user.php">Register</a></h2>
				<div class="login">
					<div class="arrow-up"></div>
					<div class="formholder">
						<div class="randompad">
							<form action="register.php" method="POST">
								<label>Email</label>
								<input type="email" name="email" value="example@gmail.com" />
								<label>Password</label>
								<input type="password" name="password"/>
								<input type="submit" value="Login" />
								<?php
									if(isset($_SESSION['error']))
									echo $_SESSION['error'];
								?>
							</form>
						</div>
					</div>
				</div>
				</div>
			</div>
		</section>
		<!-- Content -->
		<section class="container-content">
			<div class="content">
				<p style="color: black;">Thank you for registration in our shop!</p>
				<a style="color: black;" href="index.php">Login to your new account</a>
			</div>
		</section>
		<!-- Info -->
		<section class="info">
			<div class="content-info">
				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
						<h1>About us</h1>
						<p>Hello, we are Magda and Lucas - students from Wroclaw, Poland. We study computer science on faculty of Electronics for over 2 years. This online shop is our assignment for a Database course. If you want more information about us and the whole project check tabs!</p>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 middle">
						<h1>Get in touch</h1>
						<div class="row subinfo2">
							<div clas="col-1">
								<h3>Address:</h3>
							</div>
							<div clas="col-3">
								<p>34 Green Street, Window 6 Wonderland</p>
							</div>
						</div>
						<div class="row subinfo">
							<div clas="col-1">
								<h3>Phone:</h3>
							</div>
							<div clas="col-3">
								<p>+48 875369208 - Office, +48 353363114 - Fax</p>
							</div>
						</div>
						<div class="row subinfo">
							<div clas="col-1">
								<h3>Email:</h3>
							</div>
							<div clas="col-3">
								<p>ourmail@gmail.com</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
						<h1>Social media</h1>
						<p>You can also find us on:</p>
						<div class="container-tiles">
							<div class="tile youtube">
								<i class="fa fa-youtube"></i>
							</div>
							<div class="tile g-plus">
								<i class="fa fa-google-plus"></i>
							</div>
							<div class="tile facebook">
								<i class="fa fa-facebook"></i>
							</div>
							<div class="tile github">
								<i class="fa fa-github"></i>
							</div>
							<div class="tile twitter">
								<i class="fa fa-twitter"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Footer -->
		<footer>
			Copyrights 2016
		</footer>
	</section>

	<!-- Script -->
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="js/index.js"></script>
</body>
</html>