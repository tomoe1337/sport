<?php
    echo '<table class="sports-table">';
    while ($sport = mysqli_fetch_assoc($data)){
        echo '<tr>';
       // Assuming you want headers, add them before the loop
       // This part is commented out as the original code doesn't have headers
       /*
       echo '<thead>';
       echo '<tr>';
       echo '<th>ID</th>';
       echo '<th>Название</th>';
       echo '<th>Цена (ID)</th>';
       echo '<th>Страна</th>';
       echo '<th>Дата</th>';
       echo '<th>Стоимость</th>';
       echo '<th>Записано</th>';
       echo '<th>Действия</th>';
       echo '</tr>';
       echo '</thead>';
       */
        echo "<td>{$sport['name']}</td>";
        echo "<td>{$sport['date']}</td>";
        echo "<td>{$sport['Cost']}</td>";
 echo '<td>';
 echo "<a href='vendor/register_for_sport.php?s_id={$sport['s_id']}' class='btn btn-primary btn-sm'>Записаться</a>";
 echo '</td>';
        echo '<td>';
        echo "<a href='sport.php?s_id={$sport['s_id']}'>";
        echo "<img src='static/{$sport["image"]}' alt='' height='80px'>";
        echo "</a>";
        echo "<a href='edit_sport.php?s_id={$sport['s_id']}' class='btn btn-secondary btn-sm'>Редактировать</a> ";
        echo "<a href='vendor/delete_sport.php?s_id={$sport['s_id']}' class='btn btn-danger btn-sm'>Удалить</a> ";
        echo "</a>";
        echo "</td>";
 echo "<td>{$sport['registered_count']}</td>";
        echo '</tr>';
    }
    echo '</table>';