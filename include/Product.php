<?php

class Product
{
	private int $productId;
	private string $productName;
	private float $price;
	private int $availableQuantity = 5;

	public function __construct($productId, $productName, $price)
	{
		$this->productId = $productId;
		$this->productName = $productName;
		$this->price = $price;
	}




	public function getProductId()
	{
		return $this->productId;
	}
	public function setProductId($productId)
	{
		$this->productId = $productId;
	}
	public function getProductName()
	{
		return $this->productName;
	}
	public function setProductName($productName)
	{
		$this->productName = $productName;
	}
	public function getPrice()
	{
		return $this->price;
	}
	public function setPrice($price)
	{
		$this->price = $price;
	}
	public function getavAilableQuantity()
	{
		return $availableQuantity->availableQuantity;
	}
	public function setavAilableQuantity($availableQuantity)
	{
		$this->availableQuantity = $availableQuantity;
	}




	public function addToCart(Cart $cart, int $quantity){

	}

	public function removeFromCart(Cart $cart){

	}
}