<?php
	
	require('../include/db.php');

	echo '<style>
			body {
				background-color: black;
				color: #0f0;
				font-size: 8px;
				display: flex;
				flex-direction: column;
				flex-wrap: wrap;
				height: 100%;
			}
			body span {
			}
			</style>';

	if (isset($_POST['show'])) {
		showCSV($_FILES['userfile']['tmp_name']);
	} elseif (isset($_POST['load'])) {
		importCSV($_FILES['userfile']['tmp_name']);
	} elseif (isset($_POST['load2'])) {
		importSecondCSV($_FILES['userfile']['tmp_name']);
	} elseif (isset($_POST['load3'])) {
		importCat($_FILES['userfile']['tmp_name']);
	} elseif (isset($_POST['stone'])) {
		countStones();
	}
 

	function showCSV($file) {

		$handle = fopen('php://memory', 'w+');
		fwrite($handle, iconv('CP1251', 'UTF-8', file_get_contents($file)));
		rewind($handle);
		while (($row = fgetcsv($handle, 1000, ';')) !== false){
			print "<pre>";
			print_r($row);
			print "</pre>";
		}
		fclose($handle);
	}


	function importCSV($file) {
		try{
			global $pdo;

			$handle = fopen('php://memory', 'w+');
			fwrite($handle, iconv('CP1251', 'UTF-8', file_get_contents($file)));
			rewind($handle);
			$row = fgetcsv($handle, 2048, ';');
			while (($row = fgetcsv($handle, 2048, ';')) !== false){
				$productId = (int) $row[0];
				$category = (int) $row[1];
				$productName = $row[2];
				$price = (float) $row[3];
				$vendorCode = $row[5];				
				$linkProducts = (strlen($row[6])<64) ? $row[6] : (mb_substr($row[6], 0, 60, 'UTF-8'));
				$other = $row[7];
		//		$bigPic = $row[8];
				$smallPic = $row[9];

				$spec = [
					'manufacturer' => '',
					'fineness' => '',
					'stone' => '',
					'size' => '',
					'cover' => ''
				];

				$arr = explode('#',$other);
				foreach($arr as $var){
					$value = explode('/', $var);
					switch($value[0]){
						case 'Производитель':
							$spec['manufacturer'] = (strlen($value[1])<32) ? ($value[1]) : (mb_substr($value[1], 0, 30, 'UTF-8'));
							break;
						case 'Проба':
							$spec['fineness'] = $value[1];
							break;
						case 'Вставка':
							$spec['stone'] .= $value[1]. '; ';
							break;
						case 'Размер':
							$spec['size'] .= $value[1] . '; ';
							break;
						case 'Покрытие':
							$spec['cover'] = $value[1];
					}
				}

				
				$sql = "INSERT INTO products (product_id, product_name, manufacturer, cat_id,  price, vendor_code, fineness, stone, size, cover, small_pic, link_products)
									VALUES(:productId, :productName, :manufacturer, :category, :price, :vendorCode, :fineness, :stone, :size, :cover, :smallPic, :linkProducts);";
				$stmt = $pdo->prepare($sql);
				$state = $stmt->execute([
										'productId'=> $productId,									
										'productName' => $productName, 
										'manufacturer' => $spec['manufacturer'], 
										'category' => $category, 
										'price'=> $price, 
										'vendorCode' => $vendorCode, 
										'fineness' => $spec['fineness'], 
										'stone' => $spec['stone'], 
										'size' => $spec['size'],
										'cover' => $spec['cover'],
		//								'bigPic' => $bigPic, 
										'smallPic' => $smallPic, 
										'linkProducts' => $linkProducts
									]);
				if(!$state) {
					echo "FAILED to add product id$productId</br>";
				}	else echo '<span style="font-size: 10px">' . $productId . ' </span>';

				
			}
		
			fclose($handle);

		}
		catch (Exception $e) {
	    echo $e->getMessage();
	    echo '<br>' . $product_id;
	    exit;
		}
}



