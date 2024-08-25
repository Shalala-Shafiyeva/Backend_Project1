<?php
include_once "../../adminIndex.php";
$sql = "SELECT * FROM catigories";
$selectQuery = $connection->prepare($sql);
$selectQuery->execute([]);
$categories = $selectQuery->fetchAll(PDO::FETCH_ASSOC);
$categoriesErr = "There is no categories";
?>


<section class="adminPanel">
    <?php include_once "../dashboard.php" ?>
    <div class="content">
        <?php include_once "../topBar.php" ?>
        <div class="main">
            <section class="allCategories">
                <div class="container">
                    <div class="btns">
                        <div class="add">
                            <form action="add.php" method="POST">
                                <input type="text" name="add" placeholder="Enter Category" />
                                <button type="submit">Add New</button>
                            </form>
                        </div>
                        <a href="deleteAll.php">Delete All</a>
                    </div>
                    <ul>
                        <?php
                        if (count($categories)) {
                            foreach ($categories as $category) {
                        ?>
                                <li>
                                    <span><?= $category['id'] . ". " . $category['name'] ?></span>
                                    <div class="editBtns">
                                        <a href="update.php?id=<?= $category['id'] ?>">Edit</a>
                                        <a href="delete.php?id=<?= $category['id'] ?>">Delete</a>
                                    </div>
                                </li>
                            <?php
                            }
                        } else {
                            ?>
                            <h2><?= $categoriesErr ?></h2>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</section>