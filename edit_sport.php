<?php
require_once "vendor/edit_sport_logic.php";
require_once "templates/base.php";
?>

<h1 class="mb-4">Редактировать запись</h1>
<form method="POST" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Название:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $sport['name'] ?>" required>
    </div>
    <div class="col-md-6">
        <label for="country" class="form-label">Страна:</label>
        <input type="text" class="form-control" id="country" name="country" value="<?= $sport['country'] ?>" required>
    </div>
    <div class="col-md-6">
        <label for="price" class="form-label">Цена:</label>
        <select class="form-select" id="price" name="price" required>
            <?php while ($row = mysqli_fetch_assoc($prices)): ?>
                <option value="<?= $row['P_id'] ?>" <?= $row['P_id'] == $sport['price'] ? 'selected' : '' ?>>
                    <?= $row['Cost'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="date" class="form-label">Дата:</label>
        <input type="datetime-local" class="form-control" id="date" name="date" value="<?= $sport['date'] ?>" required>
    </div>
    <div class="col-md-6">
        <label for="image" class="form-label">Текущее изображение:</label><br>
        <img src="static/<?= $sport['image'] ?>" alt="" height="80px" class="mb-2"><br>
        <label for="image" class="form-label">Новое изображение:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        <input type="hidden" name="current_image" value="<?= $sport['image'] ?>">
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-success">Сохранить</button>
    </div>
</form>
