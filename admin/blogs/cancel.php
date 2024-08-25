<?php
include_once "../../index.php";
$sql = "DELETE FROM blogs WHERE id=?";
$acceptQuery = $connection->prepare($sql);
$acceptQuery->execute([$_GET['id']]);
header("location: index.php");
