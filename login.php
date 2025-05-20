<?php
	session_start();
	if (isset($_SESSION['user'])){
	header("Location: /profile.php");
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Авторизация</title>
	<link rel = "stylesheet" href = "static/css/main.css">
</head>
<body>

	<form action="vendor/signin.php" method="post">
		<label>Логин</label>
		<input type="text" name="login" placeholder="Введите свой логин">
		<label>Пароль</label>
		<input type="password" name="password" placeholder="Введите пароль">
		<button>Войти</button>
		<p>
			У вас нет аккаунта? - <a href="register.php">зарегестрируйтесь</a>
		</p>
		<?php

			if (isset($_SESSION['message'])){
				echo '<p class = "msg">' . $_SESSION['message'] . "</p>";
			}
			unset($_SESSION['message']);
		?>		
	</form>


</body>
</html>