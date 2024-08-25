<?php

$server = "localhost";
$username = "root";
$password = "";
$dbName = "final_project";
try {
    $connection = new PDO("mysql:host=$server;dbname=$dbName; charset=utf8", $username, $password);
} catch (Exception $e) {
    echo "Connection faild: ".$e->getMessage();
}
