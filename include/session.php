<?php 
session_start();

require_once 'const.php';
require_once 'db.php';



		// POST actions

if(isset($_POST['action'])){
	$fl = false;
	if($_POST['action'] == 'add'){
		if(isset($_POST['product_id'])){
			if(!empty($_SESSION['cart'])){
					foreach($_SESSION['cart'] as $key => $cartProduct){
						if($cartProduct['product_id'] == $_POST['product_id']){
							$_SESSION['cart'][$key]['amount']++;
							$fl = true;
							$answer = json_encode(['success' => true]);
							break;
						}
					}
				if(!$fl){
					$arr = array('product_id'=>$_POST['product_id'], 'amount'=>'1');
					 array_push($_SESSION['cart'], $arr);
					 $answer = json_encode(['success' => true]);
				}
			} else {
				$_SESSION['cart'] = [0 =>['product_id' => $_POST['product_id'],
							'amount' => 1]];
				$answer = json_encode(['success' => true]);
			}
		}else {
			$answer = json_encode(['success' => false]);
		}
		echo $answer;
	}
	if($_POST['action'] == 'delete'){
		if(!empty($_SESSION['cart'])){
			foreach($_SESSION['cart'] as $key => $cartProduct){
				if($cartProduct['product_id'] == $_POST['product_id']){
					unset($_SESSION['cart'][$key]);
					break;
				}
			}
		} 
		$answer = json_encode(['amount' => getProductsAmount(), 'totalPrice' => getTotalPrice($_SESSION['cart'])]);
		echo $answer;
	}
	if($_POST['action'] == 'getAmount'){
		$amount = 0;
		foreach($_SESSION['cart'] as $key => $cartProduct){
			if($cartProduct['product_id'] == $_POST['product_id']){
				$amount += $_SESSION['cart'][$key]['amount'];				
			}
		}
		$answer = json_encode(['amount' => $amount]);
		echo $answer;
	}

	if($_POST['action'] == 'getTotalPrice'){
		$answer = json_encode(['totalPrice' => getTotalPrice($_SESSION['cart'])]);
		echo $answer;
	}

	if($_POST['action'] == 'decrease'){
		foreach($_SESSION['cart'] as $key => $cartProduct){
			if($cartProduct['product_id'] == $_POST['product_id']){
				$_SESSION['cart'][$key]['amount']--;
				break;
			}
		}
	}

	if($_POST['action'] == 'getCart'){
		$cartData = $_SESSION['cart'];
		foreach ($cartData as &$value) {
			$data = getProductData($value['product_id']);
			$value += array('price' => myPrice($data[0]['price']),
				'product_name' => $data[0]['product_name'],
				'vendor_code' => $data[0]['vendor_code']
			);
		}

		echo json_encode($cartData);
	}

	if($_POST['action'] == 'confirmOrder'){

		if (!empty($_SESSION['cart'])){
	
			$order = [];

			$order['customerName'] = $_POST['clientName'];
			$order['customerEmail'] = $_POST['clientEmail'];
			$order['customerTel'] = $_POST['clientTel'];
			$order['customerAddress'] = $_POST['clientAddress'];
			$order['deliveryMethod'] = $_POST['delivery'];
			$order['paymentMethod'] = $_POST['payment'];
			$order['orderItems'] = $_SESSION['cart'];

//			INSERT TO shop.orders

			$sqlStr = 'INSERT INTO shop.orders (customer_name, payment_method, delivery_method, customer_tel, customer_email, customer_address) 
				VALUES ("' . $order['customerName'] . '" , "'. $order['paymentMethod'] . '", "' . $order['deliveryMethod'] . '", "' .  $order['customerTel'] . '", "' . $order['customerEmail'] . 
				'", "' . $order['customerAddress']  . '");';

			try{
				global $pdo;
				$stmt = $pdo->prepare($sqlStr);
				$state = $stmt->execute();
			} catch (Exception $e) {
			    echo $e->getMessage();
			    exit;
			}


//			INSERT TO shop.orders_items		

			if($state){

				$sqlStr = 'INSERT INTO shop.orders_items (order_id, product_id, amount) VALUES ';

				foreach ($order['orderItems'] as $product){				
					$sqlStr .= '(LAST_INSERT_ID(), ' . $product['product_id'] . ', ' . $product['amount'] . '),';
				}
				$sqlStr = substr_replace($sqlStr, ';', -1);

				try{
					global $pdo;
					$stmt = $pdo->prepare($sqlStr);
					$state = $stmt->execute();
				} catch (Exception $e) {
				    echo $e->getMessage();
				    exit;
				}

				if ($state){


					// Файлы phpmailer
					require '../phpmailer/PHPMailer.php';
					require '../phpmailer/SMTP.php';
					require '../phpmailer/Exception.php';
					require 'def.php'

					global $emailPass;


					// Формирование самого письма
					$title = "Поступил новый заказ";
					$body = "<p>Имя: " .  $order['customerName'] . "</p>	";

					// Настройки PHPMailer
					$mail = new PHPMailer\PHPMailer\PHPMailer();
					try {
					    $mail->isSMTP();   
					    $mail->CharSet = "UTF-8";
					    $mail->SMTPAuth   = true;
					//    $mail->SMTPDebug = 2;
					    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

					    // Настройки вашей почты
					    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
					    $mail->Username   = '2874787@gmail.com'; // Логин на почте
					    $mail->Password   = $emailPass; // Пароль на почте
					    $mail->SMTPSecure = 'ssl';
					    $mail->Port       = 465;
					    $mail->setFrom('2874787@gmail.com', 'Владислав'); // Адрес самой почты и имя отправителя

					    // Получатель письма
					    $mail->addAddress('cppcoder@mail.ru');  
					    // $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

					    // Прикрипление файлов к письму
					if (!empty($file['name'][0])) {
					    for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
					        $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
					        $filename = $file['name'][$ct];
					        if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
					            $mail->addAttachment($uploadfile, $filename);
					            $rfile[] = "Файл $filename прикреплён";
					        } else {
					            $rfile[] = "Не удалось прикрепить файл $filename";
					        }
					    }   
					}
					// Отправка сообщения
					$mail->isHTML(true);
					$mail->Subject = $title;
					$mail->Body = $body;    

					// Проверяем отравленность сообщения
					if ($mail->send()) {$result = "success";} 
					else {$result = "error";}

					} catch (Exception $e) {
					    $result = "error";
					    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
					}

					// Отображение результата
					echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);



				}
			}

			// echo $sqlStr;



//			TEST
			// foreach ($_SESSION['cart'] as $value) {
			// 	var_dump(getProductData($value['product_id']));
			// }

			// var_dump($order);
			// echo json_encode(['confirm'=>'success']);
			// echo $state;

			
	//		END OF TEST


		}
	else echo 'empty cart';
	}
}



