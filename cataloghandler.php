<?php

require_once 'include/const.php';
require 'include/db.php';

global $pdo;
global $aAtr;
global $aAtrItems;
global $limit;


// $sqlRequestString = '';
$columnString = 'small_pic, price, product_name, product_id';

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 0;
$isAjaxReq = ($page) ? true : false;


function initParamReq($page = 0, $sortBy = 'product_name') {
	global $columnString;
	global $limit;
	return 'SELECT ' . $columnString . ' FROM shop.products 
		WHERE true ORDER BY ' . $sortBy . ' LIMIT ' . ($page * $limit) . ', ' . $limit . ';';
}

function getParamReq($getArr, $page = 0, $sortBy = 'product_name'){
	global $aAtr;
	global $limit;
	global $columnString;
	$str = 'SELECT ' . $columnString . ' FROM shop.products WHERE ';
	$isSetAnyParam = false;
	foreach ($aAtr as $atr => $atrName) {
		if (isset($getArr[$atr])){
			if($isSetAnyParam) $str .= ' AND ';
				$isSetAnyParam = true;
			if($atr == 'cat_id'){
				$str .= '(';
				foreach($getArr[$atr] as $cat_id){					
					$str .= 'cat_id IN (SELECT cat_id FROM shop.categories WHERE cat_parent = ' . $cat_id . ') OR cat_id = ' . $cat_id . ' OR ';
				}
				$str = substr_replace($str, ') ', -3);
			} elseif (($atr == 'manufacturer') || ($atr == 'cover')) {
				$str .= $atr . ' IN (';
				foreach ($getArr[$atr] as $val) {
					$str .= '"' . urldecode($val) . '", ';
				}
				$str = substr_replace($str, ')', -2);
			} elseif (($atr == 'stone') || ($atr == 'size')){
				$str .= '(';
				foreach ($getArr[$atr] as $val) {
					$str .= $atr . ' LIKE "%' . urldecode($val) . '%" OR ';
				}
				$str = substr_replace($str, ') ', -3);
			} 
		} 
	}

	if (isset($getArr['search'])){
				$iStr = iSearch($getArr['search']);
				$str .= $iStr;
				$isSetAnyParam = true;
	}

	if(!$isSetAnyParam) {
		$str = initParamReq($page);
		return $str;
	}

	$str .= ' LIMIT ' . ($page * $limit) . ', ' . $limit . ';';

	return $str;
}


function iSearch ($searchStr){
	//echo $searchStr;
	return 'manufacturer LIKE "%' . $searchStr . '%" OR
			stone LIKE "%' . $searchStr . '%" OR
			product_name LIKE "%' . $searchStr . '%" OR
			cover LIKE "%' . $searchStr . '%" ';
}

function countReq($sqlString){
	global $columnString;
	$selectStr = 'SELECT ' . $columnString;
	$countStr = 'SELECT COUNT(product_id) ';
	return str_replace($selectStr, $countStr, $sqlString);
}


function getData($sqlString){
	global $pdo;
	try{	
		$stmt = $pdo->prepare($sqlString);
		$state = $stmt->execute();
		$arrData = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $arrData;
	} catch (Exception $e) {
	    echo $e->getMessage();
	    exit;
	}
}



