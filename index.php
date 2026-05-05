<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Автостоянка</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
require_once 'config/connectionDb.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = Database::getInstance();
    $stmt = $pdo->prepare("SELECT * FROM parking_records ORDER BY id DESC");
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Оштбка базы данных: " . $e->getMessage());
}
?>
<section class="main-table">
    <div class="table">
        <div class="table-head row-table">
            <div class="cell">Фамилия и Имя</div>
            <div class="cell">Номер телефона</div>
            <div class="cell">Долг</div>
            <div class="cell">Внешний вид машины</div>
            <div class="cell">Место на стоянке</div>
            <div class="cell">Время парковки</div>
            <div class="cell">Итоговая цена парковки</div>
            <div class="cell">Оплачена ли парковка</div>
            <div class="action cell">Действия с записью</div>
        </div>
        <?php if (!empty($records)): ?>
            <?php foreach ($records as $row): ?>
        <div class="row-table">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div>Данные отсутствают</div>
        <?php endif; ?>
    </div>
</section>
</body>
</html>