<?php
require_once "vendor/add_sport_logic.php";
require_once "templates/base.php";
?>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Добавить новую запись</h1>
        <form method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Название:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6">
                <label for="country" class="form-label">Страна:</label>
                <input type="text" class="form-control" id="country" name="country" required>
            </div>
            <div class="col-md-6">
                <label for="price" class="form-label">Цена:</label>
                <select class="form-select" id="price" name="price" required>
                    <?php while ($row = mysqli_fetch_assoc($prices)): ?>
                        <option value="<?= $row['P_id'] ?>"><?= $row['Cost'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label">Дата:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="col-md-6">
                <label for="image" class="form-label">Изображение:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
</body>
</html>