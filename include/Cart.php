<?php
require_once 'const.php';

class Cart
{
	private array $items = [];

	public function addProduct(Product $product, int $quantity, $size)
	{
			$cartItem = new CartItem($product, $quantity, $size);

			foreach ($this->items as $item) {
				if($item->getProduct()->getProductId() === $product->getproductId()){
					//SAME PRODUCT ALREADY IN THE CART
					if(!$size || ($size == $item->getSize())) {  //if not sizable || same size
						$item->increaseQuantity();
						return;
					}
				}
			}
			array_push($this->items, $cartItem);
	}

	public function removeProduct(Product $product)
	{

	}

	public function removeCartItem($productId, $size = false)
	{
		foreach ($this->items as $item)
		{
			if($item->getProduct()->getProductId() == $productId)
				if(!$size || ($size == $item->getSize()))
				{
					unset($this->items[array_search($item, $this->items)]);
					break;
				}
		}
	}

	public function getTotalQuantity()
	{
		$count = 0;
		foreach ($this->items as $item) $count += $item->getQuantity();
		return $count;

	}

	public function getTotalSum()
	{
		$totalSum = 0;
		foreach ($this->items as $item) 
			$totalSum += ($item->getProduct()->getPrice()) * $item->getQuantity();		

		return $totalSum;
	}

	public function getItems()
	{
		return $this->items;
	}


}