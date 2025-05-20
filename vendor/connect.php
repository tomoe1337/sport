<?php

	$connect = mysqli_connect(hostname: "localhost", username: "root",password:'', database:'sports');

	if (!$connect){
		die("Error connect to database");
	}