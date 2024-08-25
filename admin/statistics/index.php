<?php
include_once "../../adminIndex.php";

//umumi baxis(oxunma) sayi
$sql = "SELECT SUM(view_count) AS views FROM blogs";
$viewQuery = $connection->prepare($sql);
$viewQuery->execute([]);
$view_count = $viewQuery->fetch(PDO::FETCH_ASSOC);

//heltelik oxunma sayi
$sql = "SELECT SUM(view_count) AS views FROM blogs
    WHERE WEEK(NOW()) = WEEK(updated_at) AND 
    YEAR(updated_at) = YEAR(NOW())";
$viewQuery = $connection->prepare($sql);
$viewQuery->execute([]);
$week_views = $viewQuery->fetch(PDO::FETCH_ASSOC);

//ayliq oxunma sayi
$sql = "SELECT SUM(view_count) AS views FROM blogs
      WHERE MONTH(NOW()) = MONTH(updated_at)  AND 
      YEAR(updated_at) = YEAR(NOW())";
$viewQuery = $connection->prepare($sql);
$viewQuery->execute([]);
$month_views = $viewQuery->fetch(PDO::FETCH_ASSOC);

//bugun elave edilen bloglar ve sayi
$sql = "SELECT blogs.*, users.name AS name, users.surname AS surname, catigories.name AS category_name,
        (SELECT COUNT(blogs.id) AS count FROM blogs WHERE DATE(blogs.created_at) = CURRENT_DATE()) AS count
        FROM blogs
        LEFT JOIN users ON users.id = blogs.user_id
        LEFT JOIN catigories ON catigories.id = blogs.category_id
        WHERE DATE(blogs.created_at) = CURRENT_DATE()";
$viewQuery = $connection->prepare($sql);
$viewQuery->execute([]);
$today_blogs = $viewQuery->fetchAll(PDO::FETCH_ASSOC);
//bu hefte elave edilen bloglar ve sayi
$sql = "SELECT blogs.*, users.name AS name, users.surname AS surname, catigories.name AS category_name,
        (SELECT COUNT(blogs.id) FROM blogs WHERE WEEK(blogs.created_at) = WEEK(NOW())) AS count
        FROM blogs
        LEFT JOIN users ON users.id = blogs.user_id
        LEFT JOIN catigories ON catigories.id = blogs.category_id
        WHERE WEEK(blogs.created_at) = WEEK(NOW())";
$viewQuery = $connection->prepare($sql);
$viewQuery->execute([]);
$week_blogs = $viewQuery->fetchAll(PDO::FETCH_ASSOC);

//Bu ay elave edilern bloglar ve sayi
$sql = "SELECT blogs.*, users.name AS name, users.surname AS surname, catigories.name AS category_name,
        (SELECT COUNT(blogs.id) FROM blogs WHERE MONTH(blogs.created_at) = MONTH(NOW())) AS count
        FROM blogs
        LEFT JOIN users ON users.id = blogs.user_id
        LEFT JOIN catigories ON catigories.id = blogs.category_id
        WHERE MONTH(blogs.created_at) = MONTH(NOW())";
$viewQuery = $connection->prepare($sql);
$viewQuery->execute([]);
$month_blogs = $viewQuery->fetchAll(PDO::FETCH_ASSOC);
?>


<section class="adminPanel">
    <?php include_once "../dashboard.php" ?>
    <div class="content">
        <?php include_once "../topBar.php" ?>
        <div class="main">
            <div class="statistics">
                <h2>Bu gun/heftelik/ayliq umumi oxunma sayi</h2>
                <h3>Umimi oxumna sayi: <?php print_r($view_count['views']) ?></h3>
                <h3>Heftelik oxumna sayi: <?php print_r($week_views['views']) ?></h3>
                <h3>Ayliq oxumna sayi: <?php print_r($month_views['views']) ?></h3>
                <div class="blogSection">
                    <h2>Bugun elave edilen bloglar</h2>
                    <h3>Sayi: <?php echo isset($today_blogs[0]['count']) ? $today_blogs[0]['count'] : 0 ?></h3>
                    <div class="blogs">
                        <?php
                        if (!empty($today_blogs)) {
                            foreach ($today_blogs as $today_blog) {
                        ?>
                                <div class="blog">
                                    <div class="img">
                                        <img src="/backend_project1/public/<?= $today_blog['profile'] ?>" alt="Profile">
                                    </div>
                                    <div class="info">
                                        <div class="title"><?= $today_blog['title'] ?></div>
                                        <div class="desc"><?= $today_blog['description'] ?></div>
                                        <div class="details">
                                            <div class="view">Views: <?= $today_blog['view_count'] ?></div>
                                            <div class="date">Created: <?= $today_blog['created_at'] ?></div>
                                            <div class="date">Updated: <?= $today_blog['updated_at'] ?></div>
                                        </div>
                                        <div class="details">
                                            <div class="author">Author: <?= $today_blog['name'] . " " . $today_blog['surname']  ?></div>
                                            <div class="category">Category: <?= $today_blog['category_name'] ?></div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <br>
                    <br>
                    <h2>Bu hefte elave edilen bloglar</h2>
                    <h3>Sayi: <?php echo isset($week_blogs[0]['count']) ? $week_blogs[0]['count'] : 0  ?></h3>
                    <div class="blogs">
                        <?php
                        if (!empty($week_blogs)) {
                            foreach ($week_blogs as $week_blog) {
                        ?>
                                <div class="blog">
                                    <div class="img">
                                        <img src="/backend_project1/public/<?= $week_blog['profile'] ?>" alt="Profile">
                                    </div>
                                    <div class="info">
                                        <div class="title"><?= $week_blog['title'] ?></div>
                                        <div class="desc"><?= $week_blog['description'] ?></div>
                                        <div class="details">
                                            <div class="view">Views: <?= $week_blog['view_count'] ?></div>
                                            <div class="date">Created: <?= $week_blog['created_at'] ?></div>
                                            <div class="date">Updated: <?= $week_blog['updated_at'] ?></div>
                                        </div>
                                        <div class="details">
                                            <div class="author">Author: <?= $week_blog['name'] . " " . $week_blog['surname']  ?></div>
                                            <div class="category">Category: <?= $week_blog['category_name'] ?></div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <br>
                    <br>
                    <h2>Bu ay elave edilen bloglar</h2>
                    <h3>Sayi: <?= isset($month_blogs[0]['count']) ? $month_blogs[0]['count'] : 0  ?></h3>
                    <div class="blogs">
                        <?php
                        if (!empty($month_blogs)) {
                            foreach ($month_blogs as $month_blog) {
                        ?>
                                <div class="blog">
                                    <div class="img">
                                        <img src="/backend_project1/public/<?= $month_blog['profile'] ?>" alt="Profile">
                                    </div>
                                    <div class="info">
                                        <div class="title"><?= $month_blog['title'] ?></div>
                                        <div class="desc"><?= $month_blog['description'] ?></div>
                                        <div class="details">
                                            <div class="view">Views: <?= $month_blog['view_count'] ?></div>
                                            <div class="date">Created: <?= $month_blog['created_at'] ?></div>
                                            <div class="date">Updated: <?= $month_blog['updated_at'] ?></div>
                                        </div>
                                        <div class="details">
                                            <div class="author">Author: <?= $month_blog['name'] . " " . $month_blog['surname']  ?></div>
                                            <div class="category">Category: <?= $month_blog['category_name'] ?></div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>