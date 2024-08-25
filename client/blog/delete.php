<?php
include_once "../../index.php";
$sql="DELETE FROM blogs WHERE id=?";
$deleteQuery = $connection->prepare($sql);
$deleteQuery->execute([$_GET['id']]);
header("location:select.php");
?>