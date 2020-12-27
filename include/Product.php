<?php

class Product
{
	private int $id;
	private string $title;
	private float $price;
	private int $availableQuantity;

	public function __construct($id, $title, $price, $availableQuantity)
	{
		$this->id = $id;
		$this->title = $title;
		$this->price = $price;
		$this->availableQuantity = $availableQuantity;
	}




	public function getId()
	{
		return $this->id;
	}
	public function setId($id)
	{
		$this->id = $id;
	}
	public function getTitle()
	{
		return $this->title;
	}
	public function setTitle($title)
	{
		$this->title = $title;
	}
	public function getPrice()
	{
		return $price->price;
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