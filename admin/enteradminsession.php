<?php
session_start();


if(isset($_POST['login'])){
	$_SESSION['user'] = $_POST['login'];
	$_SESSION['password'] = $_POST['password'];
}

var_dump($_SESSION);
var_dump($_POST);

?>


<!DOCTYPE html>
	<html lang="ru">
		<head>
			<meta http-equiv="Content-Type" content="text/html">
			<meta name = 'viewport' content="width=device-width"> -->
			<title>admin sssn log in</title>
		</head>
		<body>
			
			<div class="content">
				<form enctype="multipart/form-data" method="POST">
					<input type="text" name="login">
					<input type="password" name="password">
					<input type="submit" name="submit" value="submit">
				</form>
			</div>
		</body>
	</html>
