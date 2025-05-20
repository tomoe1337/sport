<?php
require_once "vendor/connect.php";

// Начало SQL запроса с условием по дате
$sql = "SELECT e.*, d.Cost, COUNT(registrations.registration_id) AS registered_count FROM `sport` e JOIN price_id d ON e.price = d.P_id LEFT JOIN registrations ON e.s_id = registrations.sport_id WHERE e.date >= CURDATE()";

$params = [];
$types = '';
$filter_conditions = [];

if (!empty($_POST['filter'])){
    if (!empty($_POST['country'])){
        $filter_conditions[] = "`country` = ?";
        $types .= "s";
        $params[] = htmlspecialchars($_POST['country']);
    }
    if (!empty($_POST['price'])) {
        $filter_conditions[] = "`Cost` = ?";
        $types .= "s";
        $params[] = htmlspecialchars($_POST['price']);
    }
}

if (!empty($filter_conditions)) {
    $sql .= " AND " . implode(" AND ", $filter_conditions);
}

// Добавляем GROUP BY
$sql .= " GROUP BY e.s_id, e.name, e.price, e.country, e.date, e.image, d.P_id, d.Cost";

// Выполнение запроса
if (!empty($params)) {
    $stmt = $connect->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $data = $stmt->get_result();
} else {
    $data = mysqli_query($connect, $sql);
}

require_once("sport_table.php");