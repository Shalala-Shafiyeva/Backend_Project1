<?php
include_once "../../adminIndex.php";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    //Hemen user-i select edirik
    $sql = "SELECT active FROM users WHERE id=?";
    $userQuery = $connection->prepare($sql);
    $userQuery->execute([$id]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);

    //Yoxlayirik ki activedirse deactive edek yox deactivdirse active edek
    if ($user['active'] == 1) {
        $sql = "UPDATE users SET active=? WHERE id=?";
        $userQuery = $connection->prepare($sql);
        $userQuery->execute(["0", $id]);
    } else {
        $sql = "UPDATE users SET active=? WHERE id=?";
        $userQuery = $connection->prepare($sql);
        $userQuery->execute(["1", $id]);
    }
    header("location:index.php");
}
