<?php

try {
    $pdo = Database::getInstance();
    $sql = "SELECT 
            id AS tariff_id,
            
            CONCAT_WS(', ',tariff_name, description, price_per_hour) AS tariff_description
            FROM tariffs
            WHERE is_active = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tariffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT
            id AS parking_id,
            spot_number AS spot_number
            FROM parking_spots
            WHERE is_occupied = 0";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->execute();
    $spots = $stmt1->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
}


$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST["fio"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $tariffKey = $_POST["select-tariff"] ?? "";
    if (isset($tariffs[$tariffKey])) {
        $tariff = $tariffs[$tariffKey];
    } elseif ($tariffKey === "value4") {
        $nameTariff = $_POST["name-tariff"] ?? "";
        $tariffPrice = $_POST["tariff-price"] ?? "";
        $minPrice = $_POST["min-price"] ?? "";
        $description = $_POST["description"] ?? "";
    }
}
?>

<div class="create-form">
    <form action="/create" method="POST">
        <div class="host-data">
            <div class="input-fio">
                <label for="fio">Фио паркующегося</label>
                <input type="text" id="fio" name="fio" placeholder="Name" required>
            </div>
            <div class="input-phone">
                <label for="phone">Номер паркующегося</label>
                <input type="tel" id="phone" name="phone" placeholder="+7999999999" required>
            </div>
        </div>
        <div class="tariff">
            <label for="select-tariff">Выберите тариф стаянки</label>
            <div class="select-wrapper">
                <select id="select-tariff" name="select-tariff" required>
                    <option value="create-tariff" selected>Добавить свой тариф</option>
                    <?php foreach ($tariffs as $tariff ): ?>
                    <option value="<?= htmlspecialchars($tariff['tariff_id'])?>">
                        <?= htmlspecialchars($tariff['tariff_description'])?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-tariff hidden">
                <div class="name-tariff">
                    <label for="name-tariff">Название тарифа</label>
                    <input type="text" id="name-tariff" name="name-tariff" placeholder="Дневной">
                </div>
                <div class="price-tariff">
                    <label for="price-tariff">Цена тарифа</label>
                    <input type="text" id="price-tariff" name="price-tariff" placeholder="100">
                </div>
                <div class="min-price">
                    <label for="min-price">Минимальная оплата</label>
                    <input type="text" id="min-price" name="min-price" placeholder="100">
                </div>
                <div class="description">
                    <label for="description">Описание</label>
                    <input type="text" id="description" name="description" placeholder="Ночной - 50руб/ч">
                </div>
            </div>
        </div>
        <div class="host-car">
            <div>
                <label for="licence_plate">Номер машины</label>
                <input type="text" id="licence_plate" name="licence_plate" placeholder="B123EX70RUS" required>
            </div>
            <div>
                <label for="car_model">Модель машины</label>
                <input type="text" id="car_model" name="car_model" placeholder="Ford Focus" required>
            </div>
            <div>
                <label for="car_color">Цвет машины</label>
                <input type="text" id="car_color" name="car_color" placeholder="Серебристый" required>
            </div>
            <div>
                <label for="car_appearance">Повреждения на машине</label>
                <input type="text" id="car_appearance" placeholder="Опешите повреждения если их нет напишите нет" required>
            </div>
        </div>
        <div class="spot">
            <label for="spot">Спот</label>
            <div class="select-wrapper">
                <select id="spot" name="spot" required>
                    <option value="create-spot" selected>Добавить новое место стоянки</option>
                    <?php foreach ($spots as $spot)?>
                    <option value="<">
                        Спот 2</option>
                </select>
            </div>
        </div>
        <input type="submit" value="Отправить">
    </form>
</div>
