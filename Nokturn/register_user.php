<?php

	session_start();

	if(isset($_POST['email'])) {
		// Succesful validation? Let's say yes!
		$all_ok = true;

		//Check if phone is correct
		$phone = $_POST['phone'];
		if((strlen($phone) < 6)) {
				$all_ok = false;
				$_SESSION['e_phone'] = "Phone must have at leat 6 characters!";
		}

		if(ctype_digit($phone) == false) {
			$all_ok = false;
			$_SESSION['e_phone'] = "Phone must only have numeric characters!";
		}

		//Check if street is correct
		$street = $_POST['street'];
		if((strlen($street) < 3)) {
			$all_ok = false;
			$_SESSION['e_street'] = "Street must have at least 3 characters!";
		}

		if(ctype_alnum($street) == false) {
			$all_ok = false;
			$_SESSION['e_street'] = "Street must only have alphanumeric characters!";
		}
		

		//Check if post code is correct
		$post_code = $_POST['post_code'];
		if((strlen($post_code) < 5)) {
			$all_ok = false;
			$_SESSION['e_post_code'] = "Post code must have at least 5 characters!";
		}

		//Check if city is correct
		$city = $_POST['city'];
		if((strlen($city) < 2)) {
			$all_ok = false;
			$_SESSION['e_city'] = "City must have at least 2 characters!";
		}

		if(ctype_alnum($city) == false) {
			$all_ok = false;
			$_SESSION['e_city'] = "City must only have alphanumeric characters!";
		}

		//Check if country is correct
		$country = $_POST['country'];
		if((strlen($country) < 2)) {
			$all_ok = false;
			$_SESSION['e_country'] = "Country must have at least 2 characters!";
		}

		if(ctype_alnum($country) == false) {
			$all_ok = false;
			$_SESSION['e_country'] = "Country must only have alphanumeric characters!";
		}

		//Check if name is correct
		$name = $_POST['name'];
		if((strlen($name) < 2)) {
			$all_ok = false;
			$_SESSION['e_name'] = "Name must have at least 2 characters!";
		}

		if(ctype_alnum($name) == false) {
			$all_ok = false;
			$_SESSION['e_name'] = "Name must only have alphanumeric characters!";
		}

		//Check if surname is correct
		$surname = $_POST['surname'];
		if((strlen($surname) < 2)) {
			$all_ok = false;
			$_SESSION['e_surname'] = "Surname must have at least 2 characters!";
		}

		if(ctype_alnum($surname) == false) {
			$all_ok = false;
			$_SESSION['e_surname'] = "Surname must only have alphanumeric characters!";
		}

		//Check if email is correct
		$email = $_POST['email'];
		$emailSecure = filter_var($email, FILTER_SANITIZE_EMAIL);

		if((filter_var($emailSecure, FILTER_VALIDATE_EMAIL) == false) || ($emailSecure != $email)) {
			$all_ok = false;
			$_SESSION['e_email'] = "Enter correct email address!";
		}

		//Check if password is correct
		$password = $_POST['password'];
		$password2 = $_POST['password2'];

		if((strlen($password) < 8) || (strlen($password) > 32)) {
			$all_ok = false;
			$_SESSION['e_password'] = "Password must have 8-32 characters!";
		}
		
		if($password != $password2) {
			$all_ok = false;
			$_SESSION['e_password'] = "Passwords are not identical!";
		}

		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		// Check if checkbox is checked :)
		if(!isset($_POST['terms'])) {
			$all_ok = false;
			$_SESSION['e_terms'] = "Checkbox is not checked!";
		}

		// Bot or not? That is the question!
		$secret = "6LcKwwsUAAAAAObhFl8zW64fFKaun9wnZU5u0hLi";

		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);

		$answer = json_decode($check);

		if($answer->success == false) {
			$all_ok = false;
			$_SESSION['e_bot'] = "Confirm you are not bot!";
		}

		//Remember inputed data f=form
		$_SESSION['f_name'] = $name;
		$_SESSION['f_surname'] = $surname;
		$_SESSION['f_email'] = $email;
		$_SESSION['f_password'] = $password;
		$_SESSION['f_password2'] = $password2;
		$_SESSION['f_phone'] = $phone;
		$_SESSION['f_street'] = $street;
		$_SESSION['f_post_code'] = $post_code;
		$_SESSION['f_city'] = $city;
		$_SESSION['f_country'] = $country;
		if(isset($_POST['terms'])) $_SESSION['f_terms'] = true;


		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);


		try {
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if($connection->connect_errno!=0) {
				throw new Exception(mysqli_connect_errno());
			} else {
				//Check if email already exists in DB
				$result = $connection->query("SELECT id FROM user WHERE email='$email'");

				if(!$result) throw new Exception($connection->error);

				$email_number = $result->num_rows; //email number == ilosc takich samych emaili
				if($email_number > 0) {
					$all_ok = false;
					$_SESSION['e_email'] = "There is already an account with this email!";
				}
				if($all_ok == true) {
					//All tests completed, add user to DB  
					$pass = md5($password);
					if ($connection->query("INSERT INTO user VALUES (NULL, '$email', /*zmienic na hashowane*/'$pass', 0, '$name', '$surname', $phone, '$street', '$post_code', '$city', '$country')")) {						
						$_SESSION['successfulRegister'] = true;

						$resultForId = $connection->query("SELECT id FROM user WHERE email='$email'");
						$row = $resultForId->fetch_assoc();

						header('Location: register_welcome.php');
					} else {
						throw new Exception($connection->error);
					}
				}
				$connection->close();
			}
		} catch(Exception $e) {
			echo '<span style="color: red;">Server error! Please register later</span>';
			// Do wyrzucenia potem
			echo '<br /> Developer error info: '.$e;
		}
	}

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
				<div class="row">
					<div class="col-xl-5 col-md-5 col-sm-12 col-xs-12">
						<div class="content-form">
							<p>Register in order to access to our products!</p>
							<form method="POST">
								<input type="text" value="<?php
									if(isset($_SESSION['f_name'])) {
										echo $_SESSION['f_name'];
										unset($_SESSION['f_name']);
									}
								?>" name="name" class="form-control" placeholder="Name:">
								<?php
									if(isset($_SESSION['e_name'])) {
										echo '<div class="error">'.$_SESSION['e_name'].'</div>';
										unset($_SESSION['e_name']);
									}
								?>
								<input type="text" value="<?php
									if(isset($_SESSION['f_surname'])) {
										echo $_SESSION['f_surname'];
										unset($_SESSION['f_surname']);
									}
								?>" name="surname" class="form-control" placeholder="Surname:">
								<?php
									if(isset($_SESSION['e_surname'])) {
										echo '<div class="error">'.$_SESSION['e_surname'].'</div>';
										unset($_SESSION['e_surname']);
									}
								?>
								<input type="text" value="<?php
									if(isset($_SESSION['f_email'])) {
										echo $_SESSION['f_email'];
										unset($_SESSION['f_email']);
									}
								?>" name="email" class="form-control" placeholder="Email:">
								<?php
									if(isset($_SESSION['e_email'])) {
										echo '<div class="error">'.$_SESSION['e_email'].'</div>';
										unset($_SESSION['e_email']);
									}
								?>
								<input type="password" value="<?php
									if(isset($_SESSION['f_password'])) {
										echo $_SESSION['f_password'];
										unset($_SESSION['f_password']);
									}
								?>" name="password" class="form-control" placeholder="Password:">
								<?php
									if(isset($_SESSION['e_password'])) {
										echo '<div class="error">'.$_SESSION['e_password'].'</div>';
										unset($_SESSION['e_password']);
									}
								?>
								<input type="password" value="<?php
									if(isset($_SESSION['f_password2'])) {
										echo $_SESSION['f_password2'];
										unset($_SESSION['f_password2']);
									}
								?>" name="password2" class="form-control" placeholder="Password again:">
								<input type="text" value="<?php
									if(isset($_SESSION['f_phone'])) {
										echo $_SESSION['f_phone'];
										unset($_SESSION['f_phone']);
									}
								?>" name="phone" class="form-control" placeholder="Phone:">
								<?php
									if(isset($_SESSION['e_phone'])) {
										echo '<div class="error">'.$_SESSION['e_phone'].'</div>';
										unset($_SESSION['e_phone']);
									}
								?>
								<input type="text" value="<?php
									if(isset($_SESSION['f_street'])) {
										echo $_SESSION['f_street'];
										unset($_SESSION['f_street']);
									}
								?>" name="street" class="form-control" placeholder="Street:">
								<?php
									if(isset($_SESSION['e_street'])) {
										echo '<div class="error">'.$_SESSION['e_street'].'</div>';
										unset($_SESSION['e_street']);
									}
								?>
								<input type="text" value="<?php
									if(isset($_SESSION['f_post_code'])) {
										echo $_SESSION['f_post_code'];
										unset($_SESSION['f_post_code']);
									}
								?>" name="post_code" class="form-control" placeholder="Post code:">
								<?php
									if(isset($_SESSION['e_post_code'])) {
										echo '<div class="error">'.$_SESSION['e_post_code'].'</div>';
										unset($_SESSION['e_post_code']);
									}
								?>
								<input type="text" value="<?php
									if(isset($_SESSION['f_city'])) {
										echo $_SESSION['f_city'];
										unset($_SESSION['f_city']);
									}
								?>" name="city" class="form-control" placeholder="City:">
								<?php
									if(isset($_SESSION['e_city'])) {
										echo '<div class="error">'.$_SESSION['e_city'].'</div>';
										unset($_SESSION['e_city']);
									}
								?>
								<input type="text" value="<?php
									if(isset($_SESSION['f_country'])) {
										echo $_SESSION['f_country'];
										unset($_SESSION['f_country']);
									}
								?>" name="country" class="form-control" placeholder="Country:">
								<?php
									if(isset($_SESSION['e_country'])) {
										echo '<div class="error">'.$_SESSION['e_country'].'</div>';
										unset($_SESSION['e_country']);
									}
								?>
								
								<div class="checkbox-terms">
									<label>
										<input type="checkbox" name="terms" <?php
											if(isset($_SESSION['f_termns'])) {
												echo "checked";
												unset($_SESSION['f_terms']);
											}
										?>
										/> <p class="terms">I accept terms of use</p>
									</label>
									<?php
									if(isset($_SESSION['e_terms'])) {
										echo '<div class="error">'.$_SESSION['e_terms'].'</div>';
										unset($_SESSION['e_terms']);
										}
									?>
									<div style="clear: both;"></div>
									<div class="g-recaptcha" data-sitekey="6LcKwwsUAAAAAKFH1Jcn0gFWA0P4FxfPQ9nfoyBI"></div>
									<?php
									if(isset($_SESSION['e_bot'])) {
										echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
										unset($_SESSION['e_bot']);
									}
								?>
								</div>

								<input type="submit" value="Submit" class="btn btn-primary">
							</form>
						</div>
					</div>
					<div class="col-xl-7 col-md-7 col-sm-12 col-xs-12 visible">
						<p class="topP">Become a part of our great community!</p>
						<img src="img/happy_clients.png" style="width: 90%; min-height: 700px;" class="img-responsive img-thumbnail"/>
					</div>
				</div>
			</div>
				
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