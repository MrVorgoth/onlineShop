<?php
	session_start();

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	try {
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == 0) {
			throw new Exception('User not logged in.');
		}

		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0) 
		{
			throw new Exception(mysqli_connect_errno());
		} 
		else 
		{
			if(isset($_SESSION['cart'])) {
				$cart = $_SESSION['cart'];

 				$t=time();
				$dateTime = date("Y-m-d",$t);

				$cartQuery = $connection->query("INSERT INTO cart 
					VALUES (
						NULL,
						'".mysql_real_escape_string($_SESSION['user_id'])."',
						'".mysql_real_escape_string($cart['finalPrice'])."',
						'".$dateTime."'
					)");

				if(!$cartQuery) {
					throw new Exception($connection->error);
				}

				$cartId = $connection->insert_id;

				foreach($cart as $productId => $product) {
					if(is_numeric($productId)) {
						$cartItemQuery = $connection->query("INSERT INTO cart_item 
							VALUES (
								NULL,
								'".mysql_real_escape_string($productId)."',
								'".mysql_real_escape_string($cartId)."',
								'".mysql_real_escape_string($product['quantity'])."'
							)");

						if(!$cartItemQuery) {
							throw new Exception($connection->error);
						}
					}
				}

				unset($_SESSION['cart']);
			}

			header('Content-Type: application/json');
			print json_encode('Thank you for purchase!');
		}
	}
	catch(Exception $e) {
		header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($e->getMessage()));
	}

?>