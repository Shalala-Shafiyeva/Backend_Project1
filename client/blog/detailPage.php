<?php
include_once "../../index.php";

//Her bu sehifeye giris olanda blogu view_count-u artiririq

$id = $_GET['id'];
//1-ci blog-u secirik
$sql = "SELECT blogs.*, users.name AS author_name, users.surname AS author_surname, catigories.name AS category_name FROM blogs
      LEFT JOIN users ON users.id = blogs.user_id
      LEFT JOIN catigories ON catigories.id = blogs.category_id
      WHERE blogs.id=? ";
$viewQuery = $connection->prepare($sql);
$viewQuery->execute([$id]);
$blog = $viewQuery->fetch(PDO::FETCH_ASSOC);
$view_count = $blog["view_count"];

//2-ci view_count-un deyerini artiririq
$sql = "UPDATE blogs SET view_count = ?, updated_at = NOW() WHERE id = ?";
$viewQuery = $connection->prepare($sql);
$viewQuery->execute([$view_count += 1, $id]);
?>

<div class="detailsBlog">
    <div class="img">
        <img src="/backend_project1/public/<?= $blog['profile'] ?>" alt="">
    </div>
    <div class="content">
        <div class="title"><?= $blog['title'] ?></div>
        <div class="desc"><?= $blog['description'] ?></div>
        <div class="author">Author: <?= $blog['author_name']." ".$blog['author_surname'] ?></div>
        <div class="category"><?= $blog['category_name'] ?></div>
        <div class="date">Date: <?= $blog['updated_at'] ?></div>
        <div class="views"><?= $blog['view_count'] ?> reviews</div>
    </div>
</div>