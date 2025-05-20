<?php
	session_start();
	require_once("connect.php");

	$full_name = $_POST["full_name"];
	$login = $_POST["login"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$password_confirm = $_POST["password_confirm"];

	$data_signup = array($full_name,$login,$email,$password,$password_confirm);
	if (in_array('',$data_signup)){
		$_SESSION['message'] = "Заполните все поля";
		header("Location: ../register.php");
		die();
	}


	if (strlen($password) < 6) {
		$_SESSION['message'] = "Слабый пароль";
		header("Location: ../register.php");
		die();
	}



	if ($password === $password_confirm){

		$path = "uploads/" . time() . $_FILES["avatar"]["name"];
		if (!move_uploaded_file($_FILES["avatar"]["tmp_name"], "../" .$path)){
			$_SESSION['message'] = "Ошибка при загрузке изображения";
			header("Location: ../register.php");
			die();
		}

		$password = md5($password);
			$sql = "INSERT INTO `users` (`full_name`, `login`, `email`, `password`, `avatar`) 
			VALUES (?,?,?,?,?)";


			$var = array($full_name,$login,$email,$password,$path);

			$stmt = $connect -> prepare($sql);
			$stmt -> bind_param('sssss',...$var);
			$stmt -> execute();




		$_SESSION['message'] = "Регистрация прошла успешно!";
		header("Location: ../index.php");		


	} else{
		$_SESSION['message'] = "Пароли не совпадают";
		header("Location: ../register.php");
	}
