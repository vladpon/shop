<?php 
require_once 'Product.php';
require_once 'CartItem.php';
require_once 'Cart.php';
session_start();

require_once 'const.php';
require_once 'dbhandler.php';


// var_dump([$_POST]);

if(isset($_POST['action'])){
	// $fl = false;

	if($_POST['action'] == 'add'){

	//ADD PRODUCT 

		if(isset($_POST['product_id'])){
			$productData = getProductData($_POST['product_id']);	
			$product = new Product($_POST['product_id'], $productData[0]['product_name'], myPrice($productData[0]['price']));

			$cart = empty($_SESSION['cart']) ? new Cart() : $_SESSION['cart'];
			$size = isset($_POST['size']) ? $_POST['size'] : false;

			// var_dump($cart);
			$cart->addProduct($product, 1, $size);

			$_SESSION['cart'] = $cart;
		

		}else {
			//err: no product id in POST
			$answer = json_encode(['success' => false]);
		}
		echo $answer;
	}

	//END OF ADD

	if($_POST['action'] == 'getCart'){
		$cart = getCart();		 
		echo json_encode($cart);
	}

	if($_POST['action'] == 'delete'){
		$productId = $_POST['product_id'];
		$size = $_POST['size'];
		$cart = $_SESSION['cart'];

		$a = new Cart();
		$b = $a;
		var_dump($b);
		$p = new Product(1, 'name', 1);
		$a->addProduct($p, 1, 1);
		var_dump($b);

		// $cart->removeCartItem($productId, $size);		
		// var_dump($_SESSION['cart']);
		// var_dump($cart);
		// echo getCart();

		// $_SESSION['cart'] = $cart;
	}

}

function getCart(){
	$cart_arr = array();
	if(isset($_SESSION['cart'])){			
		$cart = $_SESSION['cart'];
		$cart_arr['totalSum'] = $cart->getTotalSum();
		$cart_arr['totalQuantity'] = $cart->getTotalQuantity();
		$cartItems = $cart->getItems();			
		
		foreach ($cartItems as $cartItem) {
			$arr =  array();
			$arr['product'] =  array();
			$arr['product']['productId'] = $cartItem->getProduct()->getProductId();
			$arr['product']['productName'] = $cartItem->getProduct()->getProductName();
			$arr['product']['price'] = $cartItem->getProduct()->getPrice();
			$arr['quantity'] = $cartItem->getQuantity();
			$arr['size'] = $cartItem->getSize();
			array_push($cart_arr, $arr);
		}
		return $cart_arr;

	} else return false;
}

function getProductsAmount(){
	if(isset($_SESSION['cart'])){
		//count products in cart
		$cart = $_SESSION['cart'];
		return $cart->getTotalQuantity();
	}
}

function getTotalPrice() {
	if(isset($_SESSION['cart'])){
		$cart = $_SESSION['cart'];
		return $cart->getTotalSum();
	} else return 0;
}

function getCartItems(){
	if(isset($_SESSION['cart'])){
		$cart = $_SESSION['cart'];
		return $cart->getItems();
	} else return false;
}




// 	if($_POST['action'] == 'delete'){
// 		if(!empty($_SESSION['cart'])){
// 			foreach($_SESSION['cart'] as $key => $cartProduct){
// 				if($cartProduct['product_id'] == $_POST['product_id']){
// 					unset($_SESSION['cart'][$key]);
// 					break;
// 				}
// 			}
// 		} 
// 		$answer = json_encode(['amount' => getProductsAmount(), 'totalPrice' => getTotalPrice($_SESSION['cart'])]);
// 		echo $answer;
// 	}
// 	if($_POST['action'] == 'getAmount'){
// 		$amount = 0;
// 		foreach($_SESSION['cart'] as $key => $cartProduct){
// 			if($cartProduct['product_id'] == $_POST['product_id']){
// 				$amount += $_SESSION['cart'][$key]['amount'];				
// 			}
// 		}
// 		$answer = json_encode(['amount' => $amount]);
// 		echo $answer;
// 	}

// 	if($_POST['action'] == 'getTotalPrice'){
// 		$answer = json_encode(['totalPrice' => getTotalPrice($_SESSION['cart'])]);
// 		echo $answer;
// 	}

