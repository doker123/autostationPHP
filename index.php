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
/**@var PDO $pdo*/
require_once "backend/con_db.php";
require_once "backend/functions.php";
$stmt = $pdo->prepare("
    SELECT CONCAT(cl.last_name,' ',cl.first_name) as full_name,
           cl.phone as phone,
           CONCAT(cl.debt,' руб') as debt,
           CONCAT(c.make,' ', c.model,' ', c.color) as description_auto,
           CONCAT_WS(', ',CONCAT('№',sp.spot_number),CONCAT('type: ',sp.spot_type)) as spot,
           DATEDIFF(exit_time,entry_time) as days_parking,
           CONCAT(r.day_rate * DATEDIFF(exit_time,entry_time),' тыс руб') as for_payment,
           is_paid
    FROM parking_sessions ps
    JOIN cars c ON ps.car_id = c.car_id
    JOIN parking_spots sp ON ps.spot_id = sp.spot_id
    JOIN clients cl ON c.client_id = cl.client_id
    JOIN rates r ON ps.rate_id = r.rate_id
    WHERE  session_id");
$stmt->execute();
$sessionParking = $stmt->fetchAll();
$tag = "div";
$class = "cell";
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
        <?php
        if ($sessionParking) {

            foreach ($sessionParking as $key => $value ) {
            echo "<div class ='row-table'>";
            wrapperTag($value["full_name"], $tag, $class);
            wrapperTag($value["phone"], $tag, $class);
            wrapperTag($value["debt"], $tag, $class);
            wrapperTag($value["description_auto"], $tag, $class);
            wrapperTag($value["spot"], $tag, $class);
            wrapperTag($value["days_parking"], $tag, $class);
            wrapperTag($value["for_payment"], $tag, $class);
            if ($value["is_paid"] == 1) {
                wrapperTag("Да", $tag, $class);
            } else {
                wrapperTag("Нет", $tag, $class);
            }

            echo "</div>";
            }
            echo "</div>";
        } else {
            die("Ошибка база данных пуста");
        }
        ?>
    </div>
</section>
</body>
</html>


