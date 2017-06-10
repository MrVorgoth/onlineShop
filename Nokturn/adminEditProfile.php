<?php

	session_start();

	if(!(isset($_SESSION['loggedIn']))) {
		header('Location: index.php');
		exit();
	}

		if(isset($_POST['name']) || isset($_POST['surname']) || isset($_POST['email']) || isset($_POST['password']) || isset($_POST['phone']) || isset($_POST['street']) || isset($_POST['post_code']) || isset($_POST['city']) || isset($_POST['country'])) {
		// Succesful validation? Let's say yes!
		$all_ok = true;

		// Check if phone is correct
		$phone = $_POST['phone'];
		if($phone != $_SESSION['user_phone'] && $phone!="")
		{
			if((strlen($phone) < 9) || (strlen($phone) > 50)) {
				$all_ok = false;
				$_SESSION['e_phone'] = "Phone must have at leat 9 characters!";
			}

			if(ctype_digit($phone) == false) {
				$all_ok = false;
				$_SESSION['e_phone'] = "Phone must only have numeric characters!";
			}
		}
		else
			$phone = $_SESSION['user_phone'];

		// Check if street is correct
		$street = $_POST['street'];
		if($street != $_SESSION['user_street'] && $street!="")
		{
			if((strlen($street) < 3) || (strlen($street) > 30)) {
				$all_ok = false;
				$_SESSION['e_street'] = "Street must have at least 3 characters!";
			}

			if(ctype_alnum($street) == false) {
				$all_ok = false;
				$_SESSION['e_street'] = "Street must only have alphanumeric characters!";
			}
		}
		else
			$street = $_SESSION['user_street'];

		// Check if post code is correct
		$post_code = $_POST['post_code'];
		if($post_code != $_SESSION['user_post_code'] && $post_code!="")
		{
			if((strlen($post_code) < 5) || (strlen($post_code) > 30)) {
				$all_ok = false;
				$_SESSION['e_post_code'] = "Post code must have at least 5 characters!";
			}
		}
		else
			$post_code = $_SESSION['user_post_code'];

		// Check if city is correct
		$city = $_SESSION['user_city'];
		if($city != $_SESSION['user_city'] && $city!="")
		{
			if((strlen($city) < 2) || (strlen($city) > 100)) {
				$all_ok = false;
				$_SESSION['e_city'] = "City must have at least 2 characters!";
			}

			if(ctype_alnum($city) == false) {
				$all_ok = false;
				$_SESSION['e_city'] = "City must only have alphanumeric characters!";
			}
		}
		else
			$city = $_SESSION['user_city'];

		// Check if country is correct
		$country = $_SESSION['user_country'];
		if($country != $_SESSION['user_country'] && $country!="")
		{
			if((strlen($country) < 2) || (strlen($country) > 100)) {
				$all_ok = false;
				$_SESSION['e_country'] = "Country must have at least 2 characters!";
			}

			if(ctype_alnum($country) == false) {
				$all_ok = false;
				$_SESSION['e_country'] = "Country must only have alphanumeric characters!";
			}
		}
		else
			$country = $_SESSION['user_country'];

		//Check if name is correct
		$name = $_POST['name'];
		if($name != $_SESSION['user_name'] && $name!="")
		{
			if((strlen($name) < 2) || (strlen($surname) > 255)) {
				$all_ok = false;
				$_SESSION['e_name'] = "Name must have at least 2 characters!";
			}

			if(ctype_alnum($name) == false) {
				$all_ok = false;
				$_SESSION['e_name'] = "Name must only have alphanumeric characters!";
			}
		}
		else
			$name = $_SESSION['user_name'];
		

		//Check if surname is correct
		$surname = $_POST['surname'];
		if($surname != $_SESSION['user_surname'] && $surname!="")
		{
			if((strlen($surname) < 2) || (strlen($surname) > 255)) {
				$all_ok = false;
				$_SESSION['e_surname'] = "Surname must  have at least 2 characters!";
			}

			if(ctype_alnum($surname) == false) {
				$all_ok = false;
				$_SESSION['e_surname'] = "Surname must only have alphanumeric characters!";
			}
		}
		else
			$surname = $_SESSION['user_surname'];

		//Check if email is correct
		$email = $_POST['email'];
		if($email != $_SESSION['user_email'] && $email!="")
		{
			$emailSecure = filter_var($email, FILTER_SANITIZE_EMAIL);

			if((filter_var($emailSecure, FILTER_VALIDATE_EMAIL) == false) || ($emailSecure != $email)) {
				$all_ok = false;
				$_SESSION['e_email'] = "Enter correct email address!";
			}
		}
		else
			$email = $_SESSION['user_email'];

		//Check if password is correct
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		if($password != $_SESSION['user_password'] && $password!="")
		{
			if((strlen($password) < 8) || (strlen($password) > 32)) {
				$all_ok = false;
				$_SESSION['e_password'] = "Password must have 8-32 characters!";
			}
			
			if($password != $password2) {
				$all_ok = false;
				$_SESSION['e_password'] = "Passwords are not identical!";
			}

			$password_hash = password_hash($password, PASSWORD_DEFAULT);
		}
		else
		{
			$password = $_SESSION['user_password'];
			$password2 = $_SESSION['user_password'];
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



		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
	
		try {
				$connection = new mysqli($host, $db_user, $db_password, $db_name);
				if($connection->connect_errno!=0) 
				{
					throw new Exception(mysqli_connect_errno());
				} 
				else 
				{
					//Check if email already exists in DB
					if(isset($_POST['email']) && $_POST['email'] != "")
					{
						$result = $connection->query("SELECT id FROM user WHERE email='$email'");

						if(!$result) throw new Exception($connection->error);

						$email_number = $result->num_rows; //email number == ilosc takich samych emaili
						if($email_number > 0) 
						{
							$all_ok = false;
							$_SESSION['e_email'] = "There is already an account with this email!";
						}
					}
					
					if($all_ok == true) {
						//All tests completed, add user to DB  
						if ($connection->query(
						//	"UPDATE user SET name='magda', surname='testowy' WHERE id=$_SESSION[user_id]"))
							"UPDATE user SET name='$name', surname='$surname', email='$email', password='$password', phone='$phone', street='$street',
							post_code='$post_code', city='$city', country='$country' WHERE id=$_SESSION[user_id]")) 
						{
							header('Location: adminHomePage.php');
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
		<?php 
			if((isset($_SESSION['loggedIn'])) && $_SESSION['user_type'] == 1)
			{
			echo '
			<section class="container-login">
				<div id="regbar">
					<div id="navthing">
						<h2><a href="logout.php">Logout</a> | <a href="adminHomePage.php">Your profile</a></h2>
					</div>
				</div>
			</section>';
			}
			else if((isset($_SESSION['loggedIn'])) && $_SESSION['user_type'] == 0)
			{
			echo '
			<section class="container-login">
				<div id="regbar">
					<div id="navthing">
						<h2><a href="logout.php">Logout</a> | <a href="user.php">Your profile</a> | <a href="cart.php"><img src="img/cart.png" /></a></h2>
					</div>
				</div>
			</section>';
			}
			else 
		echo '
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
									<input type="submit" value="Login" />';
									?>
									<?php
										if(isset($_SESSION['error']))
										echo $_SESSION['error'];
								echo '	
								</form>
							</div>
						</div>
					</div>
					</div>
				</div>
			</section>';
		?>
		<!-- Content -->
		<section class="container-content">
			<div class="content">
				<div class="row">
					<div class="col-xl-1 col-md-1 col-sm-1 col-xs-1">
					</div>
					<div class="col-xl-10 col-md-9 col-sm-10 col-xs-10">
						<div class="content-form">
							<p>Edit your data!</p>
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
									<input type="submit" value="Update" class="btn btn-primary" style="padding: 10px 90px">

							</form>
						</div>
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