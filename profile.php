<?php
    require_once "vendor/connect.php";

	session_start();
if (!isset($_SESSION['user'])){
	header("Location: /");
}

if (isset($_GET['success']) && $_GET['success'] === 'cancelled') {
    echo '<p style="color: green;">Запись успешно отменена.</p>';
}
if (isset($_GET['error']) && $_GET['error'] === 'cancel_failed') {
    echo '<p style="color: red;">Ошибка при отмене записи.</p>';
    // Возможно, здесь не стоит перенаправлять, а просто показать сообщение об ошибке
    // header("Location: /");
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel = "stylesheet" href = "static/css/main.css">
	<title>Профиль</title>
</head>
<body>

	<div>
		<img src="<?= $_SESSION['user']['avatar']?>" width ="100" alt = "">
		<h2><?=$_SESSION['user']['full_name']?></h2>
		<a href="#"><?= $_SESSION['user']['email']?></a>
		<a href="/">Список</a>
		<a href="vendor/logout.php" class="logout">Выход</a>
	</div>

	<?php

    $user_id = $_SESSION['user']['id'];

    // SQL запрос для получения записанных мероприятий с датой
    $sql = "SELECT r.registration_id, s.name, s.date FROM registrations r JOIN sport s ON r.sport_id = s.s_id WHERE r.user_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div>';
    echo '<h2>Записанные мероприятия</h2>';
    echo '<ul id="profile-events-list">';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<li>';
            echo htmlspecialchars($row['name']);
            // Добавляем дату мероприятия
            echo ' (' . htmlspecialchars($row['date']) . ')';
            // Добавляем кнопку отмены записи
            echo ' <a href="vendor/cancel_registration.php?registration_id=' . $row['registration_id'] . '">Отменить</a>';
            echo '</li>';
        }
    } else {
        echo '<li>Вы пока не записаны ни на одно мероприятие.</li>';
    }

    echo '</ul>';
    echo '</div>';

    $stmt->close();
?>

</body>
</html>