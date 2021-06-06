<?php

class CartItem
{
	private Product $product;
	private int $quantity;
	private $size;


	public function __construct(\Product $product, $quantity, $size)
	{
		$this->product = $product;
		$this->quantity = $quantity;
		$this->setSize($size);
	}


	public function getSize()
	{
		return $this->size;
	}
	public function setSize($size)
	{

		$pattern = array('/,/', '/ \D+/');
		$replace = array('.', '');
		if($size)
			$this->size = preg_replace($pattern, $replace, $size);
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
		$this->quantity++;
	}

	public function decreaseQuantity()
	{
		if($this->quantity > 1)
			$this->quantity--;
	}
}