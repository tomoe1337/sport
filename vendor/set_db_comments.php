<?php
	require_once "connect.php";
	$s_id = $_GET['s_id'];
	if (isset($_POST['delete-button'])){
		mysqli_query($connect,"DELETE FROM `comments` WHERE `s_id` = $s_id");

	}
	elseif (isset($_POST['new-comment'])) {
		$date =date('Y-m-d H:i:s');
		$comment = $_POST['comment'];
		echo $sql ="INSERT INTO `comments` (`s_id`, `comment`, `date`) VALUES ('$s_id','$comment','$date')";
		mysqli_query($connect,$sql);

	}

header("Location: ../sport.php?s_id={$s_id}");

