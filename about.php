<?php

 // require_once 'include/session.php';
require_once 'include/carthandler.php';


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

			<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
		</head>
		<body>
			<div class="wrapper">
				<header class="header">
					<div class="container">
						<?php require("include/header.php")?>

					</div>
				</header>
				<div class="content container">
					<div class="content__text">
						<h1><b>О нас</b></h1>
						<p>KRASIVO – это мультибрендовый магазин стильных серебряных
						украшений высокого качества!</p>
						<p>
						Мы хотим, чтобы ювелирные изделия радовали наших покупателей как
						можно дольше, поэтому доверяем только ведущим ювелирным
						производителям. Каждое украшение, представленное в нашем каталоге,
						прошло проверку Государственной инспекцией Пробирного надзора РФ,
						имеет пробу, а в случае с отечественными украшениями — и клеймо
						производителя.
					</p>
						<p>
						Доступность в сочетании с современным дизайном — миссия, выполнимая
						для нас: в нашем каталоге представлено более 5000 украшений
					российских и зарубежных брендов по самым приятным ценам.</p>
						<p>
						Сделать покупку на нашем сайте удобно и просто: мы предлагаем доставку
						украшений по всей России, а при заказе от 3000 рублей доставка
						осуществляется за наш счет!
					</p>
					</div>


				<?php require('include/footer.php'); ?>
				
				</div>
			</div>			
			<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
			<script src="../js/productswiper.js"></script>
			<script type="text/javascript" src="/js/cart.js"></script>
		</body>
	</html>
