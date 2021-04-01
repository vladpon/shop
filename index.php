<?php
	require_once 'include/session.php';

	


	$cn = 10;
	require "include/db.php";
	global $pdo;

//	$sql = 'SELECT small_pic, price, product_name, product_id FROM shop.products WHERE product_id IN (SELECT product_id FROM shop.hits WHERE TRUE) LIMIT ' . $cn . ';';
	$sql = 'SELECT small_pic, product_name, product_id FROM shop.hits WHERE TRUE LIMIT ' . $cn . ';';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$var = $stmt->fetchAll();

?>


<!DOCTYPE html>
	<html>
		<head>
			<meta name = "viewport" content = "width = device-width, initial-scale = 1">
			<meta charset="utf-8">
			<title>Krasivo Shop &#174</title>

			<link rel="preconnect" href="https://fonts.gstatic.com">
			<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

			<link rel="stylesheet"  href="css/reset.css" >
			<link rel="stylesheet"  href="css/style.css" > 

			<link rel="stylesheet" href="css/swiper-bundle.min.css">
		</head>
		<body>
			<div class="wrapper">
				<header class="header">
					<div class="container">
						<?php include('include/header.php');?> 
					</div>
				</header>
				<div class="content">
					<div class="content__main-image">
					</div>
					<div class="container">

							<!-- ХИТЫ -->

						<div class="content__hits hits">
							<div class="hits__title">Хиты продаж</div>
							<div class="hits__slider swiper-container">
								<div class="swiper-wrapper">										
										
											<?php 
												for ($i=0; $i<($cn/2); $i++){?>

													<div class="swiper-slide">
														<div class= "hits__hit hit" >							
															<a href=<?='"productpage.php?product_id='.$var[$i]['product_id'].'"'?>><img class="hit__image" src=<?php echo '"' . $var[$i]['small_pic'] . '"'?>></a>
															<div class="hit__name"><?php echo $var[$i]['product_name']?></div>
														</div>
													</div>
												<?php }; 
											?>										

								</div>
							</div>
						</div>


							<!-- НОВИНКИ -->

						<div class="content__hits hits">
							<div class="hits__title">Новинки</div>
							<div class="hits__slider swiper-container">
								<div class="swiper-wrapper">										
										
											<?php 
												for ($i=($cn/2); $i<$cn; $i++){?>
													<div class="swiper-slide">
														<div class= "hits__hit hit" >							
															<a href=<?='"productpage.php?product_id='.$var[$i]['product_id'].'"'?>><img class="hit__image" src=<?php echo '"' . $var[$i]['small_pic'] . '"'?>></a>
															<div class="hit__name"><?php echo $var[$i]['product_name']?></div>
														</div>
													</div>
												<?php }; 
											?>										

								</div>
							</div>
						</div>
						<div class="gift-card">
							<div class="gift-card__item"></div>
						</div>

						<div class="insta">
							<div class="insta__item"></div>
						</div>						
					</div>
				</div>

				<?php require('include/footer.php'); ?>
				
			</div>
				<script src="js/swiper-bundle.min.js"></script>
				<script src="js/mainSwiper.js"></script>
				<script type="text/javascript" src="/js/cart.js"></script>
		</body>
	</html>