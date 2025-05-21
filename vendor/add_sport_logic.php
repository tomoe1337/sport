<?php
session_start(); // Добавил старт сессии, чтобы получить доступ к $_SESSION
require_once "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка, авторизован ли пользователь
    if (!isset($_SESSION['user']['id'])) {
        // Если пользователь не авторизован, перенаправить на страницу входа
        header("Location: login.php");
        exit();
    }

    $name = htmlspecialchars($_POST['name']);
    $country = htmlspecialchars($_POST['country']);
    $price = intval($_POST['price']);
    $date = htmlspecialchars($_POST['date']);
    $image = htmlspecialchars($_FILES['image']['name']);
    $author_id = $_SESSION['user']['id']; // Получаем ID текущего пользователя

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "static/";
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
    }

    // Измененный SQL-запрос с добавлением author_id
    $sql = "INSERT INTO sport (name, country, price, date, image, author_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    // Измененная привязка параметров с добавлением author_id (тип 'i' для integer)
    $stmt->bind_param("ssissi", $name, $country, $price, $date, $image, $author_id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}

// Получаем список цен
$prices = mysqli_query($connect, "SELECT * FROM price_id");
?>