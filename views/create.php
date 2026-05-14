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
                    <option value="value1" selected>Дневной 100руб/час</option>
                    <option value="value2">Ночной 50руб/час</option>
                    <option value="value3">Суточный 800руб/день</option>
                </select>
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
        <button type="submit">Create</button>
    </form>
</div>