<?php
session_start();
require_once "connect.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Проверяем, является ли пользователь администратором
if (isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin']) {
    $is_admin = true;
} else {
    $is_admin = false;
}

// Получаем ID записи для отмены из GET-параметра
if (isset($_GET['registration_id'])) {
    $registration_id = intval($_GET['registration_id']);
} else {
    // Если ID записи не передан, перенаправляем пользователя обратно на страницу профиля
    header("Location: ../profile.php?error=missing_registration_id");
    exit();
}

// Получаем ID текущего пользователя
if (!$is_admin) {
    $user_id = $_SESSION['user']['id'];
}

// Проверяем, существует ли запись и принадлежит ли она текущему пользователю
$check_sql = "SELECT COUNT(*) FROM `registrations` WHERE `registration_id` = ?" . ($is_admin ? "" : " AND `user_id` = ?");
$check_stmt = $connect->prepare($check_sql);
if ($is_admin) {
    $check_stmt->bind_param("i", $registration_id);
} else {
    $check_stmt->bind_param("ii", $registration_id, $user_id);
}
$check_stmt->execute();
$check_result = $check_stmt->get_result()->fetch_row()[0];

// Подготавливаем и выполняем SQL запрос для удаления записи
$sql = "DELETE FROM `registrations` WHERE `registration_id` = ? AND `user_id` = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ii", $registration_id, $user_id);
$stmt->execute();

// Проверяем, была ли запись удалена
// Проверяем, была ли запись удалена и перенаправляем
if ($stmt->affected_rows > 0 || $check_result == 0) { // Если запись не существовала или удалена
    header('Location: ../profile.php?success=cancelled'); // Считаем это успешной отменой (или отсутствием записи для отмены)
    exit();
} else {
    // Если запись не была удалена (возможно, не найдена или не принадлежит пользователю)
    header('Location: ../profile.php?error=cancel_failed');
    exit();
}
?>