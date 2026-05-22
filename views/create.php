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

$errors = [];
$success = "";
$old = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $old["fio"] = trim($_POST["fio"] ?? "");
    $old["phone"] = trim($_POST["phone"] ?? "");
    $old["select_tariff"] = trim($_POST["select_tariff"] ?? "");
    $old["name_tariff"] = trim($_POST["name_tariff"] ?? "");
    $old["tariff_price"] = trim($_POST["tariff_price"] ?? "");
    $old["min_price"] = trim($_POST["min_price"] ?? "");
    $old["description"] = trim($_POST["description"] ?? "");
    $old["licence_plate"] = trim($_POST["licence_plate"] ?? "");
    $old["car_color"] = trim($_POST["car_color"] ?? "");
    $old["car_model"] = trim($_POST["car_model"] ?? "");
    $old["car_appearance"] = trim($_POST["car_appearance"] ?? "");
    $old["spot"] = trim($_POST["spot"] ?? "");
    $old["spot_number"] = trim($_POST["spot_number"] ?? "");
    $old["type_spot"] = trim($_POST["type_spot"] ?? "");

    if (
        $old["fio"] === "" ||
        $old["phone"] === "" ||
        $old["select_tariff"] === "" ||
        $old["licence_plate"] === "" ||
        $old["car_color"] === "" ||
        $old["car_model"] === "" ||
        $old["car_appearance"] === "" ||
        $old["spot"] === ""
    ) {
        $errors[] = "Обязательные поля не заполнены это ФИО, телефон, тариф,
        номер машины и характеристики машины и место парковки.";
    }
    if ($old["select_tariff"] === "create_tariff" &&
        $old["name_tariff"] === "" ||
        $old["min_price"] === "" ||
        $old["description"] === "") {
        $errors[] = "Если вы хатите создать тарифф в системе заполните обязательные поля: имя тарифа, минимальная оплата, описание тарифа.";
    }
    if ($old["spot"] === "create_spot" &&
        $old["spot_number"] === "" || $old["type_spot"] === "") {
        $errors[] = "Если вы хотите создать новое место стоянки то должны заполнить обязательные поля: номер места, тип места.";
    }

    if (empty($errors)){
        try {
            $pdo = Database::getInstance();
            $sql = "";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([]);
            $success = "Записи занесены в информационную систему успешно";

        } catch (PDOException $e) {
            $errors[] = 'Ошибка базы данных' . $e->getMessage();
        }
    }

}
?>

<div class="create-form">
    <form  method="POST">
        <div class="host-data">
            <div class="input-fio">
                <label for="fio">Фио паркующегося</label>
                <input type="text" id="fio" name="fio" placeholder="Петров Петр Петрович"
                 value="<?= htmlspecialchars($old["fio"] ?? "") ?>">
            </div>
            <div class="input-phone">
                <label for="phone">Номер паркующегося</label>
                <input type="tel" autocomplete="tel" id="phone" name="phone" placeholder="+7999999999"
                value="<?= htmlspecialchars($old["phone"] ?? "") ?>">
            </div>
        </div>
        <div class="tariff">
            <label for="select_tariff">Выберите тариф стаянки</label>
            <div class="select-wrapper">
                <select id="select_tariff" name="select_tariff" >
                    <option value="default"<?= ($old["select_tariff"] ?? "") ===
                    "default"
                        ? " selected"
                        : "" ?>>Выберите тариф</option>
                    <option value="create_tariff">Добавить свой тариф</option>
                    <?php foreach ($tariffs as $tariff): ?>
                        <option value="<?= htmlspecialchars(
                            $tariff["tariff_id"],
                        ) ?>">
                        <?= htmlspecialchars(
                            $tariff["tariff_description"],
                        ) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-tariff">
                <div class="name-tariff">
                    <label for="name_tariff">Название тарифа</label>
                    <input type="text" id="name_tariff" name="name_tariff" placeholder="Дневной"
                    value="<?= htmlspecialchars($old["name_tariff"] ?? "") ?>">
                </div>
                <div class="price-tariff">
                    <label for="price_tariff">Цена тарифа</label>
                    <input type="text" id="price_tariff" name="price_tariff" placeholder="100"
                    value="<?= htmlspecialchars($old["price_tariff"] ?? "") ?>">
                </div>
                <div class="min-price">
                    <label for="min_price">Минимальная оплата</label>
                    <input type="text" id="min_price" name="min_price" placeholder="100"
                    value="<?= htmlspecialchars($old["min_price"] ?? "") ?>">
                </div>
                <div class="description">
                    <label for="description">Описание</label>
                    <input type="text" id="description" name="description" placeholder="Ночной - 50руб/ч"
                    value="<?= htmlspecialchars($old["description"] ?? "") ?>">
                </div>
            </div>
        </div>
        <div class="host-car">
            <div>
                <label for="licence_plate">Номер машины</label>
                <input type="text" id="licence_plate" name="licence_plate" placeholder="B123EX70RUS"
                value="<?= htmlspecialchars($old["licence_plate"] ?? "") ?>">
            </div>
            <div>
                <label for="car_model">Модель машины</label>
                <input type="text" id="car_model" name="car_model" placeholder="Ford Focus"
                value="<?= htmlspecialchars($old["car_model"] ?? "") ?>">
            </div>
            <div>
                <label for="car_color">Цвет машины</label>
                <input type="text" id="car_color" name="car_color" placeholder="Серебристый"
                value="<?= htmlspecialchars($old["car_color"] ?? "") ?>">
            </div>
            <div>
                <label for="car_appearance">Повреждения на машине</label>
                <input type="text" id="car_appearance" name="car_appearance" placeholder="Опешите повреждения если их нет напишите нет"
                value="<?= htmlspecialchars($old["car_appearance"] ?? "") ?>">
            </div>
        </div>
        <div class="spots">
            <label for="spot">Место стоянки</label>
            <div class="select-wrapper">
                <select id="spot" name="spot">
                    <option value="default" <?= ($old["spot"] ?? "") ===
                    "default"
                        ? "selected"
                        : "" ?>>Выберите место стоянки</option>
                    <option value="create_spot"  <?= ($old["spot"] ?? "") ===
                    "create_spot"
                        ? "selected"
                        : "" ?>>Добавить новое место стоянки</option>
                    <?php foreach ($spots as $spot): ?>
                        <option value="<?= htmlspecialchars(
                            $spot["parking_id"],
                        ) ?>">
                        <?= htmlspecialchars($spot["spot_number"]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-spot">
                <div>
                    <label for="spot_number">Номер места</label>
                    <input type="text" id="spot_number" name="spot_number" placeholder="A1"
                    value="<?= htmlspecialchars($old["spot_number"] ?? "") ?>">
                </div>
                <div>
                    <label for="type_spot">Тип парковочного места</label>
                    <select id="type_spot" name="type_spot">
                        <option value="regular" selected >Доступно</option>
                        <option value="disabled">Недоступно</option>
                        <option value="family">Служебный</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="error-form">
            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <input class="btn-submit" type="submit" value="Отправить">
    </form>
</div>
