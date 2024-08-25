<?php
include_once "../../index.php";
$sql = "DELETE FROM catigories";
$deleteAllQuery = $connection->prepare($sql);
$deleteAllQuery->execute([]);

//Это способ удалить все записи из таблицы если на нее есть внешиний ключ
//Т.к без этого не возможно опустошить таблице используя TRUNCATE
// $connection->exec("SET FOREIGN_KEY_CHECKS = 0");
// $connection->exec("TRUNCATE TABLE categories");
// $connection->exec("SET FOREIGN_KEY_CHECKS = 1");
header('Location: select.php');
