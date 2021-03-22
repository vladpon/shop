<?php

 require_once 'include/session.php';




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
						1. Доставка по Красноярску - бесплатно (1-2 дня)<br>
						2. Доставка по России:<br>
						Почтой России — 300 рублей (7-10 дней)
						СДЭК — 650 рублей (3-5 дней)
						При заказе от 3000 рублей доставка по России осуществляется
						БЕСПЛАТНО!
						Вы можете оплатить покупку и доставку следующими способами:
						 При получении товара курьеру или в пункте выдачи
						 Сразу на сайте (банковской картой, электронными деньгами и
						другими способами)

						Часто задаваемые вопросы

						Может ли получить заказ другой человек?
						Да, может, но только если Вы укажете его в качестве получателя заказа.
						Могу я отправить подарок другому человеку?
						Да, конечно, Вы можете указать любого человека как получателя, и мы
						доставим заказ именно ему. Такие заказы доставляются по 100% предоплате.
						Могу ли я заказать несколько изделий и выбрать одно при получении?
						К сожалению, возможности частичного выкупа заказа нет. Но если Вы не
						уверены в своем выборе, наши консультанты помогут Вам определиться или
						порекомендуют максимально подходящее украшение. Также есть возможность
						направить Вам «живое» фото изделия.
						Могу ли я приобрести у Вас подарочный сертификат?
						Да, конечно. Для Вашего удобства у нас разработана система подарочных
						сертификатов
					</div>


				<?php require('include/footer.php'); ?>
				
				</div>
			</div>			
			<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
			<script src="../js/productswiper.js"></script>
			<script type="text/javascript" src="/js/cart.js"></script>
		</body>
	</html>
