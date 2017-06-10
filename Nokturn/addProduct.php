<?php
	session_start();

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	//walidacja - start
	$all_ok = true;
	$walidacja = "";


	$name = $_POST['name'];
	if(((strlen($name) < 2) || (strlen($surname) > 255)) || ctype_alnum($name) == false)  {
		$all_ok = false;
		$walidacja .= "Name must have at least 2 alphanumeric characters!";
	}

	$quantity = $_POST['quantity'];
	if(ctype_digit($quantity) == false) {
		$all_ok = false;
		$walidacja .= "<br/>Quantity must only have numeric characters!";
	}


	$pattern = '/^\d+(?:\.\d{2})?$/';
	$price = $_POST['price'];
	if (preg_match($pattern, $price) == '0') {
	   $all_ok = false;
       $walidacja .= "<br/>Enter correct price!";
	}

	$image_url = $_POST['image_url'];

	header('HTTP/1.1 500 Internal Server Error');
	header('Content-Type: application/json; charset=UTF-8');
	die(json_encode($walidacja));
	//walidacja - stop
	
	$description = $_POST['description'];
	$category_id = $_POST['category_id'];


	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0) 
		{
			throw new Exception(mysqli_connect_errno());
		} 
		else 
		{
			if ($all_ok)
			{
				$result = $connection->query("INSERT INTO item 
				VALUES (
					NULL,
					'".mysql_real_escape_string($category_id)."',
					'".mysql_real_escape_string($name)."',
					'".mysql_real_escape_string($price)."',
					'".mysql_real_escape_string($quantity)."',
					'".mysql_real_escape_string($image_url)."',
					'".mysql_real_escape_string($description)."'
				)");

				if ($result)
				{
					header('Content-Type: application/json');
	        		print json_encode($connection->insert_id);
				}
				else 
				{
					throw new Exception($connection->error);
				}
			}
		}
	}
	catch(Exception $e) {
		header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($e->getMessage()));
	}

?>