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
			$productQuery = $connection->query("SELECT * FROM item WHERE id = " . $productId);

			if(!$productQuery) {
				throw new Exception($connection->error);
			}

			if ($productQuery)
			{
				$product = $productQuery->fetch_assoc();

				//check if product exists
				if(!$product) {
					throw new Exception('Product doesn\'t exists');
				}

				//check if is quantity
				if($product['quantity'] < $quantity) {
					throw new Exception('Not enough products');
				}

				//add product to session cart
				if(isset($_SESSION['cart']) && isset($_SESSION['cart'][$productId])) {
					$sessionCartProduct = $_SESSION['cart'][$productId];

					$cartProduct = [
						'name' => $product['name'],
						'price' => $product['price'],
						'image_url' => $product['image_url'],
						'totalPrice' => ($product['price'] * $quantity) + $sessionCartProduct['totalPrice'],
						'quantity' => $quantity + $sessionCartProduct['quantity']
					];

					$_SESSION['cart'][$productId] = $cartProduct;
				} else {
					$cartProduct = [
						'name' => $product['name'],
						'price' => $product['price'],
						'image_url' => $product['image_url'],
						'totalPrice' => $product['price'] * $quantity,
						'quantity' => $quantity
					];

					$_SESSION['cart'][$productId] = $cartProduct;
				}

				$finalPrice = 0;
				
				foreach($_SESSION['cart'] as $cartProduct) {
					$finalPrice += $cartProduct['totalPrice'];
				}

				$_SESSION['cart']['finalPrice'] = $finalPrice;

				// print_r($_SESSION['cart']);

				//remove product quantity from db
				$productQuantityQuery = $connection->query("UPDATE item SET quantity = " . ($product['quantity'] - $quantity) . " WHERE id = " . $productId);

				if(!$productQuantityQuery) {
					throw new Exception($connection->error);
				}

				header('Content-Type: application/json');
				print json_encode('Product added to cart');
			}
		}
	}
	catch(Exception $e) {
		header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($e->getMessage()));
	}

?>