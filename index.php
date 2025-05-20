<?php
    $header = "Спорт";
    require_once( "templates/base.php");
    session_start();
    if (!isset($_SESSION['user'])){
    header("Location: login.php");
    }    
?>

<body>
    <form name = "form" style = "display: flex;flex-direction: column;width: 300px;" action="index.php" method="post">
        <label >Страна</label>
        <input  type = "text", name='country' placeholder="Введите страну">
        <label >Цена</label>
        <input  type = "text", name='price' list = "options" placeholder="Дорого или дешево">
         <datalist id="options">
          <option value="Дорого">
          <option value="Дёшево">
        </datalist>       

        <button name = "filter" type = "submit" value="filter_on" >Фильтрация</button>
    </form>
    <div>
        <a href="add_sport.php" class="btn btn-primary">Добавить запись</a>
    </div>
</body>

<?php
require_once( "sport_list.php");


?>
