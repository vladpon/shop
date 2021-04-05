<?php

require_once 'include/session.php';
require_once 'include/const.php';


if (isset($_GET['product_id'])){
	$product_id = $_GET['product_id'];
	try{
		$k=2;
		require 'include/db.php';
		global $pdo;
		$sql = "SELECT * FROM shop.products WHERE product_id = :product_id;";
		$stmt = $pdo->prepare($sql);
		$state = $stmt->execute(['product_id'=> $product_id]);
		$var = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	    echo $e->getMessage();
	    exit;
	}
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
						<?php require("include/header.php")?>

					</div>
				</header>
				<div class="content container">
					<div class="breadcrumbs">
						<a href="index.php">Главная / </a>
						<a href="catalog.php">Каталог / </a>

						<?php 
							$catName;
							try{
								require_once 'include/db.php';
								global $pdo;
								$sql = "SELECT cat_name FROM shop.categories WHERE cat_id = :cat_id;";
								$stmt = $pdo->prepare($sql);
								$state = $stmt->execute(['cat_id'=> $var[0]['cat_id']]);
								$catName = $stmt->fetchAll(PDO::FETCH_ASSOC);
							} catch (Exception $e) {
							    echo $e->getMessage();
							    exit;
							}
						?>

						<a href="catalog.php?cat_id%5B%5D=<?=$var[0]['cat_id']?>"><?=$catName[0]['cat_name']?></a>
					</div>


					<div class="product">
						<div class="product__image-slider swiper-container">
							<div class="swiper-wrapper">
								<?php $pics = explode(';', $var[0]['big_pic']);	
									foreach ($pics as $pic) { ?>
										<div class="swiper-slide">
											<img class="product__image" src=<?php echo $pic ?>>							
										</div>
									<?php } ?>
							</div>
							<div class="swiper-pagination"></div>
							
						</div>
						<div class="product-card__text">
							<div class="product__name"><?php echo $var[0]['product_name']; ?></div>
							<div class="product__price"><?php echo number_format(round($var[0]['price']*$k, -1), 0, '.', ' ');?></div>
							<div class="product__other other">
								<div class="other__item">
									<span>Артикул</span>
									<span><?php echo $var[0]['vendor_code']; ?></span>
								</div>
								<div class="other__item">
									<span>Бренд</span>
									<span><?php echo $var[0]['manufacturer']; ?></span>
								</div>
								<div class="other__item">
									<span>Проба</span>
									<span><?php echo $var[0]['fineness']; ?></span>
								</div>
								<div class="other__item">
									<span>Вставка</span>
									<span><?php echo $var[0]['stone']; ?></span>
								</div>
								<div class="other__item">
									<span>Покрытие</span>
									<span></span>
								</div>
								<form class="other__item">
									<span>Размер</span>
									<select>
										<option>Выбрать размер</option>
										<option>16</option>
										<option>16,5</option>
										<option>17</option>
									</select>
								</form>
							</div>
						</div>
					</div>
					<form id="add-to-cart-form" onsubmit = 'return false;'>
						<input type="hidden" name="product_id" id="product_id" value=<?='"' . $var[0]['product_id'] . '"';?>>
						<input type="submit" class="big-button add-to-cart" data-product-id=<?='"' . $var[0]['product_id'] . '"';?> value="В КОРЗИНУ" >
					</form>
					

				<?php require('include/footer.php'); ?>
				
				</div>
			</div>			
			<script src="/js/swiper-bundle.min.js"></script>
			<script src="/js/productSwiper.js"></script>
			<script type="text/javascript" src="/js/cart.js"></script>
		</body>
	</html>
