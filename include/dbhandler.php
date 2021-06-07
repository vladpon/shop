<?php 
require_once 'db.php';
require_once 'const.php';



function getProductData($productId){
	global $pdo; 

	$sqlReqStr = "SELECT product_id, product_name, manufacturer, cat_id, vendor_code, price, fineness, stone, weight, size, cover, big_pic, small_pic, link_products FROM shop.products WHERE product_id = " . $productId . ';';

	try{		
		$stmt = $pdo->prepare($sqlReqStr);
		$state = $stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	    echo 'getProductData() error: '. $e->getMessage();
	    exit;
	}
	return $data;
}

function dbReq($str){
	try{
		global $pdo;
		$stmt = $pdo->prepare($str);
		$state = $stmt->execute();
	} catch (Exception $e) {
	    echo $e->getMessage();
	    exit;
	}

	return $state;
}