<?php 
session_start();

require_once 'const.php';
require_once 'db.php';



		// POST actions
if(isset($_POST['action'])){	
	$fl = false;


	if($_POST['action'] == 'add'){

		//ADD TO SESSION FROM AJAX POST

		if(isset($_POST['product_id'])){
			if(!empty($_SESSION['cart'])){
				foreach($_SESSION['cart'] as $key => $cartProduct){

					if($cartProduct['product_id'] == $_POST['product_id']){						

						
						if($_SESSION['cart'][$key]['size']){

							//SIZEBLE PRODUCT
							$size = isset($_POST['size']) ? $_POST['size'] : false; 							
							$arr = array('product_id'=>$_POST['product_id'], 'amount'=>'1', 'size'=>$size);
							array_push($_SESSION['cart'], $arr);

						} else $_SESSION['cart'][$key]['amount']++;

						$fl = true;
						$answer = json_encode(['success' => true]);
						break;
						}

					}
				}
				if(!$fl){
					$size = isset($_POST['size']) ? $_POST['size'] : false;
					$arr = array('product_id'=>$_POST['product_id'], 'amount'=>'1', 'size'=>$size);
					 array_push($_SESSION['cart'], $arr);
					 $answer = json_encode(['success' => true]);
				}

			 else {
			 	$size = isset($_POST['size']) ? $_POST['size'] : false;
				$_SESSION['cart'] = [0 =>['product_id' => $_POST['product_id'],	'amount' => 1, 'size' => $size]];
				$answer = json_encode(['success' => true]);
				echo $answer;
			}

		}else {
			$answer = json_encode(['success' => false]);
		}
		echo $answer;
	}
	//END OF ADD



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


					$sqlStr = 'SELECT LAST_INSERT_ID() AS order_id;';
					try{
						global $pdo;
						$stmt = $pdo->prepare($sqlStr);
						$state = $stmt->execute();
						$orderId = $stmt->fetchAll();
					} catch (Exception $e) {
					    echo $e->getMessage();
					    exit;
					}

					// var_dump($orderId);

					// Файлы phpmailer
					require '../phpmailer/PHPMailer.php';
					require '../phpmailer/SMTP.php';
					require '../phpmailer/Exception.php';
					require 'def.php';

					global $emailPass;



					// Формирование самого письма
					$title = "Ваш заказ принят";
					$body = '<img src = "pyxl.site/logo.jpg">' . 
					'<h1>Благодарим Вас за заказ в нашем интернет магазине! </h1>' .
					'<h2>В ближайшее время с Вами свяжется наш менеджер</h2>' .
					'<p>С радостью ответим на ваши вопросы по телефону: <a href="tel: +7 923 570 41 53">+7 923 570 41 53</a></p>' .
					'<p> Номер Вашего заказа: '	. $orderId[0]['order_id'] . 				
					"<p>Имя: " .  $order['customerName'] . "</p>	" .
					'<p>e-mail:' . $order['customerEmail'] . '</p>' .
					'<p>Tel:' . $order['customerTel'] . '</p>' .
					'<p>Address:' . $order['customerAddress'] . '</p>';

					$body .= '<ol>';

					foreach ($order['orderItems'] as  $value) {
						$productData = getProductData($value['product_id']);
						$body .= '<li>' . $productData[0]['product_name'] . ' ' . $value['amount'] .  ' шт. ' . myPrice($productData[0]['price']) . 'р. </li>'; 
					};

					$body .= '</ol>';

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
					    $mail->Username   = 'krasivokrsk@gmail.com'; // Логин на почте
					    $mail->Password   = $emailPass; // Пароль на почте
					    $mail->SMTPSecure = 'ssl';
					    $mail->Port       = 465;
					    $mail->setFrom('krasivokrsk@gmail.com', 'Интернет магазин KRASIVO'); // Адрес самой почты и имя отправителя

					    // Получатель письма
					    $mail->addAddress('krasivokrsk@gmail.com');  
					    $mail->addAddress($order['customerEmail']); // Ещё один, если нужен

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
					echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status, 'confirm'=>'success']);
					// echo $answer;


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