<?php
$parking_id = $id ?? '';
$errors = [];
$record = null;

try {
    $pdo = Database::getInstance();
    $pdo->beginTransaction();
    $sql = "";


}catch (Exception $e){
    $errors[] = 'Ошибка базы данных' . $e->getMessage();
}
?>