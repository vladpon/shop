


<!DOCTYPE html>
	<html lang="ru">
		<head>
			<meta http-equiv="Content-Type" content="text/html">
<!-- 			<meta name = 'viewport' content="width=device-width"> -->
			<title>admin</title>
		</head>
		<body>
			<div>
					<h1>Admin page</h1>
			</div>
			<div class="content">
				<form enctype="multipart/form-data" method="POST" action="handler.php">
					<input type="file" name='userfile'/>
					<input type="submit" name="show" value="Show file"/>
					<input type="submit" name="load" value="Load to SQL"/>
					<input type="submit" name="load2" value="Load big images"/>
					<input type="submit" name="load3" value="Load categories"/>
					<input type="submit" name="stone" value="Stone arr generator"/>
				</form>
			</div>
		</body>
	</html>





<?php 
 phpinfo();
// 	print_r(stream_get_wrappers());
