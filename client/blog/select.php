<?php
include_once "../../index.php";

//PAGINATION
$start = 0;
$blogsPerPage = 3;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$currentBlogs = (intval($currentPage) - 1) * $blogsPerPage;

//COUNT OF PAGES
$sql = "SELECT id,user_id FROM blogs
      WHERE user_id=?";
$blogsQuery = $connection->prepare($sql);
$blogsQuery->execute([$_SESSION['user_id']]);
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
      WHERE blogs.user_id=?
      LIMIT $start, $blogsPerPage";
$blogsQuery = $connection->prepare($sql);
$blogsQuery->execute([$_SESSION['user_id']]);
$blogss = $blogsQuery->fetchAll(PDO::FETCH_ASSOC);

//SELECT CATEGORIES FOR SELECT OPTION
$sql = "SELECT id, name FROM catigories";
$categoryQuery = $connection->prepare($sql);
$categoryQuery->execute([]);
$categies = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);

//$filtered_blogs = [];
// if (isset($_SESSION['filtered_blogs']) && !empty($_SESSION['filtered_blogs'])) {
//     $filtered_blogs = $_SESSION['filtered_blogs'];
// } 
// else {
//     $filtered_blogs = [];
//     $blogss = [];
// }


?>

<section class="clientBlogs">
    <div class="container">
        <span>My Blogs</span>
        <div class="searchBar">
            <div class="addBtn">
                <a href="create.php">Add New Blog</a>
            </div>
            <form id="form" action="filterBy.php" method='post'>
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
                if (!empty($blogss) && (empty($filtered_blogs))) {
                    foreach ($blogss as $blog) {
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
                                    <span class="views"><?= $blog['view_count'] ?></span>
                                </div>
                                <div class="blogBtns">
                                    <a class="edit" href="edit.php?id=<?= $blog['id'] ?>">Edit</a>
                                    <a class="delete" href="delete.php?id=<?= $blog['id'] ?>">Delete</a>
                                </div>
                                <a href="/backend_project1/client/blog/detailPage.php?id=<?= $blog['id'] ?>" class="moreDetails">
                                    <span>Read More</span>
                                    <img src="/backend_project1/public/arrow.svg" alt="Read More">
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                } elseif (isset($filtered_blogs) && !empty($filtered_blogs)) {
                    foreach ($filtered_blogs as $filtered_blog) {
                    ?>
                        <div class="blog">
                            <div class="img">
                                <img src="/backend_project1/public/<?= $filtered_blog['profile'] ?>" alt="Poster">
                            </div>
                            <div class="blogInfo">
                                <span class="title"><?= $filtered_blog['title'] ?></span>
                                <p class="blogDesc"><?= $filtered_blog['description'] ?></p>
                                <span class="category"><?= $filtered_blog['category_name'] ?></span>
                                <span class="author"><?= $filtered_blog['author_name'] . " " . $filtered_blog['author_surname'] ?></span>
                                <div class="bottom">
                                    <span class="date"><?= $filtered_blog['updated_at'] ?></span>
                                    <span class="views"><?= $filtered_blog['view_count'] ?></span>
                                </div>
                                <div class="blogBtns">
                                    <a class="edit" href="edit.php?id=<?= $filtered_blog['id'] ?>">Edit</a>
                                    <a class="delete" href="delete.php?id=<?= $filtered_blog['id'] ?>">Delete</a>
                                </div>
                                <a href="detailPage.php?id=<?= $filtered_blog['id'] ?>" class="moreDetails">
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
                            <a href="?page=<?= $i + 1 ?>" class="page <?= $i + 1 == $currentPage ? 'active' : '' ?>"><?= $i + 1 ?></a>
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
    </div>
</section>