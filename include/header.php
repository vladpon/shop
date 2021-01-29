<?php
require_once 'session.php';
?>



<div class="header__body">
	<div class="header__burger">
		<span></span>
	</div>
	<a href='index.php' class="header__logo">
		krasivo
	</a>
	<nav class="header__burger-menu">
		<ul class="header__list">
			<li>
				<a href="catalog.php" class="header__link"><b>NEW</b></a>
			</li>
			<li>
				<a href="catalog.php" class="header__link"><b>SALE</b></a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=131" class="header__link">Серьги</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=264" class="header__link">Браслеты, шнуры</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=138" class="header__link">Колье</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=127" class="header__link">Кольца</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=140" class="header__link">Цепи</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=129" class="header__link">Подвески</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=136" class="header__link">Броши</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=126" class="header__link">Аксессуары</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=128" class="header__link">Мужчинам</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=130" class="header__link">Религия</a>
			</li>
			<li>
				<a href="catalog.php?cat_id%5B%5D=134" class="header__link">Часы</a>
			</li>
		</ul>
	</nav>
	<nav class="header__main-menu main-menu">
		<ul class="main-menu__list">
			<li>
				<a href="catalog.php" class="main-menu__link header__link">Каталог</a>
				<ul class="main-sub-menu__list">
					<li>
						<a href="catalog.php?cat_id%5B%5D=131" class="main-sub-menu__link">Серьги</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=264" class="main-sub-menu__link">Браслеты, шнуры</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=138" class="main-sub-menu__link">Колье</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=127" class="main-sub-menu__link">Кольца</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=140" class="main-sub-menu__link">Цепи</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=129" class="main-sub-menu__link">Подвески</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=136" class="main-sub-menu__link">Броши</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=126" class="main-sub-menu__link">Аксессуары</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=128" class="main-sub-menu__link">Мужчинам</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=130" class="main-sub-menu__link">Религия</a>
					</li>
					<li>
						<a href="catalog.php?cat_id%5B%5D=134" class="main-sub-menu__link">Часы</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="" class="main-menu__link header__link">New</a>
			</li>
			<li>
				<a href="" class="main-menu__link header__link">Sale</a>
			</li>
		</ul>
	</nav>
	<div class="header__search">
		<form action="catalog.php" method='GET'>
			<input type="search" name="search" class="search-input">
		</form>
	</div>
	<div class="header__right">
		<div href="catalog.php" class="header__search-btn">
			<img class="image" src="svg/search.svg">
		</div>
		<a href="cartpage.php" class="header__cart-btn">
			<img class="image" src="svg/cart.svg">
			<span><?=getProductsAmount()?></span>
		</a>
	</div>							
	
</div>	



<script src="js/header.js"></script>
