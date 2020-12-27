<?php

class Cart
{
	private array $items = [];
	private int $amount;



	public function __construct()
	{
		$this->amount = 0;
	}

	public function addProduct(int $quantity = 1)
	{
			// $cartItem = new CartItem($product, $quantity);
			// foreach ($this->$items as $item) {
			// 	if($item->getProduct()->getId() === $product->getId()){
			// 		if($item->getTotalQuantity() + $quantity > $product->getProduct()->getAvailableQuantity()){
			// 			throw new Exception('Product quantity can not be more than ' . $product->getAvailableQuantity());
			// 		}
			// 		$item->setQuantity($item->getQuantity() + $quantity);
			// 	}
			// }
		$this->amount +=1;
	}

	public function removeProduct(Product $product)
	{

	}

	public function getTotalQuantity()
	{
		return $this->amount;
	}

	public function getTotalSum()
	{

	}
}