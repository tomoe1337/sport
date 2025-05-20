<?php
 if (isset($_GET['success']) && $_GET['success'] === 'registered') {
 echo '<p style="color: green;">Вы успешно записаны на мероприятие!</p>';
 }
 if (isset($_GET['error']) && $_GET['error'] === 'already_registered') {
 echo '<p style="color: red;">Вы уже записаны на это мероприятие.</p>';
 }
 if (isset($_GET['error']) && $_GET['error'] === 'no_places') {
 echo '<p style="color: red;">Нет свободных мест на данное мероприятие.</p>';
 }
if (isset($_GET['error']) && $_GET['error'] === 'event_passed') {
    echo '<p style="color: red;">Это мероприятие уже прошло.</p>';
}



    require_once "vendor/connect.php";
    $sql = "SELECT e.*, d.Cost, COUNT(registrations.registration_id) AS registered_count FROM `sport` e JOIN price_id d ON e.price = d.P_id LEFT JOIN registrations ON e.s_id = registrations.sport_id";
 $sql = $sql . " WHERE e.date >= CURDATE()";
    if (!empty($_POST['filter'])){
        $condition = "";
        $var = [];
        $typs = '';
        if ($_POST['country']){
             $condition = $condition . " `country` = ?";
             $typs = $typs . "s";
             $country = htmlspecialchars($_POST['country']);
             array_push($var, $country );

            }
        if ($_POST['price']) {
            $price = htmlspecialchars($_POST['price']);
            $typs = $typs . "s";
            array_push($var, $price );
            if ($condition) $condition = $condition . " AND";
            $condition = $condition . " `Cost` = ?" ;}

        if ($condition) {
            $sql = $sql . " AND {$condition}";
            $stmt = $connect -> prepare($sql);
            $stmt -> bind_param($typs,...$var);
            $stmt -> execute();
            $data = $stmt -> get_result();

 $sql = $sql . " GROUP BY e.s_id, e.name, e.price, e.country, e.date, e.image, d.P_id, d.Cost";
 }else{
            $data = mysqli_query($connect,$sql);
        }
    }else{
        $data = mysqli_query($connect,$sql);
 $sql = $sql . " GROUP BY e.s_id, e.name, e.price, e.country, e.date, e.image, d.P_id, d.Cost";
    }


require_once("sport_table.php");