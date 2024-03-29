<?php
session_start();
require '../include/db.php'; 

$createProductsString = 'CREATE TABLE products (
						    product_id INT PRIMARY KEY,
						    product_name VARCHAR(255),
						    manufacturer VARCHAR(64),
						    cat_id INT,
						    price DECIMAL (7, 2),
						    vendor_code VARCHAR (32),
						    fineness VARCHAR (16),
						    stone VARCHAR (256),
						    weight DECIMAL (5,2),
						    size VARCHAR (256),
						    cover VARCHAR (32),
						    big_pic VARCHAR(512),
						    small_pic VARCHAR(255),
						    link_products VARCHAR (256),
						    FOREIGN KEY (cat_id) REFERENCES categories(cat_id) ON DELETE SET NULL
						);';

$createCategoriesString = 'CREATE TABLE categories(
							cat_id INT PRIMARY KEY,
							cat_name VARCHAR(32),
							cat_parent INT,
							FOREIGN KEY (cat_parent) REFERENCES categories(cat_id) ON DELETE SET NULL
						);';

$createOrdersString = 'CREATE TABLE orders(
							order_id INT PRIMARY KEY,
							customer_name VARCHAR(16),
							customer_tel VARCHAR(16),
							customer_email VARCHAR(32),
							customer_address VARCHAR(512),							
							order_price DECIMAL(8,2),							
							order_status INT DEFAULT 0,
							delivery_method ENUM("courier") DEFAULT "courier",
							payment_method ENUM("card", "cash")
							order_time DATETIME DEFAULT CURRENT_TIMESTAMP,
							);';

$createOrdersItemsString = 'CREATE TABLE orders_items(
								order_id INT,
								product_id INT,
								amount INT,
								price DECIMAL(7,2),
								FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
							);';

$createUsersString = 'CREATE TABLE users(
							user_id INT PRIMARY KEY,
							user_name VARCHAR(8),
							user_password VARCHAR(255),
							rights INT
						);';

$createHitsString = 'CREATE TABLE hits(
							product_id INT,
							small_pic VARCHAR(255),
							product_name VARCHAR(256)
						);';



$pass = password_hash('admin', PASSWORD_DEFAULT);





if(mail('cppcoder@mail.ru' , 'subj', 'message')){
	echo 'TRUE';
} else echo 'FALSE';




