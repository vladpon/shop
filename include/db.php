<?php

	$host = '109.226.251.170';
	$user = 'admin';
	$password = 'admin';
	$dbname = 'shop';

	$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


	