// 	if($_POST['action'] == 'decrease'){
// 		foreach($_SESSION['cart'] as $key => $cartProduct){
// 			if($cartProduct['product_id'] == $_POST['product_id']){
// 				$_SESSION['cart'][$key]['amount']--;
// 				break;
// 			}
// 		}
// 	}

// 	if($_POST['action'] == 'getCart'){
// 		$cartData = $_SESSION['cart'];
// 		foreach ($cartData as &$value) {
// 			$data = getProductData($value['product_id']);
// 			$value += array('price' => myPrice($data[0]['price']),
// 				'product_name' => $data[0]['product_name'],
// 				'vendor_code' => $data[0]['vendor_code']
// 			);
// 		}

// 		echo json_encode($cartData);
// 	}

// 	if($_POST['action'] == 'confirmOrder'){

// 		if (!empty($_SESSION['cart'])){
	
// 			$order = [];

// 			$order['customerName'] = $_POST['clientName'];
// 			$order['customerEmail'] = $_POST['clientEmail'];
// 			$order['customerTel'] = $_POST['clientTel'];
// 			$order['customerAddress'] = $_POST['clientAddress'];
// 			$order['deliveryMethod'] = $_POST['delivery'];
// 			$order['paymentMethod'] = $_POST['payment'];
// 			$order['orderItems'] = $_SESSION['cart'];

// //			INSERT TO shop.orders

// 			$sqlStr = 'INSERT INTO shop.orders (customer_name, payment_method, delivery_method, customer_tel, customer_email, customer_address) 
// 				VALUES ("' . $order['customerName'] . '" , "'. $order['paymentMethod'] . '", "' . $order['deliveryMethod'] . '", "' .  $order['customerTel'] . '", "' . $order['customerEmail'] . 
// 				'", "' . $order['customerAddress']  . '");';

// 			try{
// 				global $pdo;
// 				$stmt = $pdo->prepare($sqlStr);
// 				$state = $stmt->execute();
// 			} catch (Exception $e) {
// 			    echo $e->getMessage();
// 			    exit;
// 			}


// //			INSERT TO shop.orders_items		

// 			if($state){

// 				$sqlStr = 'INSERT INTO shop.orders_items (order_id, product_id, amount) VALUES ';

// 				foreach ($order['orderItems'] as $product){				
// 					$sqlStr .= '(LAST_INSERT_ID(), ' . $product['product_id'] . ', ' . $product['amount'] . '),';
// 				}
// 				$sqlStr = substr_replace($sqlStr, ';', -1);

// 				try{
// 					global $pdo;
// 					$stmt = $pdo->prepare($sqlStr);
// 					$state = $stmt->execute();
// 				} catch (Exception $e) {
// 				    echo $e->getMessage();
// 				    exit;
// 				}

// 				if ($state){


// 					$sqlStr = 'SELECT LAST_INSERT_ID() AS order_id;';
// 					try{
// 						global $pdo;
// 						$stmt = $pdo->prepare($sqlStr);
// 						$state = $stmt->execute();
// 						$orderId = $stmt->fetchAll();
// 					} catch (Exception $e) {
// 					    echo $e->getMessage();
// 					    exit;
// 					}

// 					// var_dump($orderId);

// 					// Файлы phpmailer
// 					require '../phpmailer/PHPMailer.php';
// 					require '../phpmailer/SMTP.php';
// 					require '../phpmailer/Exception.php';
// 					require 'def.php';

// 					global $emailPass;



// 					// Формирование самого письма
// 					$title = "Ваш заказ принят";
// 					$body = '<img src = "pyxl.site/logo.jpg">' . 
// 					'<h1>Благодарим Вас за заказ в нашем интернет магазине! </h1>' .
// 					'<h2>В ближайшее время с Вами свяжется наш менеджер</h2>' .
// 					'<p>С радостью ответим на ваши вопросы по телефону: <a href="tel: +7 923 570 41 53">+7 923 570 41 53</a></p>' .
// 					'<p> Номер Вашего заказа: '	. $orderId[0]['order_id'] . 				
// 					"<p>Имя: " .  $order['customerName'] . "</p>	" .
// 					'<p>e-mail:' . $order['customerEmail'] . '</p>' .
// 					'<p>Tel:' . $order['customerTel'] . '</p>' .
// 					'<p>Address:' . $order['customerAddress'] . '</p>';

