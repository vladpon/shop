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

				if($_POST['action'] == 'addFilterItem'){

					$sqlString = 'INSERT shop.filter(product_id) VALUES(' . $_POST['product_id'] . ');';

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

				if($_POST['action'] == 'removeFilterItem'){	

					$sqlString = 'DELETE FROM shop.filter WHERE product_id = ' . $_POST['product_id'] . ';';;

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

				if($_POST['action'] == 'getFilterCount'){	
					$sqlString = 'SELECT COUNT(product_id) AS count FROM shop.filter WHERE TRUE;';

						global $pdo;
						try{	
							$stmt = $pdo->prepare($sqlString);
							$state = $stmt->execute();
							$answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
							echo json_encode($answer);
						} catch (Exception $e) {
						    echo $e->getMessage();
						    exit;
						}
				}

				if($_POST['action'] == 'getFilterItems'){
					$sqlString = 'SELECT product_id FROM shop.filter WHERE TRUE;';
					$jsonFile = fopen('filteritems.json', 'w');					
						global $pdo;
						try{
							$stmt = $pdo->prepare($sqlString);
							$state = $stmt->execute();
							$answer = $stmt->fetchAll(PDO::FETCH_ASSOC);
							echo json_encode($answer);
							fwrite($jsonFile, json_encode($answer));
							fclose($jsonFile);
						} catch (Exception $e) {
						    echo $e->getMessage();
						    exit;
						}
				}

				if($_POST['action'] == 'getFilterArr'){
					$jsonFile = fopen('filteritems.json', 'r');
					$filterItems;
					while (!feof($jsonFile)) {
						$filterItems .= fgets($jsonFile);
					}
					fclose($jsonFile);					
					$filterItemsArr = json_decode($filterItems, true);
					// $filterItemsArr = $filterItems;

					function getItem ($a){
						return $a['product_id'];
					}

					$filterItemsArr = array_map('getItem', $filterItemsArr);
					echo var_dump($filterItemsArr);
				}

				if($_POST['action'] == 'loadAvailFile'){
					var_dump($_FILES);
				}




			}
		} else echo '<h1>Access denied</h1>';
	} else echo "<h1>User is {$_SESSION['user']}</h1>";
} else echo '<h1>no user</h1>';
