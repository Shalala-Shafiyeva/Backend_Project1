<?php
include_once "../../index.php";
$sql = "UPDATE blogs SET is_publish=? WHERE id=?";
$acceptQuery = $connection->prepare($sql);
$acceptQuery->execute(["1", $_GET['id']]);
header("location: index.php");
