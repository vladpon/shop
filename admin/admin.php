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
						    size VARCHAR (128),
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
							order_price DECIMAL(8,2),
							order_status INT,
							payment_method ENUM("card", "cash")
							);';

$createOrdersItemsString = 'CREATE TABLE orders_irtems(
								order_id INT,
								product_id INT,
								amount INT,
								price DECIMAL(7,2),
								FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE SET NULL
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





$sqlString = 'INSERT shop.hits(product_id, small_pic, product_name) VALUES(' . '4444' . ', "' . '12333' . '", "' . '32111' . '");';

global $pdo;
try{	
	$stmt = $pdo->prepare($sqlString);
	$state = $stmt->execute();
	$answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo $answer . "bom bom";
	return;
} catch (Exception $e) {
    echo $e->getMessage() . 'catch';
    exit;
}





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

						<div class="new-hit-block">
							<form class="new-hit-block__form" name="newHitForm">
								<input type="text" name="productId" id="productId-field" value="product id"><br/>
								<input type="text" name="smallPic" id="smallPic-field" value="small pic path"><br/>
								<input type="text" name="productName" id="productName-field" value="product name"><br/>
								<input type="button" name="submit" value="add" id="add-hit-btn">
							</form>
						</div>

						<div class="hits-block">
							<div class="hit">
								<img src="https://tdserebro.ru/media/cache/thumb_300//product_images/8/8/e/1_88e9b659-e8c8-11e9-80f6-00155d009e0e_e4cf0a8b-e8fd-11e9-80f6-00155d009e0e.jpeg">
								<span>Product Name Name Product</span>
							</div>
							<div class="hit">
								<img src="https://tdserebro.ru/media/cache/thumb_300//product_images/8/8/e/1_88e9b659-e8c8-11e9-80f6-00155d009e0e_e4cf0a8b-e8fd-11e9-80f6-00155d009e0e.jpeg">
							</div>
<!-- 							<div class="hit hit_add-btn">
								<span></span>
								<span></span>
							</div> -->
						</div>



						<style type="text/css">
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

							.new-hit-block {
								display: flex;
								flex-direction: row;								
								margin: 0 auto;
								margin-top: 40px;
								width: 1100px;
								background-color: #eee;
								border: 1px solid #ccc;
								border-radius: 5px;
								padding: 5px;
							}

							.new-hit-block__form{
							}

							.new-hit-block__form input {
								margin-bottom: 8px;
								width: 540px;
								padding: 5px;

							}

							.hits-block {
								display: flex;
								flex-direction: row;								
								margin: 0 auto;
								margin-top: 40px;
								width: 1100px;
								background-color: #eee;
								border: 1px solid #ccc;
								border-radius: 5px;
								padding: 5px;
							}

							.hit {
								height: 110px;
								width: 80px;
								background-color: white;
								margin-right: 5px;
								overflow: hidden;
								border: 1px solid #aaa;
								border-radius: 5px;
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
								font-size: 12px;
							}

/*							.hit:last-child	{
								position: relative;
							}

							.hit:last-child:before {
								content: '';
								position: absolute;
								width: 60px;
								height: 10px;
								background-color: #aaa;
								left: 10px;
								top: 50px;
							}

							.hit:last-child:after {
								content: '';
								position: absolute;
								width: 60px;
								height: 10px;
								background-color: #aaa;
								left: 10px;
								top: 50px;
								transform: rotate(90deg);
							}*/


						</style>

						<script type="text/javascript">
							let ctBtns = document.querySelectorAll('.create-table-block__btn');
							let ctStrings = document.querySelectorAll('.create-table-block__string');
							let addHitBtn = document.querySelector('#add-hit-btn');
							let hitsBlock = document.querySelector('.hits-block');
							// let productIdField = document.querySelector('#productId-field'); 

							addHitBtn.addEventListener('click', newHitFormSubmit);

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
									console.log(xhr.response);
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
									for (let i = 0; i < hitsData.length; i++ ){
										let htmlString = '<div class="hit"><img src="' + hitsData[i]['small_pic'] + '"><span>' + hitsData[i]['product_name'] + "</span></div>";
										hitsBlock.insertAdjacentHTML('beforeEnd', htmlString);
									}
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
			phpinfo();
			//END OF ADMIN PAGE
		} else echo '<h1>Access denied</h1>';
	} else echo "<h1>User is {$_SESSION['user']}</h1>";
} else echo '<h1>no user</h1>';

?>





