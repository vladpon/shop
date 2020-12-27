<?php

class Cart
{
	private array $items = [];

	public function addProduct(Product $product, int $quantity)
	{
			$cartItem = new CartItem($product, $quantity);
			foreach ($this->$items as $item) {
				if($item->getProduct()->getId() === $product->getId()){
					if($item->getTotalQuantity() + $quantity > $product->getProduct()->getAvailableQuantity()){
						throw new Exception('Product quantity can not be more than ' . $product->getAvailableQuantity());
					}
					$item->setQuantity($item->getQuantity() + $quantity);
				}
			}
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
}