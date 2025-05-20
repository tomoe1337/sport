php
<?php
session_start();
require_once "../vendor/connect.php"; // Adjust the path if necessary

// Проверка, является ли пользователь администратором
if (!isset($_SESSION['user']['is_admin']) || !$_SESSION['user']['is_admin']) {
    header('Location: ../');
    exit(); // Важно выйти после перенаправления
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "stylesheet" href = "../static/css/main.css"> <!-- Adjust path -->
	<title>Управление записями</title>
</head>
<body>

	<h1>Управление записями</h1>

	<?php
		// SQL запрос для выборки всех записей с информацией о пользователе и мероприятии
		$sql = "SELECT r.registration_id, u.full_name, s.name, r.registration_date 
                FROM registrations r 
                JOIN users u ON r.user_id = u.id 
                JOIN sport s ON r.sport_id = s.s_id";
		
		$result = $connect->query($sql);

		if ($result->num_rows > 0) {
			echo '<table>';
			echo '<thead>';
			echo '<tr>';
			echo '<th>ID Записи</th>';
			echo '<th>Пользователь</th>';
			echo '<th>Мероприятие</th>';
			echo '<th>Дата записи</th>';
			echo '<th>Действия</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';

			while ($row = $result->fetch_assoc()) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($row['registration_id']) . '</td>';
				echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
				echo '<td>' . htmlspecialchars($row['name']) . '</td>';
				echo '<td>' . htmlspecialchars($row['registration_date']) . '</td>';
				echo '<td><a href="../vendor/cancel_registration.php?registration_id=' . $row['registration_id'] . '">Отменить</a></td>';
				echo '</tr>';
			}

			echo '</tbody>';
			echo '</table>';
		} else {
			echo '<p>Записей пока нет.</p>';
		}
	?>

</body>
</html>