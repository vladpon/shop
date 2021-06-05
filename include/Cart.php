<?php
require_once 'Product.php';
require_once 'CartItem.php';


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

	public function getTotalQuantity()
	{

	}

	public function getTotalSum()
	{

	}

	public function getItems()
	{
		return $this->items;
	}


}