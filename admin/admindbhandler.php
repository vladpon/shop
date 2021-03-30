<?php

session_start();
require '../include/db.php'; 


$pass = password_hash('admin', PASSWORD_DEFAULT);


////AUTHENTIFICATION
if(isset($_SESSION['user'])){
	if($_SESSION['user'] == 'admin'){
		if(password_verify($_SESSION['password'], $pass)){
			///ADMIN AUTHENTIFICATION SUCCESS

			if(isset($_POST['action'])){

				
				if($_POST['action'] == 'addHit'){
					///ADD NEW ENTRY TO HITS TABLE

					$sqlString = 'INSERT shop.hits(product_id, small_pic, product_name) VALUES(' . $_POST['productId'] . ', "' . $_POST['smallPic'] . '", "' . $_POST['productName'] . '");';

						global $pdo;
						try{	
							$stmt = $pdo->prepare($sqlString);
							$state = $stmt->execute();
							$answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
							echo $answer . "bom bom";
						} catch (Exception $e) {
						    echo $e->getMessage();
						    exit;
						}
				}



				if($_POST['action'] == 'getHits'){
					///SEND HITS

					$sqlString = 'SELECT * FROM shop.hits;';

						global $pdo;
						try{	
							$stmt = $pdo->prepare($sqlString);
							$state = $stmt->execute();
							$hitsArr = $stmt->fetchAll(PDO::FETCH_ASSOC);
							echo json_encode($hitsArr);
						} catch (Exception $e) {
						    echo $e->getMessage();
						    exit;
						}
				}

				if($_POST['action'] == 'deleteHit'){
					///SEND HITS
					$product_id = $_POST['product_id'];
					$sqlString = 'DELETE FROM shop.hits WHERE product_id = ' . $product_id . ';';

						global $pdo;
						try{	
							$stmt = $pdo->prepare($sqlString);
							$state = $stmt->execute();
							$hitsArr = $stmt->fetchAll(PDO::FETCH_ASSOC);
							echo json_encode($hitsArr);
						} catch (Exception $e) {
						    echo $e->getMessage();
						    exit;
						}
				}



			}
		} else echo '<h1>Access denied</h1>';
	} else echo "<h1>User is {$_SESSION['user']}</h1>";
} else echo '<h1>no user</h1>';
