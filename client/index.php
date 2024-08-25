<?php
include_once "../index.php";
$user = $_SESSION;

//PAGINATION
$start = 0;
$blogsPerPage = 3;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

//COUNT OF PAGES
$sql = "SELECT id FROM blogs
      WHERE blogs.is_publish = 1";
$blogsQuery = $connection->prepare($sql);
$blogsQuery->execute([]);
$totalBlogs = $blogsQuery->fetchAll(PDO::FETCH_ASSOC);
$totalPages = ceil(count($totalBlogs) / $blogsPerPage);

//С какого блока начнет показывать на какой-либо странице
//First page / Last page BTNS
if (isset($_GET['page'])) {
    $start = intval($_GET['page']) * $blogsPerPage - $blogsPerPage;
}



//JOIN TABLES FOR BLOG CONTENT
$sql = "SELECT blogs.*, users.name AS author_name, users.surname AS author_surname, catigories.name AS category_name FROM blogs
      LEFT JOIN users ON users.id = blogs.user_id
      LEFT JOIN catigories ON catigories.id = blogs.category_id
      WHERE blogs.is_publish = 1
      LIMIT $start, $blogsPerPage";
$blogsQuery = $connection->prepare($sql);
$blogsQuery->execute([]);
$blogs = $blogsQuery->fetchAll(PDO::FETCH_ASSOC);

//SELECT TOP 5 BLOGS(baxis sayina gore)
$query = "SELECT blogs.*, catigories.name AS category_name FROM blogs
      LEFT JOIN users ON users.id = blogs.user_id
      LEFT JOIN catigories ON catigories.id = blogs.category_id
      ORDER BY view_count DESC
      LIMIT 5
      ";
$blogsQuery = $connection->prepare($query);
$blogsQuery->execute([]);
$topBlogs = $blogsQuery->fetchAll(PDO::FETCH_ASSOC);


//SELECT LAST 5 BLOGS(baxis sayina gore)
$lastQuery = "SELECT blogs.*, catigories.name AS category_name 
              FROM blogs
      LEFT JOIN users ON users.id = blogs.user_id
      LEFT JOIN catigories ON catigories.id = blogs.category_id
      ORDER BY view_count ASC
      LIMIT 5
      ";
$lastBlogsQuery = $connection->prepare($lastQuery);
$lastBlogsQuery->execute([]);
$lastBlogs = $lastBlogsQuery->fetchAll(PDO::FETCH_ASSOC);