function getProductsAmount() {
	$amount = 0;
	if(isset($_SESSION['cart'])){
		foreach ($_SESSION['cart'] as  $value) {
			$amount += (int) $value['amount'];
		}
	}
	return $amount;
}

function getTotalPrice($products){
	// require_once 'db.php';
	$sqlReqStr = "SELECT price, product_id FROM shop.products WHERE product_id IN (";
	if (!empty($products)){
		foreach ($products as $product){
			$sqlReqStr .= $product['product_id'] . ', ';
		}
		$sqlReqStr = substr_replace($sqlReqStr, ');', -2);

		try{
			global $pdo;
			$stmt = $pdo->prepare($sqlReqStr);
			$state = $stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
		    echo $e->getMessage();
		    exit;
		}
	} else {
		return 0;
	}
	$totalPrice = 0;
	foreach ($data as $price) {
		$amount = 0;
		foreach ($products as $product) {
			if($product['product_id'] == $price['product_id']){
				$amount = $product['amount'];
				$totalPrice += myPrice($price['price']) * $amount;
			}
		}
		
	}

	return $totalPrice;
}



function getProductData($productId){
	global $pdo; 

	$sqlReqStr = "SELECT product_name, vendor_code, price FROM shop.products WHERE product_id = " . $productId . ';';

	try{		
		$stmt = $pdo->prepare($sqlReqStr);
		$state = $stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	    echo $e->getMessage();
	    exit;
	}
	return $data;
}