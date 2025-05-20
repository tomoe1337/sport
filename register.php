<?php
	session_start();
if (isset($_SESSION['user'])){
	header("Location: profile.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Регистрация</title>
	<link rel = "stylesheet" href = "static/css/main.css">
</head>
<body>

	<form action="vendor/signup.php" method="post" enctype="multipart/form-data">
		<label>ФИО</label>
		<input type="text" name="full_name" placeholder="Введите свое полное имя">
		<label>Логин</label>
		<input type="text" name="login" placeholder="Введите свой логин">
		<label>Почта</label>
		<input type="email" name="email" placeholder="Введите свою почту">

		<label>Изображение профиля</label>
		<input type="file" name="avatar">

		<label>Пароль</label>
		<input type="password" name="password" placeholder="Введите пароль">
		<label>Подтверждение пароля</label>
		<input type="password" name="password_confirm" placeholder="Подтвердите пароль">

		<button>Зарегестрироваться</button>
		<p>
			У вас уже есть аккаунт? - <a href="/login.php">авторизируйтесь</a>
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