function showFilter() {
	global $aAtr;
	global $aAtrItems;
	echo '
			<div class="filter">
				<form action="catalog.php" method="GET" id="filterForm">
					<div class="filter__btns">						
						<img class="filter__cancel-btn" src="svg/cancel.svg"></img>
						<span>ФИЛЬТРЫ</span>
						<img class="filter__close-btn" src="svg/close.svg"></img>
					</div>
					<div class="filter-wrapper">';					
							foreach ($aAtr as $reqName => $atrName) { ?>
							<div class="filter__block">
								<div class="filter__title">
									<span><?=$atrName?></span>
									<div class="filter__arrow"><span></span></div>
								</div>
								<div class="filter__list">
									<?php
									if($reqName == 'size')
									{ ?>
										<div class="filter__size-ring">
											<?php
												for($reqValue = (float)$aAtrItems['size']['ring'][0];
														 (float)$reqValue <= (float)$aAtrItems['size']['ring'][1]; 
														 (float) $reqValue+=0.5) {
											?>
													<div class="filter__item">
														<input type="checkbox" name=<?=$reqName."[]"?> value=<?=$reqValue?>>
														<span><?=$reqValue?></span>
													</div>
											<?php } ?>
										</div>

										<div class="filter__size-bracelet">
											<?php
												for($reqValue = (float)$aAtrItems['size']['bracelet'][0];
														 (float)$reqValue <= (float)$aAtrItems['size']['bracelet'][1]; 
														 (float) $reqValue+=0.5) {
											?>
													<div class="filter__item">
														<input type="checkbox" name=<?=$reqName."[]"?> value=<?=$reqValue?>>
														<span><?=$reqValue?></span>
													</div>
											<?php } ?>
										</div>

										<div class="filter__size-chain">
											<?php
												for($reqValue = (int)$aAtrItems['size']['chain'][0];
														 (int)$reqValue <= (int)$aAtrItems['size']['chain'][1];
														 (int) $reqValue+=5) {
											?>
													<div class="filter__item">
														<input type="checkbox" name=<?=$reqName."[]"?> value=<?=$reqValue?>>
														<span><?=$reqValue?></span>
													</div>
											<?php } ?>
										</div>

									<?php }

									elseif($reqName == 'cat_id'){
										foreach ($aAtrItems[$reqName] as $itemName => $reqValue) { 
											switch ($reqValue) {
												case 127:?>
													<div class="filter__item">
														<input type="checkbox" id="ringCB" name=<?=$reqName."[]"?> value=<?=$reqValue?>>
														<span><?=$itemName?></span>
													</div> <?php
													break;
												case 264:?>
													<div class="filter__item">
														<input type="checkbox" id="braceletCB" name=<?=$reqName."[]"?> value=<?=$reqValue?>>
														<span><?=$itemName?></span>
													</div> <?php
													break;
												case 140:?>
													<div class="filter__item">
														<input type="checkbox" id="chainCB" name=<?=$reqName."[]"?> value=<?=$reqValue?>>
														<span><?=$itemName?></span>
													</div> <?php
													break;	
												default:?>											
													<div class="filter__item">
														<input type="checkbox" name=<?=$reqName."[]"?> value=<?=$reqValue?>>
														<span><?=$itemName?></span>
													</div>													
										<?php }
										}
									}

									else foreach ($aAtrItems[$reqName] as $itemName => $reqValue) { ?>
									<div class="filter__item">
										<input type="checkbox" name=<?=$reqName."[]"?> value=<?=$reqValue?>>
										<span><?=$itemName?></span>
									</div>	
									<?php } ?>														
								</div>
							</div>
							<?php } ?>													
					</div>
					<input type="submit" class=" big-button" value="Применить">
				</form>
			</div>
<?php
}



function showProducts($data){
	foreach($data as $value){ ?>
			<div class="catalog__item product-card">
				<a href=<?='"productpage.php?product_id=' . $value['product_id'] . '"'?>><img class="product-card__image" src=<?='"'.$value['small_pic'].'"'?>></a>
				<div class="product-card__price"><a href=<?='"productpage.php?product_id=' . $value['product_id'] . '"'?>><?=myPrice($value['price'])?></a></div>
				<div class="product-card__name"><?=$value['product_name']?></div>
			</div>	
		<?php }
}

function showCatalogHeader ($amount){
		echo "	<div class='catalog__title'>
				<span>Все украшения</span>
				<span>${amount}</span>
			</div>";
		echo '	<div class="catalog__options">
					<!-- <span>По популярности</span> -->
					<span id="filter-btn">Фильтры</span>
				</div>';
}


if (empty($_GET)){	
	$sqlRequestString = initParamReq();
	$amount = getData(countReq($sqlRequestString))[0];
	showCatalogHeader(current($amount));
	showFilter();
	echo '<div class = "catalog__content">';
} elseif($isAjaxReq){
	$sqlRequestString = getParamReq($_GET, $page);
} else {	
	$sqlRequestString = getParamReq($_GET, $page);
	//echo $sqlRequestString . PHP_EOL;
	$amount = getData(countReq($sqlRequestString))[0];
	showCatalogHeader(current($amount));
	showFilter();
	echo '<div class = "catalog__content">';
	if (!current($amount)) {
		echo '<div class = "catalog__null"><i>Ничего не найдено...</i></div>';
		return;
	}
}

	// echo $sqlRequestString;

	showProducts(getData($sqlRequestString));

