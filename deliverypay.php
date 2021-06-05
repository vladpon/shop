<?php

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
						<h1><b>Доставка и оплата</b></h1>
						<p>1. Доставка по <b>Красноярску</b>- бесплатно (1-2 дня)</p>
							<p>2. Доставка <b>по России</b>:<br>
						Почтой России — 300 рублей (7-10 дней)
					СДЭК — 650 рублей (3-5 дней)</p>
						<p>При заказе <b>от 3000 рублей</b> доставка по России осуществляется
							<b>БЕСПЛАТНО</b>!</p>
						<p>Вы можете оплатить покупку и доставку следующими способами:
							<ul><li>При получении товара курьеру или в пункте выдачи</li>
						<li>Сразу на сайте (банковской картой, электронными деньгами и
						другими способами)</li></ul></p>

						<h1><b>Часто задаваемые вопросы</b></h1>

						<p><b>Может ли получить заказ другой человек?</b></br>
						Да, может, но только если Вы укажете его в качестве получателя заказа.</p>
						<p><b>Могу я отправить подарок другому человеку?</b></br>
						Да, конечно, Вы можете указать любого человека как получателя, и мы
					доставим заказ именно ему. Такие заказы доставляются по 100% предоплате.</p>
						<p><b>Могу ли я заказать несколько изделий и выбрать одно при получении?</b></br>
						К сожалению, возможности частичного выкупа заказа нет. Но если Вы не
						уверены в своем выборе, наши консультанты помогут Вам определиться или
						порекомендуют максимально подходящее украшение. Также есть возможность
					направить Вам «живое» фото изделия.</p>
						<p><b>Могу ли я приобрести у Вас подарочный сертификат?</b></br>
						Да, конечно. Для Вашего удобства у нас разработана система подарочных
					сертификатов</p>
					</div>


				<?php require('include/footer.php'); ?>
				
				</div>
			</div>			
			<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
			<script src="../js/productswiper.js"></script>
			<script type="text/javascript" src="/js/cart.js"></script>
		</body>
	</html>