// 					$body .= '<ol>';

// 					foreach ($order['orderItems'] as  $value) {
// 						$productData = getProductData($value['product_id']);
// 						$body .= '<li>' . $productData[0]['product_name'] . ' ' . $value['amount'] .  ' шт. ' . myPrice($productData[0]['price']) . 'р. </li>'; 
// 					};

// 					$body .= '</ol>';

// 					// Настройки PHPMailer
// 					$mail = new PHPMailer\PHPMailer\PHPMailer();
// 					try {
// 					    $mail->isSMTP();   
// 					    $mail->CharSet = "UTF-8";
// 					    $mail->SMTPAuth   = true;
// 					//    $mail->SMTPDebug = 2;
// 					    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

// 					    // Настройки вашей почты
// 					    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
// 					    $mail->Username   = 'krasivokrsk@gmail.com'; // Логин на почте
// 					    $mail->Password   = $emailPass; // Пароль на почте
// 					    $mail->SMTPSecure = 'ssl';
// 					    $mail->Port       = 465;
// 					    $mail->setFrom('krasivokrsk@gmail.com', 'Интернет магазин KRASIVO'); // Адрес самой почты и имя отправителя

// 					    // Получатель письма
// 					    $mail->addAddress('krasivokrsk@gmail.com');  
// 					    $mail->addAddress($order['customerEmail']); // Ещё один, если нужен

// 					    // Прикрипление файлов к письму
// 					if (!empty($file['name'][0])) {
// 					    for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
// 					        $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
// 					        $filename = $file['name'][$ct];
// 					        if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
// 					            $mail->addAttachment($uploadfile, $filename);
// 					            $rfile[] = "Файл $filename прикреплён";
// 					        } else {
// 					            $rfile[] = "Не удалось прикрепить файл $filename";
// 					        }
// 					    }   
// 					}
// 					// Отправка сообщения
// 					$mail->isHTML(true);
// 					$mail->Subject = $title;
// 					$mail->Body = $body;    

// 					// Проверяем отравленность сообщения
// 					if ($mail->send()) {$result = "success";} 
// 					else {$result = "error";}

// 					} catch (Exception $e) {
// 					    $result = "error";
// 					    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
// 					}

// 					// Отображение результата
// 					echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status, 'confirm'=>'success']);
// 					// echo $answer;


// 				}
// 			}

// 			// echo $sqlStr;



// //			TEST
// 			// foreach ($_SESSION['cart'] as $value) {
// 			// 	var_dump(getProductData($value['product_id']));
// 			// }

// 			// var_dump($order);
// 			// echo json_encode(['confirm'=>'success']);
// 			// echo $state;

			
// 	//		END OF TEST


// 		}
// 	else echo 'empty cart';
// 	}
// }



// function getProductsAmount() {
// 	$amount = 0;
// 	if(isset($_SESSION['cart'])){
// 		foreach ($_SESSION['cart'] as  $value) {
// 			$amount += (int) $value['amount'];
// 		}
// 	}
// 	return $amount;
// }

// function getTotalPrice($products){
// 	// require_once 'db.php';
// 	$sqlReqStr = "SELECT price, product_id FROM shop.products WHERE product_id IN (";
// 	if (!empty($products)){
// 		foreach ($products as $product){
// 			$sqlReqStr .= $product['product_id'] . ', ';
// 		}
// 		$sqlReqStr = substr_replace($sqlReqStr, ');', -2);

// 		try{
// 			global $pdo;
// 			$stmt = $pdo->prepare($sqlReqStr);
// 			$state = $stmt->execute();
// 			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
// 		} catch (Exception $e) {
// 		    echo $e->getMessage();
// 		    exit;
// 		}
// 	} else {
// 		return 0;
// 	}
// 	$totalPrice = 0;
// 	foreach ($data as $price) {
// 		$amount = 0;
// 		foreach ($products as $product) {
// 			if($product['product_id'] == $price['product_id']){
// 				$amount = $product['amount'];
// 				$totalPrice += myPrice($price['price']) * $amount;
// 			}
// 		}
		
// 	}

// 	return $totalPrice;
// }



