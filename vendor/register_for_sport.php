php
<?php
session_start();
require_once "connect.php";

if (!$_SESSION['user']) {
    header('Location: ../login.php');
}

$sport_id = $_GET['s_id'];
$user_id = $_SESSION['user']['id'];
$registration_date = date('Y-m-d H:i:s');

// Check event date
$date_sql = "SELECT date FROM sport WHERE s_id = ?";
$date_stmt = $connect->prepare($date_sql);
$date_stmt->bind_param("i", $sport_id);
$date_stmt->execute();
$date_result = $date_stmt->get_result();
$event_date_row = $date_result->fetch_assoc();

if ($event_date_row && strtotime($event_date_row['date']) < time()) {
    header('Location: ../index.php?error=event_passed');
    exit(); // Stop further execution
}
$date_stmt->close();


// Check if user is already registered for this sport
$check_sql = "SELECT COUNT(*) FROM registrations WHERE user_id = ? AND sport_id = ?";
$check_stmt = $connect->prepare($check_sql);
$check_stmt->bind_param("ii", $user_id, $sport_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();
$row = $check_result->fetch_assoc();

// Check for available places
$places_sql = "SELECT s.max_participants, COUNT(r.registration_id) AS registered_count FROM sport s LEFT JOIN registrations r ON s.s_id = r.sport_id WHERE s.s_id = ? GROUP BY s.s_id";
$places_stmt = $connect->prepare($places_sql);
$places_stmt->bind_param("i", $sport_id);
$places_stmt->execute();
$places_result = $places_stmt->get_result();
$places_data = $places_result->fetch_assoc();

if ($places_data) {
    $max_participants = $places_data['max_participants'];
    $registered_count = $places_data['registered_count'];

    // If max_participants is set and current registrations are >= max
    if ($max_participants !== NULL && $registered_count >= $max_participants) {
        header('Location: ../index.php?error=no_places');
        exit(); // Stop further execution
    }
} else {
    // Handle case where sport is not found (optional, but good practice)
    header('Location: ../index.php?error=sport_not_found');
    exit();
}
$places_stmt->close();

if ($row['COUNT(*)'] > 0) {
    header('Location: ../index.php?error=already_registered');
     exit(); // Stop further execution
}
if (!empty($sport_id) && !empty($user_id)) {
    $sql = "INSERT INTO `registrations` (`user_id`, `sport_id`, `registration_date`) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("iis", $user_id, $sport_id, $registration_date);

    if ($stmt->execute()) {
        header('Location: ../index.php?success=registered');
    } else {
        header('Location: ../index.php');
    }

    $stmt->close();
} else {
    $_SESSION['message'] = 'Не удалось получить данные для записи на мероприятие.';
    header('Location: ../index.php');
}

?>