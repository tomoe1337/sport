<?php
ob_start();
$header = "Комментарии о виде спорта";
require( "templates/base.php");
echo ob_get_clean();
require_once "vendor/connect.php";
if (!isset($_GET['s_id'])) {
    header("Location: index.php");
    die();
}
$s_id = $_GET['s_id'];
$sport_info = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM `sport` WHERE `s_id` = $s_id"));
$tasks = (mysqli_query($connect,"SELECT * FROM `comments` WHERE `s_id` = $s_id"));
?>


    <table class="sports-table comment-page">
        <tr class="table-header">
                <td>
                    Картинка
                </td>
                <td>
                    Номер
                </td>
                <td>
                    Название
                </td>
                <td>
                    Страна
                </td>
                <td>
                    Цена
                </td>
                <td>
                    День чемпионата
                </td>
            </tr>
        <tr>
                <td>
                    <?php echo "<img src= 'static/{$sport_info['image']}' alt='' height='160px'>";?>
                </td>
                <td>
                    <?php echo "{$sport_info['s_id']}";?>                
                </td>
                <td>
                    <?php echo "{$sport_info['name']}";?>                

                </td>
                <td>
                    <?php echo "{$sport_info['country']}";?>              

                </td>
                <td>
                    <?php echo "{$sport_info['price']}";?>            

                </td>
                <td>
                    <?php echo "{$sport_info['date']}";?>
                </td>
            </tr>
    </table>

<form action="/vendor/set_db_comments.php?s_id=<?=$s_id?>" method="POST" class="form-comment-treatment">
    <p>Новый комментарий:</p>
    <p><textarea name="comment" s_id="" cols="100" rows="5"></textarea></p>
    <p><input type="submit" name="new-comment" value="Создать">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="delete-button" value="Удалить комментарии" class="delete-button"></p>
</form>
    <table class="comment-header head">
        <tr>
            <td class = "comment-header head">
                <h1>Комментарии о виде спорта</h1>
            </td>
        </tr>
    </table>

<table class="comment-header">
<?php
while ($comment = mysqli_fetch_assoc($tasks)){
    echo "<tr>";
    echo "<td>";
    echo "{$comment['comment_id']}";                                       
    echo "</td>";
    echo "<td>";
    echo "{$comment['comment']}";                                       
    echo "</td>";
    echo "<td>";
    echo "{$comment['date']}";                                       
    echo "</td>";
    echo "</tr>";
}
?>
</table>
