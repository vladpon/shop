<?php

class CartItem
{
	private Product $product;
	private int $quantity;


	public function __construct(\Product $product, $quantity)
	{
		$this->product = $product;
		$this->quantity = $quantity;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}
	public function getProduct()
	{
		return $this->product;
	}
	public function setProduct($product)
	{
		$this->product = $product;
	}

	public function increaseQuantity($amount =1)
	{
		if($this->getQuantity() + $amount > $this->getProduct()->getAvailableQuantity()){
			throw new Exception('Product quantity can not be more than ' . $this->getProduct()->getAvailableQuantity());
		}
	}

	public function decreaseQuantity()
	{

	}
}