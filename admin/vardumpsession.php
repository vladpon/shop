<?php
require_once "../include/Product.php";
require_once "../include/CartItem.php";
require_once "../include/Cart.php";

session_start();

// var_dump($_SESSION['cart']);

echo '<br>';

$cart = $_SESSION['cart'];
$cartItems = $cart->getItems();


var_dump($cart);