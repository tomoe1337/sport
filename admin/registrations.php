php
<?php
session_start();
require_once "../vendor/connect.php";

// Проверка, является ли пользователь администратором
if (!isset($_SESSION['user']['is_admin']) || !$_SESSION['user']['is_admin']) {
    header('Location: ../');
 exit();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "stylesheet" href = "/static/css/main.css">
	<title>Управление записями</title>
</head>
<body>

	<h1>Управление записями</h1>

 <?php
 // Обработка фильтрации
 $filter_user_id = $_GET['user_id'] ?? null;
 $filter_sport_id = $_GET['sport_id'] ?? null;

 // Начало SQL запроса
 $sql = "SELECT r.registration_id, u.full_name, s.name AS sport_name, r.registration_date FROM registrations r JOIN users u ON r.user_id = u.id JOIN sport s ON r.sport_id = s.s_id";

 $where_conditions = [];
 $params = [];
 $types = '';

 if ($filter_user_id) {
 $where_conditions[] = "r.user_id = ?";
 $types .= "i";
 $params[] = $filter_user_id;
 }

 if ($filter_sport_id) {
 $where_conditions[] = "r.sport_id = ?";
 $types .= "i";
 $params[] = $filter_sport_id;
 }

 if (!empty($where_conditions)) {
 $sql .= " WHERE " . implode(" AND ", $where_conditions);
 }

 // Выполнение запроса
 if (!empty($params)) {
 $stmt = $connect->prepare($sql);
 $stmt->bind_param($types, ...$params);
 $stmt->execute();
 $result = $stmt->get_result();
 } else {
 $result = mysqli_query($connect, $sql);
 }

 echo '<table>';
 echo '<thead>';
 echo '<tr>';
 echo '<th>ID Записи</th>';
 echo '<th>Пользователь</th>';
 echo '<th>Мероприятие</th>';
 echo '<th>Дата записи</th>';
 echo '<th>Действия</th>'; // Колонка для кнопки отмены
 echo '</tr>';
 echo '</thead>';
 echo '<tbody>';

 if ($result->num_rows > 0) {
 while ($row = $result->fetch_assoc()) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($row['registration_id']) . '</td>';
				echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
				echo '<td>' . htmlspecialchars($row['name']) . '</td>';
				echo '<td>' . htmlspecialchars($row['registration_date']) . '</td>';
				echo '<td><a href="../vendor/cancel_registration.php?registration_id=' . $row['registration_id'] . '">Отменить</a></td>';
				echo '</tr>';
			}
 } else {
 echo '<tr><td colspan="5">Записей не найдено.</td></tr>';
 }

 echo '</tbody>';
 echo '</table>';

 if (!empty($params)) {
 $stmt->close();
 }
 ?>

</body>
</html>