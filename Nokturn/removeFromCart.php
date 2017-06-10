<?php
	session_start();

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	$productId = $_POST['productId'];
	$quantity = $_POST['quantity'];

	try {
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0) 
		{
			throw new Exception(mysqli_connect_errno());
		} 
		else 
		{
			$productQuantityQuery = $connection->query("UPDATE item SET quantity = quantity + " . $quantity . " WHERE id = " . $productId);

			if(!$productQuantityQuery) {
				throw new Exception($connection->error);
			}

			if(isset($_SESSION['cart']) && isset($_SESSION['cart'][$productId])) {
				$cartProduct = $_SESSION['cart'][$productId];
				$finalPrice = $_SESSION['cart']['finalPrice'];
				$_SESSION['cart']['finalPrice'] = $finalPrice - $cartProduct['totalPrice'];

				unset($_SESSION['cart'][$productId]);

				if(count($_SESSION['cart']) <= 1) {
					unset($_SESSION['cart']);
				}
			}

			header('Content-Type: application/json');
			print json_encode('Product removed from cart');
		}
	}
	catch(Exception $e) {
		header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($e->getMessage()));
	}

?>