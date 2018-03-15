<?php
	session_start();
	require_once('tpl_php/autoload_light.php');
	if(isset($_POST['authorize']) || isset($_POST['registrate'])) {
		try {
			$user = new User;
			if(isset($_POST['authorize'])) {
				$user->auth(htmlspecialchars(strip_tags($_POST['login'])), htmlspecialchars(strip_tags($_POST['password'])));
			}
			if(isset($_POST['registrate'])) {
				$user->registrate($_POST);
			}
		} catch (Exception $e) {
			echo 'Have an Exception: ',  $e->getMessage(), "\n";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="" method="post">
		<input type="text" name="user_login" placeholder="insert your login"> <br>
		<input type="password" name="user_password" placeholder="insert your password"> <br>
		<input type="submit" name="authorize" value="authorize">
	</form>
	<hr>
	<form action="" method="post">
		<input type="text" name="user_name" placeholder="insert your fullname"> <br>
		<input type="text" name="user_login" placeholder="insert your login"> <br>
		<input type="password" name="user_password" placeholder="insert your password"> <br>
		<input type="submit" name="registrate" value="registrate">
	</form>
</body>
</html>