if(isset($_SESSION['user'])){
	if($_SESSION['user'] == 'admin'){
		if(password_verify($_SESSION['password'], $pass)){
			//ADMIN PAGE
			?>
			 <!DOCTYPE html>
				<html lang="ru">
					<head>
						<meta http-equiv="Content-Type" content="text/html">
						<meta name = 'viewport' content="width=device-width">
						<title>admin</title>
					</head>
					<body>

						<div>
								<h1>Admin page</h1>
						</div>
						<div class="create-table-block">
							<div class="create-table-block__btns">
								<input type="button" class="create-table-block__btn" name="createProducts" value="Create products table">
								<input type="button" class="create-table-block__btn" name="createCategories" value="Create categoies table">
								<input type="button" class="create-table-block__btn" name="createOrders" value="Create orders table">
								<input type="button" class="create-table-block__btn" name="createOrdersItems" value="Create orders_items table">
								<input type="button" class="create-table-block__btn" name="createUsers" value="Create Users table">
							</div>
							<div class="create-table-block__strings">
								<div class="create-table-block__string createProducts"><?=$createProductsString?></div>
								<div class="create-table-block__string createCategories"><?=$createCategoriesString?></div>
								<div class="create-table-block__string createOrders"><?=$createOrdersString?></div>
								<div class="create-table-block__string createOrdersItems"><?=$createOrdersItemsString?></div>
								<div class="create-table-block__string createUsers"><?=$createUsersString?></div>
							</div>
						</div>
						<div class="content">
							<form enctype="multipart/form-data" method="POST" action="handler.php">
								<input type="file" name='userfile'>
								<input type="submit" name="show" value="Show file"/>
								<input type="submit" name="load" value="Load to SQL"/>
								<input type="submit" name="load2" value="Load big images"/>
								<input type="submit" name="load3" value="Load categories"/>
								<input type="submit" name="stone" value="Stone arr generator"/>
							</form>
						</div>

						<h2>Availability block</h2>

						<div class="avail-form-block">
							<form name="availability" class="avail-form">
								<input type="file" name="availfile">
								<br>
								<input type="button" name="submitAvail" value="submit">
							</form>
						</div>


						<div class="wrapper">
							<div class="new-hit-block">
								<h2>Hits</h2>
								<form class="new-hit-block__form" name="newHitForm">
									<input type="text" name="productId" id="productId-field" value="product id"><br/>
									<input type="text" name="smallPic" id="smallPic-field" value="small pic path"><br/>
									<input type="text" name="productName" id="productName-field" value="product name"><br/>
									<input type="button" name="submit" value="add" id="add-hit-btn">
								</form>
								<div class="hits-block">
								</div>
							</div>
							<div class="filter-block">
								<h2>Filter count</h2>
								<form class="filter-block__form" name="add-product">
									<input type="text" name="product_id">
									<br>
									<input type="button" id="add-product__btn" value="add">
								</form>
								<form class="filter-block__form" name="remove-product">
									<input type="text" name="product_id">
									<br>
									<input type="button" id="remove-product__btn" value="remove">
								</form>
								
								<div class="filter-block__count">
									<h2>Filter Items</h2>
								</div>
							</div>
							<div class="filter-block__items">
								</div>
						</div>

						



						<style type="text/css">

							* {
								box-sizing: border-box;								
							}

							body, html {
								font-family: 'Arial';
							}

							h2 {
								text-align: center;
								color: #636;
							}

							.wrapper {
								display: flex;
								flex-direction: row;
							}

							.create-table-block {
								display: flex;
								width: 100%;
								min-height: 300px;
								background-color: #bbb;
							}

							.create-table-block__btns {
								width: 30%;
								background-color: #999;
							}

							.create-table-block__btn{
								width: 100%;
								height: 30px;
							}

							.create-table-block__strings{
								max-width: 70%;
							}


							.create-table-block__string{
								color: #494;
								font-size: 18px;
								padding: 15px;
								display: none;
							}

							.create-table-block__string.active{
								display: block;
							}

							.avail-form-block {
								background-color: #aaa;
								display: flex;
								padding: 10px;
								margin-top: 10px;
								border: 1px solid #492;
							}

							.avail-form {
								/*margin-top: 25px;*/
								/*margin-bottom: 25px;*/
								background-color: #bbb;
								border: 1px solid #888;
							}

							.avail-form input {
								margin: 10px;
								width: 300px;
							}



							.new-hit-block {
								display: flex;
								flex-direction: column;								
								/*margin: 0 auto;*/
								margin: 10px;
								width: 450px;
								background-color: #eee;
								border: 1px solid #ccc;
								border-radius: 5px;
								padding: 5px;
							}

							.new-hit-block__form{
								width: 100%;
							}

							.new-hit-block__form input {
								margin-bottom: 8px;
								width: 100%;
								padding: 5px;

							}

							.hits-block {
								display: flex;
								flex-direction: row;								
								margin: 0 auto;
								margin-top: 40px;
								width: 100%;
								background-color: #eee;
								border: 1px solid #ccc;
								border-radius: 5px;
								padding: 5px;
								overflow: auto;
							}

							.hit {
								position: relative;
								height: 110px;
								width: 80px;
								min-width: 80px;
								background-color: white;
								margin-right: 5px;
								/*overflow: hidden;*/
								border: 1px solid #aaa;
								border-radius: 5px;
								cursor: pointer;
							}

							.hit__close {
								position: absolute;
								right: -5px;
								top: -5px;
								height: 20px;
								width: 20px;
								background-color: #cba;
								border-radius: 50%;
							}

							.hit__close:hover{
								border: 1px solid #a77;
							}

							.hit__close:hover.hit__close:before,
							.hit__close:hover.hit__close:after {
								background-color: #966;
							}

							.hit__close:before,
							.hit__close:after {
								position: absolute;
								content: "";
								width: 14px;
								height: 2px;
								background-color: #a99;
								top: 9px;
								left: 3px;								
							}

							.hit__close:before {
								transform: rotate(45deg);
							}

							.hit__close:after {
								transform: rotate(-45deg);
							}

							.hit:hover{
								box-shadow: 5px 5px 5px rgba(120, 120, 120, 0.5);
								border: 1px solid rgba(200, 120, 120, 0.5);
							}

							.hit img{
								width: 100%;								
								object-fit: cover;
							}

							.hit span {
								width: 100%;
								height: 20px;
								font-size: 12px;
								overflow: hidden;
							}


							.filter-block {
								margin: 10px;
								width: 350px;
								/*min-height: 350px;*/
								border: 1px solid #522;
								border-radius: 5px;
								background-color: #c9c9c9;
								display: flex;
								flex-direction: column;
								justify-content:  space-between;
								padding: 15px;
							}


							.filter-block__form {
								width: 100%;
							}	

							.filter-block__form input {
								margin-top: 5px;
								width: 100%;
							}

							.filter-block__items {
								margin: 10px;
								width: 100%;
								background-color: #ccc;
								border: 1px solid #c45;
								border-radius: 5px;
								display: flex;
								flex-wrap: wrap;
								align-content: start;
							}

							.filter-block__item {
								min-width: 30px;
								height: 15px;
								font-size: 11px;
								border: 1px solid #555;
								border-radius: 2px;
								margin: 1px;
								padding: 1px;
								text-align: center;
							}

							.filter-block__count {
								margin-top: 10px;
								width: 100%;
								/*min-height: 100px;*/
								padding: 15px;
								border: 1px solid #396;
								background-color: #ddd;
								font-size: 45px;
								font-family: "Arial";
								font-weight: 700;
								text-align: center;
								vertical-align: baseline;
							}



						</style>

						<script type="text/javascript">
							let ctBtns = document.querySelectorAll('.create-table-block__btn');
							let ctStrings = document.querySelectorAll('.create-table-block__string');
							let addHitBtn = document.querySelector('#add-hit-btn');
							let hitsBlock = document.querySelector('.hits-block');
							let addToFilterBtn = document.querySelector('#add-product__btn');
							let removeFromFilterBtn = document.querySelector('#remove-product__btn');
							let filterBlockCount = document.querySelector('.filter-block__count');
							let filterBlockItems = document.querySelector('.filter-block__items');
							// let productIdField = document.querySelector('#productId-field'); 
							let hitsArr;
							



							redrawHitsBlock();
							redrawFilterCount();

							addHitBtn.addEventListener('click', newHitFormSubmit);
							addToFilterBtn.addEventListener('click', addToFilter);
							removeFromFilterBtn.addEventListener('click', removeFromFilter);

							function newHitFormSubmit (){								
								// console.log(productIdField.value);
								let newHitFormData = new FormData(document.forms.newHitForm);
								let xhr = new XMLHttpRequest();
								xhr.open('POST', 'admindbhandler.php');
								newHitFormData.append('action', 'addHit');
								xhr.send(newHitFormData);
								xhr.onload = () => {
									redrawHitsBlock();
									console.log(newHitFormData);
									// console.log(xhr.response);
								}
							}	

							function redrawHitsBlock () {
								hitsBlock.innerHTML = "";
								let getHitsReqFormData = new FormData();
								let xhr = new XMLHttpRequest();
								xhr.open('POST', 'admindbhandler.php');
								getHitsReqFormData.append('action', 'getHits');
								xhr.send(getHitsReqFormData);
								xhr.responseType = 'json';								
								xhr.onload = () => {
									let hitsData=xhr.response;
									console.log(hitsData);
									for (let i = 0; i < hitsData.length; i++ ){
										let htmlString = '<div class="hit" id = "' + hitsData[i]['product_id'] + '"><img src="' + hitsData[i]['small_pic'] + '"><span>' + hitsData[i]['product_name'] + '</span><div class = "hit__close"><span></span><span></span></div>';
										hitsBlock.insertAdjacentHTML('beforeEnd', htmlString);										
									}
									closeBtnInit();
								}
							}

							function closeBtnInit () {
								hitsArr = document.querySelectorAll('.hit');
								hitsArr.forEach(function(item, i, arr){
									let productId = item.id;
									item.querySelector('.hit__close').addEventListener('click', () => deleteHitItem(productId));									
								})
							}

							function deleteHitItem (productId){
								console.log('click on close button id =' + productId);
								let xhr = new XMLHttpRequest();
								xhr.open('POST', 'admindbhandler.php');
								let newHitFormData = new FormData();
								newHitFormData.append('action', 'deleteHit');
								newHitFormData.append('product_id', productId);
								xhr.send(newHitFormData);
								xhr.onload = () => {
									redrawHitsBlock();
									console.log(newHitFormData);
									// console.log(xhr.response);
								}
							}


							function addToFilter () {
								// console.log('addToFilter function');
								let xhr = new XMLHttpRequest();
								xhr.open('POST', 'admindbhandler.php');
								let filterFormData = new FormData();
								filterFormData.append('action', 'addFilterItem');
								let productId = addToFilterBtn.parentElement.product_id.value;
								filterFormData.append('product_id', productId);
								xhr.send(filterFormData);
								xhr.onload = () => {
									redrawFilterCount();

								}
							}

							function removeFromFilter () {

								let xhr = new XMLHttpRequest();
								xhr.open('POST', 'admindbhandler.php');
								let filterFormData = new FormData();
								filterFormData.append('action', 'removeFilterItem');
								let productId = removeFromFilterBtn.parentElement.product_id.value;
								// console.log('removeFromFilter function ' + productId);
								filterFormData.append('product_id', productId);
								xhr.send(filterFormData);
								xhr.onload = () => {
									redrawFilterCount();
								}
							}

							
							function redrawFilterCount () {
								getFilterItems();

								filterBlockCount.innerHTML = '';
								let xhr = new XMLHttpRequest();
								xhr.open('POST', 'admindbhandler.php');
								let filterFormData = new FormData();
								filterFormData.append('action', 'getFilterCount');
								xhr.send(filterFormData);
								xhr.responseType = 'json';	
								xhr.onload = () => {
									let filterCount = xhr.response;
									filterBlockCount.innerHTML = filterCount[0]['count'];
								}
							}

							function getFilterItems () {
								filterBlockItems.innerHTML = '';
								let xhr = new XMLHttpRequest();
								xhr.open('POST', 'admindbhandler.php');
								let filterFormData = new FormData();
								filterFormData.append('action', 'getFilterItems');
								xhr.send(filterFormData);
								xhr.responseType = 'json';
								xhr.onload = () => {
									let filterItems = xhr.response;
									filterItems.forEach((currentValue) => {
										let str = '<div class = "filter-block__item">' + currentValue['product_id'] + '</div>';
										filterBlockItems.insertAdjacentHTML('beforeend', str);
									});
									// console.log(filterItems);
								}
							}

							function getFilterArr () {
								filterBlockItems.innerHTML = '';
								let xhr = new XMLHttpRequest();
								xhr.open('POST', 'admindbhandler.php');
								let filterFormData = new FormData();
								filterFormData.append('action', 'getFilterArr');
								xhr.send(filterFormData);
								// xhr.responseType = 'json';
								xhr.onload = () => {
									let filterArr = xhr.response;									
									console.log(filterArr);
								}
							}



							document.availability.submitAvail.addEventListener('click', loadAvailFile);

							function loadAvailFile () {
								let xhr = new XMLHttpRequest();
								xhr.open('POST', 'admindbhandler.php');
								let filterFormData = new FormData(document.availability);
								filterFormData.append('action', 'loadAvailFile');
								// filterFormData.append('file', document.)
								xhr.send(filterFormData);
								// xhr.responseType = 'json';
								xhr.onload = () => {
									let answer = xhr.response;									
									console.log(answer);
								}
							}


							<?php for ($i = 4; $i >= 0; $i--) {?>
								ctBtns[<?=$i?>].addEventListener('mouseover', () => {
									ctStrings[<?=$i?>].classList.add('active');
								});
								ctBtns[<?=$i?>].addEventListener('mouseout', () => {
									ctStrings[<?=$i?>].classList.remove('active');
								});
							<?php ;};?>
						</script>

					</body>
				</html>

			<?php
			//END OF ADMIN PAGE
		} else echo '<h1>Access denied</h1>';
	} else echo "<h1>User is {$_SESSION['user']}</h1>";
} else echo '<h1>no user</h1>';

phpinfo();

?>





