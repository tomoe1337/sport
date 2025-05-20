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
    echo '<table class="sports-table">';
   // Add table headers here if needed
   echo '<thead>';
   echo '<tr>';
   echo '<th>Название</th>';
   echo '<th>Дата</th>';
   echo '<th>Стоимость</th>';
   echo '<th>Изображение</th>';
   echo '<th>Записано</th>';
   echo '<th>Действия</th>'; // Колонка для кнопок действий
   echo '</tr>';
   echo '</thead>';
   echo '<tbody>';
    while ($sport = mysqli_fetch_assoc($data)){
        echo '<tr>';
        echo "<td>{$sport['name']}</td>";
        echo "<td>{$sport['date']}</td>";
        echo "<td>{$sport['Cost']}</td>";
       echo '<td>';
       echo "<a href='sport.php?s_id={$sport['s_id']}'>";
       echo "<img src='static/{$sport["image"]}' alt='' height='80px'>";
       echo "</a>";
       echo "</td>";
 echo '</td>';
        echo '<td>';
        echo "<a href='sport.php?s_id={$sport['s_id']}'>";
        echo "<img src='static/{$sport["image"]}' alt='' height='80px'>";
        echo "</a>";
        echo "<a href='edit_sport.php?s_id={$sport['s_id']}' class='btn btn-secondary btn-sm'>Редактировать</a> ";
        echo "<a href='vendor/delete_sport.php?s_id={$sport['s_id']}' class='btn btn-danger btn-sm'>Удалить</a> ";
        echo "</td>";
 echo "<td>{$sport['registered_count']}</td>";
       echo '<td>'; // Ячейка для кнопок действий
       // Проверяем, залогинен ли пользователь и является ли он автором мероприятия
       if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $sport['author_id']) {
           // Пользователь является автором, показываем кнопки Редактировать и Удалить
           echo "<a href='edit_sport.php?s_id={$sport['s_id']}'>Редактировать</a> ";
           echo "<a href='vendor/delete_sport.php?s_id={$sport['s_id']}' onclick=\"return confirm('Вы уверены, что хотите удалить это мероприятие?');\">Удалить</a>";
       } else {
           // Пользователь не является автором или не залогинен, показываем кнопку Записаться
           echo "<a href='vendor/register_for_sport.php?s_id={$sport['s_id']}' class='btn btn-primary btn-sm'>Записаться</a>";
       }
        echo '</tr>';
    }
    echo '</table>';