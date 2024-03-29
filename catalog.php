<?php 
require_once 'include/carthandler.php';
require_once 'include/const.php';
	


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



				<!-- HEADER -->


				<header class="header">
					<div class="container">
						<?php require("include/header.php")?>
					</div>
				</header>


					<div class="content container">

						<div class="breadcrumbs">
							<a href="index.php">Главная / </a>
							<a href="catalog.php">Каталог / </a>
						</div>


						<div class="catalog">
							<?php require('cataloghandler.php'); ?>	
						</div>							
						
							
						<div class="up-btn">Наверх</div>
					</div> 




				<?php require('include/footer.php'); ?>
				
			</div>
		
			<script src="js/swiper-bundle.min.js"></script>
			<script src="js/productSwiper.js"></script>
			<script type="text/javascript" src="js/catalog.js"></script>
			<script type="text/javascript" src="js/cart.js"></script>
		</body>
	</html>
