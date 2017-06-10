<?php

	session_start();

	if((!isset($_POST['email'])) || (!isset($_POST['password']))) {
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if($connection->connect_errno!=0) {
		echo "Error: ".$connection->connect_errno;
	} else 
	{
		$email = $_POST['email'];
		$password = $_POST['password'];
		$pass = md5($password);

		$email = htmlentities($email, ENT_QUOTES, "UTF-8");


		if($result = @$connection->query(
			sprintf("SELECT * FROM user WHERE email='%s'",
			mysqli_real_escape_string($connection,$email)))) 
		{
			// how much users returned by this query (0 or 1)
			$user_number = $result->num_rows;
			if($user_number > 0) 
			{
				$row = $result->fetch_assoc();

			if ($pass == $row['password']) 
			//	if(password_verify($password, $row['password'])) 
				{
					$_SESSION['loggedIn'] = true;
					$_SESSION['user_id'] = $row['id'];
					$_SESSION['user_email'] = $row['email'];
					$_SESSION['user_name'] = $row['name'];
					$_SESSION['user_surname'] = $row['surname'];
					$_SESSION['user_phone'] = $row['phone'];
					$_SESSION['user_street'] = $row['street'];
					$_SESSION['user_post_code'] = $row['post_code'];
					$_SESSION['user_city'] = $row['city'];
					$_SESSION['user_country'] = $row['country']; 
					$_SESSION['user_type'] = $row['type'];
					$_SESSION['user_password'] = $row['password'];

					unset($_SESSION['error']);
					$result->close();

					header('Location: index.php');
				} 
				else 
				{
					$_SESSION['error'] = '<span style="color: red;">Wrong login or password!</span>';
					header('Location: index.php');
				}
			} 
			else
			{
				$_SESSION['error'] = '<span style="color: red;">Wrong login or password!</span>';
				header('Location: index.php');
			}
		}
		$connection->close();
	}
?>