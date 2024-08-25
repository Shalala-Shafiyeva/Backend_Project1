<?php
include_once "../../index.php";
$id = $_GET['id'];
$sql = "DELETE FROM catigories WHERE id=?";
$deleteQuery = $connection->prepare($sql);
$deleteQuery->execute([$id]);
header("Location: select.php");
