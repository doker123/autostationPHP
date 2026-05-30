<?php
$ROOT_PATH = __DIR__;
$parts = explode('/', trim($ROOT_PATH, '/'));
$pathRoot = '/'.$parts[4].'/';

$parking_id = $id ?? '';
$errors = [];
$record = null;

try {
    $pdo = Database::getInstance();
    $pdo->beginTransaction();
    $sql = "";



    $pdo->commit();
}catch (Exception $e){
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $errors[] = 'Ошибка базы данных' . $e->getMessage();
}

header("Location: ". $pathRoot ."home.php");
exit();
?>