function importSecondCSV($file) {
		try{
			global $pdo;

			$handle = fopen('php://memory', 'w+');
			fwrite($handle, iconv('CP1251', 'UTF-8', file_get_contents($file)));
			rewind($handle);
			$row = fgetcsv($handle, 2048, ';');
			while (($row = fgetcsv($handle, 2048, ';')) !== false){
				$productId = (int) $row[2];
				$other = $row[3];
				$bigPic = $row[9];

				$str = 'Средний вес';
				$tmpStr = substr($other, (stripos($other, $str) + strlen($str)), 15);				
				$str =  preg_replace('/[^0-9^.]/', '', $tmpStr) . '<br>';
				$weight = round((float) $str, 2);
				
	 			$sql = "UPDATE products SET weight = :weight, big_pic = :bigPic WHERE product_id = :productId;";
		 		$stmt = $pdo->prepare($sql);
		 		$state = $stmt->execute(['productId'=> $productId, 'weight' => $weight, 'bigPic' => $bigPic]);
		 		if(!$state) {
		 			echo "FAILED to add product id$productId</br>";
		 		}	else echo '<span>' . $productId . ' </span>';
		 		}
		
			fclose($handle);

		}
		catch (Exception $e) {
	    echo $e->getMessage();
	    echo '<br>' . $product_id;
	    exit;
		}
}


function importCat($file) {
		try{
			global $pdo;

			$handle = fopen('php://memory', 'w+');
			fwrite($handle, iconv('CP1251', 'UTF-8', file_get_contents($file)));
			rewind($handle);
			$row = fgetcsv($handle, 2048, ';');
			while (($row = fgetcsv($handle, 2048, ';')) !== false){
				$catId = (int) $row[0];
				$catName = $row[1];				
				
	 			$sql = "INSERT INTO categories(cat_id, cat_name) VALUES(:catId, :catName);";
		 		$stmt = $pdo->prepare($sql);
		 		$state = $stmt->execute(['catId'=> $catId,
		 								 'catName' => $catName]);
		 		if(!$state) {
		 			echo "FAILED to add cat id$catId</br>";
		 		}	else echo '<span>' . $catId . ' </span>';
			 	
		 	}
		 	rewind($handle);
		 	$row = fgetcsv($handle, 2048, ';');
		 	while (($row = fgetcsv($handle, 2048, ';')) !== false){
		 		$catId = (int) $row[0];
				$catParent = ($row[2] == 0) ? NULL : $row[2];
				
	 			$sql = "UPDATE categories SET cat_parent=:catParent WHERE cat_id = :catId;";
		 		$stmt = $pdo->prepare($sql);
		 		$state = $stmt->execute(['catParent' => $catParent, 'catId' => $catId]);
		 		if(!$state) {
		 			echo "FAILED to add cat id$catId</br>";
		 		}	else echo '<span>' . $catId . ' </span>';
			 	
		 	}

		
			fclose($handle);

		}
		catch (Exception $e) {
	    echo $e->getMessage();
	    echo '<br>' . $catId;
	    exit;
		}
}



function countStones () {
	$itemArr = array();
	try{
			global $pdo;	 			

 			$sql = "SELECT DISTINCT(stone) FROM shop.products WHERE TRUE;";
	 		$stmt = $pdo->prepare($sql);
	 		$state = $stmt->execute();

	 		if(!$state) {
	 			echo "FAILED</br>";
	 		}
	

	}
	catch (Exception $e) {
	    echo $e->getMessage();
	    exit;
	}

	$search = array('синт.', 'культ.', 'иск.', 'имит.', 'и.', 'пресс.', 'розовый', 'Цветной', 'Иск.', 'зеленый', 'Sea blue', 'черный', 'нано', 'Нано', 'Лондон', 'ГТ', 'микс', 'нат. (U)', 'нат. (O)', 'нат. (H)', 'белый', 'голубой', 'красный', 'пурпурный', 'Микс', 'Кристалл Ювелирный', 'коньячный', 'Ювелирная вставка', 'с.');

	$var = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($var as $value){
		foreach ($value as $str) {
			$itemA = explode(';', $str);
			foreach ($itemA as $item) {
				$item = str_replace($search, '', $item);
				$item = trim($item);
				if(stripos($item, 'пл.') !== false || empty($item)){
					break;
				}
				if(array_search($item, $itemArr ,TRUE) === false){
					echo '<p style = "font-size: 20px;">' . $item . "</p>";
					array_push($itemArr, $item);
				}
			}
		}
	}
print_r($itemArr);

}