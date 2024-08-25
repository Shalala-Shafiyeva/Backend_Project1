<?php
include_once "../../index.php";
$sqlCategory = "SELECT id, name FROM catigories";
$categoryQuery = $connection->prepare($sqlCategory);
$categoryQuery->execute([]);
$categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT blogs.id, blogs.title, blogs.description, blogs.category_id, blogs.profile, catigories.name AS category_name FROM blogs
      LEFT JOIN catigories ON catigories.id = blogs.category_id
      WHERE blogs.id = ?";
$selectQuery = $connection->prepare($sql);
$selectQuery->execute([$_GET['id']]);
$blog = $selectQuery->fetch(PDO::FETCH_ASSOC);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = validation(['Category']);
    $fileName =  $_POST['old_image'];
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $fileName = fileUpload("../../public/", $_FILES['image']);
    } 
    if (empty($errors)) {
        $id = $_POST['id'];

       
        $sql = "UPDATE blogs SET title=?, description=?, category_id=?, profile=?, is_publish=?, updated_at=?  WHERE id=?";
        $updateQuery = $connection->prepare($sql);
        $check = $updateQuery->execute([
            htmlspecialchars(post('title')),
            htmlspecialchars(post('description')),
            htmlspecialchars(post('category')),
            htmlspecialchars($fileName),
            "0",
            date("Y-m-d H:i:s"),
            $id
        ]);
        if ($check) {
            header("Location: select.php");
        }
    }
}

?>

<div class="register">
    <div class="form">
        <span class="title">Edit Your Blog</span>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $blog['id'] ?>">
            <div class="inp">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?= $blog['title'] ?>" placeholder="Enter blog title" />
            </div>
            <div class="inp">
                <label for="description">Description</label>
                <textarea name="description" id="description"><?= $blog['description'] ?></textarea>
            </div>
            <div class="inp">
                <label for="category">Category</label>
                <select name="category" id="category">
                    <option value="">Choose category</option>
                    <?php
                    foreach ($categories as $category) {
                    ?>
                        <option <?php if ($blog['category_id'] == $category['id']) { ?> selected <?php } ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php if (isset($errors["category"])) { ?>
                    <span class="error"><?= $errors["category"] ?></span>
                <?php } ?>
            </div>
            <div class="inp">
                <div>
                    <h3>Old Image</h3>
                    <input type="hidden" name="old_image" value="<?= $blog['profile'] ?>" />
                    <img src="/backend_project1/public/<?= $blog['profile'] ?>" alt="Old Image">
                </div>
                <label for="image">Blog Image</label>
                <input type="file" name="image" id="image" />
            </div>
            <button type="submit" class="submit">Save</button>
        </form>
    </div>
</div>