//SELECT CATEGORIES FOR SELECT OPTION
$sql = "SELECT id, name FROM catigories";
$categoryQuery = $connection->prepare($sql);
$categoryQuery->execute([]);
$categies = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);
$is_filtered = false;
//FILTERING
$url = "/backend_project1/client/index.php";
$filteredBlogs = [];
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $title = htmlspecialchars(!empty($_GET['title']) ? $_GET['title'] : '');
    $description = htmlspecialchars(!empty($_GET['description']) ? $_GET['description'] : '');
    $author = htmlspecialchars(!empty($_GET['author']) ? $_GET['author'] : '');
    $category = htmlspecialchars(!empty($_GET['category']) ? $_GET['category'] : '');

    if (!empty($title) || !empty($description) || !empty($author) || !empty($category)) {
        $sql = "SELECT blogs.*, 
        users.name AS author_name, 
        users.surname AS author_surname, 
        catigories.name AS category_name 
        FROM blogs 
        LEFT JOIN users ON users.id = blogs.user_id
        LEFT JOIN catigories ON catigories.id = blogs.category_id
        WHERE blogs.is_publish=1
        ";
        if (!empty($title)) {
            $sql .= " AND blogs.title LIKE '%$title%' ";
        }
        if (!empty($description)) {
            $sql .= "AND blogs.description LIKE '%$description%' ";
        }
        if (!empty($author)) {
            $sql .= "AND users.name LIKE '%$author%'";
        }
        if (!empty($category)) {
            $sql .= "AND blogs.category_id = $category ";
        }
        $filterQuery = $connection->prepare($sql);
        $filterQuery->execute([]);
        $filteredBlogs = $filterQuery->fetchAll(PDO::FETCH_ASSOC);
        $is_filtered = true;
    }
}
$showBlogs = [];
if (empty($filteredBlogs) && !$is_filtered) {
    $showBlogs = $blogs;
    //print_r($filteredBlogs);
} elseif (!empty($filteredBlogs)) {
    $showBlogs = $filteredBlogs;
    // print_r($filteredBlogs);
} else if (empty($filteredBlogs) && $is_filtered) {
    $showBlogs = $filteredBlogs;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <section class="client">
        <div class="greeting">
            <h2>Hi, <?= $user['name'] ?></h2>
            <h2>All Blogs</h2>
            <div class="searchBar">
                <form id="form" action="" method='get'>
                    <div class="titleSearch">
                        <label for="title">Search by Title</label>
                        <div class="inp">
                            <input type="text" name="title" value="<?= isset($_GET['title']) ? $_GET['title'] : '' ?>" id="title" placeholder="Search by title" />
                        </div>
                    </div>
                    <div class="descSearch">
                        <label for="desc">Search by Description</label>
                        <div class="inp">
                            <input type="text" name="description" value="<?= isset($_GET['description']) ? $_GET['description'] : '' ?>" id="desc" placeholder="Search by description" />
                        </div>
                    </div>
                    <div class="authorSearch">
                        <label for="author">Search by Author</label>
                        <div class="inp">
                            <input type="text" name="author" value="<?= isset($_GET['author']) ? $_GET['author'] : '' ?>" id="author" placeholder="Search by author" />
                        </div>
                    </div>
                    <div class="categorySearch">
                        <label for="cat">Search by Category</label>
                        <div class="inp">
                            <select name="category" id="cat">
                                <option value="">All</option>
                                <?php
                                foreach ($categies as $category) {
                                ?>
                                    <option value="<?= $category['id'] ?>" <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button id="submit" type="submit">
                        <img src="/backend_project1/public/search.svg" alt="Search">
                    </button>
                </form>
            </div>
            <div class="wrapperBlogs">
                <div class="blogs">
                    <?php
                    if (!empty($showBlogs)) {
                        foreach ($showBlogs as $blog) {
                    ?>
                            <div class="blog">
                                <div class="img">
                                    <img src="/backend_project1/public/<?= $blog['profile'] ?>" alt="Poster">
                                </div>
                                <div class="blogInfo">
                                    <span class="title"><?= $blog['title'] ?></span>
                                    <p class="blogDesc"><?= $blog['description'] ?></p>
                                    <span class="category"><?= $blog['category_name'] ?></span>
                                    <span class="author"><?= $blog['author_name'] . " " . $blog['author_surname'] ?></span>
                                    <div class="bottom">
                                        <span class="date"><?= $blog['updated_at'] ?></span>
                                        <span class="views"><?= $blog['view_count'] ?> reviews</span>
                                    </div>
                                    <a href="/backend_project1/client/blog/detailPage.php?id=<?= $blog['id'] ?>" class="moreDetails">
                                        <span>Read More</span>
                                        <img src="/backend_project1/public/arrow.svg" alt="Read More">
                                    </a>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<h2>There is no blogs</h2>";
                    }
                    ?>
                </div>
                <div class="rightBar">
                    <div class="topBlogs">
                        <span>Top 5 Blogs</span>
                        <div class="littleBlogs">
                            <?php
                            foreach ($topBlogs as $topBlog) {
                                if ($topBlog['is_publish'] == 1) {
                            ?>
                                    <div class="littleBlog">
                                        <div class="img">
                                            <img src="/backend_project1/public/<?= $topBlog['profile'] ?>" alt="">
                                        </div>
                                        <span class="title"><?= $topBlog['title'] ?></span>
                                        <span class="category">Category: <?= $topBlog['category_name'] ?></span>
                                        <span class="views">Views <?= $topBlog['view_count'] ?></span>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="lastBlogs">
                        <span>Last 5 Blogs</span>
                        <div class="littleBlogs">
                            <?php
                            foreach ($lastBlogs as $lastBlog) {
                                if ($lastBlog['is_publish'] == 1) {

                            ?>
                                    <div class="littleBlog">
                                        <div class="img">
                                            <img src="/backend_project1/public/<?= $lastBlog['profile'] ?>" alt="">
                                        </div>
                                        <span class="title"><?= $lastBlog['title'] ?></span>
                                        <span class="category">Category: <?= $lastBlog['category_name'] ?></span>
                                        <span class="views">Views <?= $lastBlog['view_count'] ?></span>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination">
                <div class="paginationBtns">
                    <div class="mainBtns">
                        <a href="?page=1" class="firstPage">First Page</a>
                        <?php
                        if (isset($_GET['page']) && $_GET['page'] > 1) { ?>
                            <a href="?page=<?= $_GET['page'] - 1 ?>" class="prevBtn">Previous</a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="smallBtns">
                        <?php
                        for ($i = 0; $i < $totalPages; $i++) { ?>
                            <a href="?page=<?= $i + 1 ?>" class="page <?= $i + 1 == $currentPage ? 'active' : '' ?>"><?= $i+1?></a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="mainBtns">
                        <?php
                        if (isset($_GET['page']) && $_GET['page'] < $totalPages) { ?>
                            <a href="?page=<?= $_GET['page'] + 1 ?>" class="nextBtn">Next</a>
                        <?php
                        }
                        ?>
                        <a href="?page=<?= $totalPages ?>" class="lastPage">Last Page</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>