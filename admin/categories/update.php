<?php
include_once "../../index.php";
$id=$_GET['id'];
$sql="SELECT * FROM catigories WHERE id=?";
$categoryQuery=$connection->prepare($sql);
$categoryQuery->execute([$id]);
$category=$categoryQuery->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD']=="POST"){
    $sql="UPDATE catigories SET name=? WHERE id=?";
    $updateQuery=$connection->prepare($sql);
    $updateQuery->execute([
        post('category'),
        $id
    ]);
    header("Location: select.php");
}


?>

<div class="register">
        <div class="form">
            <span class="title">Edit Categoty</span>
            <form action="" method="post">
                <div class="inp">
                    <label for="cat">Categoty</label>
                    <input type="text" name="category" id="cat" value="<?= $category['name'] ?>" placeholder="Edit your category" />
                </div>
                <button type="submit" class="submit">Save</button>
            </form>
        </div>
    </div>

