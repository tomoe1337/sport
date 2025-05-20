<?php
require_once "connect.php";

if (!isset($_GET['s_id'])) {
    header("Location: sport_list.php");
    exit();
}

$s_id = $_GET['s_id'];
$sql = "DELETE FROM sport WHERE s_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $s_id);
$stmt->execute();

header("Location: ../index.php");
exit();
