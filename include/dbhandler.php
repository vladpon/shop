<?php 
require_once 'db.php';
require_once 'const.php';



function getProductData($productId){
	global $pdo; 

	$sqlReqStr = "SELECT product_name, vendor_code, price FROM shop.products WHERE product_id = " . $productId . ';';

	try{		
		$stmt = $pdo->prepare($sqlReqStr);
		$state = $stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
	    echo $e->getMessage();
	    exit;
	}
	return $data;
}