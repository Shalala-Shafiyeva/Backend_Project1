<?php
include_once "../../adminIndex.php";

//PAGINATION
$start = 0;
$blogsPerPage = 3;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

//total pages
$sql = "SELECT id FROM blogs";
$blogsQuery = $connection->prepare($sql);
$blogsQuery->execute([]);
$totalBlogs = $blogsQuery->fetchAll(PDO::FETCH_ASSOC);
$totalPages = ceil(count($totalBlogs) / $blogsPerPage);

if (isset($_GET['page'])) {
    $start = intval($_GET['page']) * $blogsPerPage - $blogsPerPage;
}

$sql = "SELECT blogs.*, users.name AS author_name, users.surname AS author_surname, catigories.name AS category_name FROM blogs
        LEFT JOIN users ON users.id = blogs.user_id
        LEFT JOIN catigories ON catigories.id = blogs.category_id
        LIMIT $start, $blogsPerPage";
$blogs = $connection->prepare($sql);
$blogs->execute([]);
$blogs = $blogs->fetchAll(PDO::FETCH_ASSOC);


?>

<section class="adminPanel">
    <?php include_once "../dashboard.php" ?>
    <div class="content">
        <?php include_once "../topBar.php" ?>
        <div class="main">
            <div class="allBlogs">
                <span class="title">All Blogs</span>
                <?php if (empty($blogs)) {
                    echo "<span class='empty'>There is no blogs</span>";
                } else {
                ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Created</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($blogs as $blog) : ?>
                                <tr>
                                    <td><?= $blog['title'] ?></td>
                                    <td><?= $blog['description'] ?></td>
                                    <td><img src="/backend_project1/public/<?= $blog['profile'] ?>" alt="Blog Image"></td>
                                    <td><?= $blog['author_name'] . " " . $blog['author_surname'] ?></td>
                                    <td><?= $blog['category_name'] ?></td>
                                    <td>
                                        <?= $blog['is_publish'] ?
                                            "Published" :
                                            "Waiting" ?>
                                        <div class="acceptBtns">
                                            <a href="accept.php?id=<?= $blog['id'] ?>" class="acceptBtn">
                                                <img src="../../public/accept.svg" alt="Accept">
                                            </a>
                                            <a href="cancel.php?id=<?= $blog['id'] ?>" class="acceptBtn">
                                                <img src="../../public/cancel.svg" alt="Cancel">
                                            </a>

                                        </div>
                                    </td>
                                    <td><?= $blog['view_count'] ?></td>
                                    <td><?= $blog['created_at'] ?></td>
                                    <td><?= $blog['updated_at'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php } ?>
                <div class="pagination">
                    <div class="paginationBtns">
                        <div class="mainBtns">
                            <a href="?page=1" class="first">First</a>
                            <?php
                            if (isset($_GET['page']) && $_GET['page'] > 1) {
                            ?>
                                <a href="?page=<?= $_GET['page'] - 1 ?>" class="prev">Previous</a>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="smallBtns">
                            <?php
                            for ($i = 1; $i <= $totalPages; $i++) {
                            ?>
                                <a href="?page=<?= $i ?>" class="page <?= $i==$currentPage? 'active': "" ?>"><?= $i ?></a>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="mainBtns">
                            <?php
                            if (isset($_GET['page']) && $_GET['page'] < $totalPages) {
                            ?>
                                <a href="?page=<?= $_GET['page'] + 1 ?>" class="next">Next</a>
                            <?php
                            }
                            ?>
                            <a href="?page=<?= $totalPages ?>" class="last">Last</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>