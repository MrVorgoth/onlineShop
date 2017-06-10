<?php
	session_start();

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	$id = $_POST['id'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$quantity = $_POST['quantity'];
	$description = $_POST['description'];
	$image_url = $_POST['image_url'];
	$category_id = $_POST['category_id'];

	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		} 
		else 
		{
			$result = $connection->query("UPDATE item
				SET category_id = '".mysql_real_escape_string($category_id)."',
				name = '".mysql_real_escape_string($name)."',
				price = '".mysql_real_escape_string($price)."',
				quantity = '".mysql_real_escape_string($quantity)."',
				image_url = '".mysql_real_escape_string($image_url)."',
				description = '".mysql_real_escape_string($description)."'
				WHERE id='".mysql_real_escape_string($id)."'
			");

			if ($result)
			{
				header('Content-Type: application/json');
        		print json_encode($result);
			}
			else 
			{
				throw new Exception($connection->error);
			}
		}
	}
	catch(Exception $e) {
		header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR', 'info' => $e->getMessage())));
	}

?>