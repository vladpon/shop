<?php
require_once 'include/carthandler.php';
require_once 'include/dbhandler.php';

require_once 'include/const.php';
require 'include/db.php';


global $aAtr;
global $aAtrItems;



$cartItems = getCartItems();

function showCartItem($cartItem){
	$productData = getProductData($cartItem->getProduct()->getProductId())[0];
	?>

	
		<div class="cart__product" data-product-id=<?=$productData['product_id']?> data-size=<?=$cartItem->getSize()?>>
			<div class="cart__product-left">
				<img class="cart__product-image" src=<?=$productData['small_pic']?>>
				<div class="cart__count">
					<span>-</span>
					<span><?=$cartItem->getQuantity()?></span>
					<span>+</span>
				</div>
			</div>
			<div class="cart__product-right">
				<div class="cart__product-describe">
					<p><?=$productData['product_name']?></p>
					<p>Артикул: <?=$productData['vendor_code']?></p>
					<p>Проба: <?=$productData['fineness']?></p>
					<p>Покрытие: <?=$productData['cover']?></p>
					<p>Вставка: <?=$productData['stone']?></p>	
					<?php if($cartItem->getSize()) echo '<p>Размер: ' . $cartItem->getSize() . '</p>'; ?>					
				</div>
				<div class="cart__price">							
					<span><?=myPrice($productData['price'])?></span>
					<img class='delete-from-cart' data-product-id=<?=$productData['product_id'];?> src="svg/close.svg">
				</div>
			</div>
			<div class="cart__line"></div>
		</div>
	<?php	
}

function showTotalPrice(){
	echo 	'<div class="cart__total">
				Итого: <span>' . getTotalPrice() . '</span>
			</div>';
	return $totalPrice;

}


function showForm(){
	?>

		<form action="#" method="POST" accept-charset="UTF-8" name="clientData" class="cart__form" onsubmit="return false;">
			<div class="cart__client-data">							
				<input type="text" name="clientName" placeholder="ФИО">
				<input type="e-mail" name="clientEmail" placeholder="e-mail">
				<input type="tel" name="clientTel" placeholder="телефон">
				<input type="text" name="clientAddress" placeholder="адрес">						
				<div class="cart__delivery">
					<div class="cart__delivery-title">Способ доставки:</div>
					<div class="cart__deliveries">
						<p><input type="radio" name="delivery" checked="checked">Курьер (только Красноярск) - бесплатно<p>
<!-- 						<p><input type="radio" name="delivery">СДЭК</p>
						<p><input type="radio" name="delivery">Почта</p> -->
					</div>
				</div>
				<div class="cart__payment">
					<div class="cart__payment-title">Способ оплаты:</div>
					<div class="cart__payments">
						<p><input type="radio" name="payment">При получении<p>
						<!-- <p><input type="radio" name="payment">Оплата онлайн</p> -->
					</div>									
				</div>
				<div class="cart__agreement"><input type="checkbox" name="agreement">Я прочитал и согласен с условиями <a href="documents.php#terms_of_use">пользовательского соглашения</a></div>
			</div>
			<!-- <div class="cart__totality"><span><?=$totalPrice?></span></div> -->
			<input class="big-button" type="submit" name="submit" value="Оформить заказ">
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
			<div class="order-confirm">
					<div class="order-confirm__header">
						<img src="svg/close.svg">
					</div>
					<div class="order-confirm__content">
						<div class="order-confirm__title">Проверьте, пожалуйста, данные заказа:</div>
						<div class="order-confirm__customer"></div>
						<div class="order-confirm__delivery"></div>
						<div class="order-confirm__title">Выбранные товары:</div>
						<div class="order-confirm__items">
							<ol></ol>
						</div>
						<p><div class="order-confirm__total">Итого: </div></p>
						<div class="big-button"></div>
					</div>
			</div>
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
								if($cartItems){
									foreach($cartItems as $cartItem){
										showCartItem($cartItem);
									}
									$totalPrice = showTotalPrice();
									showForm();
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
			<!-- <script src="../js/productswiper.js"></script> -->
			<script type="text/javascript" src="js/cartpage.js"></script>
			<!-- <script type="text/javascript">window.isCartPage = true;</script> -->
			<script type="text/javascript" src="/js/cart.js"></script>
		</body>
	</html>

