<?php
require_once 'include/session.php';

require_once 'include/const.php';
require 'include/db.php';

global $pdo;
global $aAtr;
global $aAtrItems;

$data;
$sqlReqStr = "SELECT * FROM shop.products WHERE product_id IN (";
if (!empty($_SESSION['cart'])){
	foreach ($_SESSION['cart'] as $product){
		$sqlReqStr .= $product['product_id'] . ', ';
	}
	$sqlReqStr = substr_replace($sqlReqStr, ');', -2);

	try{
		$stmt = $pdo->prepare($sqlReqStr);
		$state = $stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	    echo $e->getMessage();
	    exit;
	}
}


function showCartItem($product){
	?>
	
		<div class="cart__product" id=<?=$product['product_id']?>>
			<div class="cart__product-left">
				<img class="cart__product-image" src=<?=$product['small_pic']?>>
				<div class="cart__count">
					<span>-</span>
					<span>7</span>
					<span>+</span>
				</div>
			</div>
			<div class="cart__product-right">
				<div class="cart__product-describe">
					<p><?=$product['product_name']?></p>
					<p>Артикул: <?=$product['vendor_code']?></p>
					<p>Проба: <?=$product['fineness']?></p>
					<p>Покрытик: <?=$product['cover']?></p>
					<p>Вставка: <?=$product['stone']?></p>								
				</div>
				<div class="cart__price">							
					<span><?=myPrice($product['price'])?></span>
					<img class='delete-from-cart' data-product-id=<?=$product['product_id'];?> src="svg/trash.svg">
				</div>
			</div>
			<div class="cart__line"></div>
		</div>
	<?php	
}

function showTotalPrice($data){
	$totalPrice = 0;
	foreach ($data as $product) {
		$totalPrice += myPrice($product['price']);
	}
	echo 	'<div class="cart__total">
				Итого: <span>' . $totalPrice . '</span>
			</div>';
	return $totalPrice;
}


function showForm($totalPrice){
	?>

		<form action="#" method="POST" accept-charset="UTF-8" name="clientData" class="cart__form">
			<div class="cart__client-data">							
				<input type="text" name="clientName" placeholder="ФИО">
				<input type="e-mail" name="clientEmail" placeholder="e-mail">
				<input type="tel" name="clientTel" placeholder="телефон">
				<input type="text" name="clientAddress" placeholder="адрес">						
				<div class="cart__delivery">
					<div class="cart__delivery-title">Способ доставки:</div>
					<div class="cart__deliveries">
						<p><input type="radio" name="delivery">Курьер (только Красноярск) - бесплатно<p>
<!-- 						<p><input type="radio" name="delivery">СДЭК</p>
						<p><input type="radio" name="delivery">Почта</p> -->
					</div>
				</div>
				<div class="cart__payment">
					<div class="cart__payment-title">Способ оплаты:</div>
					<div class="cart__payments">
						<p><input type="radio" name="payment">При получении<p>
						<p><input type="radio" name="payment">Оплата онлайн</p>
					</div>									
				</div>
			</div>
			<div class="cart__totality"><span><?=$totalPrice?></span></div>
			<input class="big-button" type="submit" name="" value="Оформить заказ">
		</form>
	<?php
}

?>

<!DOCTYPE html>
	<html>
		<head>
			<meta name = "viewport" content = "width = device-width, initial-scale = 1">
			<meta charset="utf-8">
			<title>Krasivo Shop &#174</title>

			<link rel="preconnect" href="https://fonts.gstatic.com">
			<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

			<link rel="stylesheet"  href="../css/reset.css" >
			<link rel="stylesheet"  href="../css/style.css" > 

			<link rel="stylesheet" href="css/swiper-bundle.min.css">
		</head>
		<body>
			<div class="wrapper">
				<header class="header">
					<div class="container">
						
						<?php require('include/header.php');?>

					</div>
				</header>



				<div class="content container">


					<div class="breadcrumbs">
						<a href="#">Главная / </a>
						<a href="#">Каталог / </a>
					</div>


					<!-- CART-CONTAINER -->
					<div class="cart-container cart">
						
						<div class="cart__product-container">
							<?php
								if(!empty($_SESSION['cart'])){
									foreach($data as $product){
										showCartItem($product);
									}
									$totalPrice = showTotalPrice($data);
									showForm($totalPrice);
								} else {
									echo '<div class="cart__empty"><i>Корзина пуста...</i></div>';
								}
							?>	
						</div>
					</div>

					<footer>
						<div class="footer__container">
							<div class="footer__text container">
								<p><a href="deliverypay.php">Доставка и оплата</a></p>
								<p><a href= "documents.php">Документы</a></p>
								<p><a href="about.php">О нас</a></p>
							</div>
							<div class="footer__doc container">
								<p><a href="documents.php#terms_of_use">Пользовательское соглашение</a></p>
								<p><a href="documents.php#privacy_policy">Политика конфиденциальности</a></p>
								<p><a href="documents.php#public_offer">Публичная оферта</a></p>
							</div>
						</div>
					</footer>
				
				</div>
			</div>
			
			<script src="js/swiper-bundle.min.js"></script>
			<script src="../js/productswiper.js"></script>
			<script type="text/javascript" src="js/cartpage.js"></script>
			<script type="text/javascript">window.isCartPage = true;</script>
			<script type="text/javascript" src="/js/cart.js"></script>
		</body>
	</html>
