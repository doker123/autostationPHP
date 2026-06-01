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

//    $sql = "DELETE id FROM parkings WHERE id = :id";
//    $stmt = $pdo->prepare($sql);
//    $stmt->execute(['id' => $parking_id]);



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