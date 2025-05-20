<?php
require_once "connect.php";

if (!isset($_GET['s_id'])) {
    header("Location: sport_list.php");
    exit();
}

$s_id = $_GET['s_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $country = htmlspecialchars($_POST['country']);
    $price = intval($_POST['price']);
    $date = htmlspecialchars($_POST['date']);
    $image = htmlspecialchars($_FILES['image']['name']);

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "static/";
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
    } else {
        $image = htmlspecialchars($_POST['current_image']);
    }

    $sql = "UPDATE sport SET name=?, country=?, price=?, date=?, image=? WHERE s_id=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssissi", $name, $country, $price, $date, $image, $s_id);
    $stmt->execute();

    header("Location: ../index.php");
    exit();
}

$sport = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM sport WHERE s_id = $s_id"));
$prices = mysqli_query($connect, "SELECT * FROM price_id");