<?php
include_once "../../index.php";
$sql = "SELECT id, name FROM catigories";
$categoryQuery = $connection->prepare($sql);
$categoryQuery->execute([]);
$categies = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = validation(["Title", "Description", "Category"]);
    $fileName = fileUpload("../../public/", $_FILES['image']);
    if (!$fileName) {
        $errors['image'] = "Please upload an image";
    }
    if (empty($errors)) {
        $sql = "INSERT INTO blogs(user_id,category_id, title, description, profile) VALUES(?,?,?,?,?)";
        $insertQuery = $connection->prepare($sql);
        $check = $insertQuery->execute([
            $_SESSION['user_id'],
            htmlspecialchars(post('category')),
            htmlspecialchars(post('title')),
            htmlspecialchars(post('description')),
            $fileName
        ]);
        if ($check) {
            header("Location: select.php");
        }
    }
}
?>

<div class="register">
    <div class="form">
        <span class="title">Create Your Blog</span>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="inp">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" placeholder="Enter blog title" />
                <?php if (isset($errors["title"])) { ?>
                    <span class="error"><?= $errors["title"] ?></span>
                <?php } ?>
            </div>
            <div class="inp">
                <label for="description">Description</label>
                <textarea name="description" id="description"></textarea>
                <?php if (isset($errors["description"])) { ?>
                    <span class="error"><?= $errors["description"] ?></span>
                <?php } ?>
            </div>
            <div class="inp">
                <label for="category">Category</label>
                <select name="category" id="category">
                    <option value="">Choose category</option>
                    <?php
                    foreach ($categies as $category) {
                    ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php if (isset($errors["category"])) { ?>
                    <span class="error"><?= $errors["category"] ?></span>
                <?php } ?>
            </div>
            <div class="inp">
                <label for="image">Blog Image</label>
                <input type="file" name="image" id="image" />
                <?php if (isset($errors["image"])) { ?>
                    <span class="error"><?= $errors["image"] ?></span>
                <?php } ?>
            </div>
            <button type="submit" class="submit">Create</button>
        </form>
    </div>
</div>