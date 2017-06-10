<?php
	session_start();

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	if((!isset($_SESSION['loggedIn'])))
	{
		header('Location: index.php');
		exit();
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
  	<!-- Our main CSS -->
	<link rel="stylesheet" href="style.css" type="text/css">
	<!-- Admin css -->
	<link rel="stylesheet" href="style-adminHomePage.css" type="text/css">
	<!-- Google Fonts, Font Awesome -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700|Montserrat:400,700&amp;subset=latin-ext" rel="stylesheet">
	<!-- <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&amp;subset=latin-ext" rel="stylesheet"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
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
					<h2><a href="logout.php">Logout</a> | <a href="adminHomePage.php">Your profile</a></h2>
				</div>
			</div>
		</section>
		<!-- Content -->
		<section class="container-content">
			<div id="changeContentSize" class="content">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
						<div class="admin-photo">
							<h2>Your photo:</h2>
							<img src="img/admin_photo.png" width="200px" height="300px" />
						</div>
					</div>
					<div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
						<div class="admin-data">
							<h2>Your data:</h2>
							<table class="table table-striped">
										<?php
										echo '
											<tr><td>Name:</td><td>'.$_SESSION['user_name'].'</td></tr>
											<tr><td>Surname:</td><td>'.$_SESSION['user_surname'].'</td></tr>
											<tr><td>Email:</td><td>'.$_SESSION['user_email'].'</td></tr>
											<tr><td>Phone:</td><td>'.$_SESSION['user_phone'].'</td></tr>
											<tr><td>Street:</td><td>'.$_SESSION['user_street'].'</td></tr>
											<tr><td>Post code:</td><td>'.$_SESSION['user_post_code'].'</td></tr>
											<tr><td>City:</td><td>'.$_SESSION['user_city'].'</td></tr>
											<tr><td>Country:</td><td>'.$_SESSION['user_country'].'</td></tr>';
										?>
							</table>
							<div class="btn btn-adjust">
								<a href="editProfile.php">
									Edit profile
								</a>
							</div>	
						</div>				
					</div>
				</div>
				<div>
				<?php
					try {
						$connection = new mysqli($host, $db_user, $db_password, $db_name);

						if($connection->connect_errno!=0) 
						{
							throw new Exception(mysqli_connect_errno());
						} 
						else 
						{
							echo '<div class="row" style="margin-left: 0;">
								<input type="text" value="Name" />
								<input type="text" value="Category" class="widthCategoryInput" />
								<input type="text" value="Price" />
								<input type="text" value="Quantity" />
								<input type="text" value="Image URL" />
								<input type="text" value="Description" />';

							$sqlCategories = $connection->query("SELECT * FROM category");
							$categories = $sqlCategories->fetch_all(PDO::FETCH_NUM);
							$categoriesHtml = '';
							foreach ($categories as $category) {
								$categoriesHtml .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
							}

							$sqlItems = $connection->query("SELECT * FROM item");
							$items = $sqlItems->fetch_all(PDO::FETCH_NUM);

							foreach ($items as $item) {
								$categoriesHtmlForItem = '';
								foreach ($categories as $category) {
									$categoriesHtmlForItem .= '<option value="'.$category['id'].'" '.($category['id'] == $item['category_id'] ? 'selected' : '').'>'.$category['name'].'</option>';
								}

								echo '<form class="form-basic js-ajax-form">
									<input name="id" type="hidden" value="'.$item['id'].'">';
									if(isset($_SESSION['e_product_name'])) {
										echo $_SESSION['e_product_name'];
										unset($_SESSION['e_product_name']);
									}
								echo '<input name="name" type="text" value="'.$item['name'].'">
									<select name="category_id">'.
										$categoriesHtmlForItem
									.'</select>
									<input name="price" type="text" value="'.$item['price'].'">
									<input name="quantity" type="text" value="'.$item['quantity'].'">
									<input name="image_url" type="text" value="'.$item['image_url'].'">
									<input name="description" type="text" value="'.$item['description'].'">
									<button class="js-edit-product">Save</button>
								</form>';
							}

							echo '<form class="form-basic js-ajax-form js-new-product-form" style="display:none;">
								<input name="id" type="hidden" value="">
								<input name="name" type="text" value="">
								<select name="category_id">'.
									$categoriesHtml
								.'</select>
								<input name="price" type="text" value="">
								<input name="quantity" type="text" value="">
								<input name="image_url" type="text" value="">
								<input name="description" type="text" value="">
								<button class="js-add-product">Save</button>
							</form>';
						}
					}
					catch(Exception $e) {
						echo '<span style="color: red;">Server error! WARNING!!!</span>';
						// Do wyrzucenia potem
						echo '<br /> Developer error info: '.$e;
					}
					echo '</div>';
				?>
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
					<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
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

	<?php include 'alerts.html';?>

	<!-- Script -->
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="js/index.js"></script>
	<script src="alerts.js"></script>
	<script src="adminHomePage.js"></script>
</body>
</html>