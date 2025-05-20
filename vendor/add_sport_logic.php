<?php
require_once "connect.php";

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
    }

    $sql = "INSERT INTO sport (name, country, price, date, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssiss", $name, $country, $price, $date, $image);
    $stmt->execute();

    header("Location: index.php");
    exit();
}

// Получаем список цен
$prices = mysqli_query($connect, "SELECT * FROM price_id");