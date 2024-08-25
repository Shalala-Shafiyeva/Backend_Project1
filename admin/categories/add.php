<?php
include_once "../../index.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    print_r("Hello");
    $errors = validation(["add"]);
    if(empty($errors)){
        $sql = "INSERT INTO catigories(name) VALUES(?)";
        $insertQuery = $connection->prepare($sql);
        $insertQuery->execute([
            post('add')
        ]);
    }
    header("Location: select.php");
}
?>
