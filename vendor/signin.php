<?php
	session_start();
	require_once("connect.php");

	$login = $_POST["login"];
	$password = md5($_POST['password']);

	$check_user = mysqli_query($connect,"SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");

	if (mysqli_num_rows($check_user) > 0){
		$user  = mysqli_fetch_assoc($check_user);
		$_SESSION['user'] = [
			"id" => $user["id"],
			"full_name" => htmlspecialchars($user['full_name']),
			"avatar" => htmlspecialchars($user["avatar"]),
			"email" => htmlspecialchars($user["email"]),
		];
		header("Location: ../profile.php");
	}else{
		$_SESSION["message"] = "Не верный логин или пароль";
		header("Location: ../login.php");
	}