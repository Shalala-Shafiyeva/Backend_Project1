<?php
include_once "../index.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['user_id'];
    $sql = "UPDATE users SET name = ?, surname = ?, gender = ?, dob = ?, profile = ?, updated_at = ? WHERE id=?";
    $updateQuery = $connection->prepare($sql);
    //string-i date ceviririk ki post vasitesiyle sorguyla oturek
    if (strtotime($_POST['date'])) {
        $new_date = date('Y-m-d', strtotime($_POST['date']));
    }
    //profile img i yoxlayiriq ki istifadece oz seklini deyisdi ya yox
    $fileName = fileUpload("../public/", $_FILES['image']);
    $checked = $updateQuery->execute([
        post('name'),
        post('surname'),
        post('gender'),
        $new_date,   
        $fileName ? "public/" . $fileName : $user['profile'],
        date('Y-m-d H:i:s'),
        $id
    ]);
    if ($checked) {
        header('location:/backend_project1/client/profile.php');
    }
}
$query = "SELECT * FROM users WHERE id=?";
$userQuery = $connection->prepare($query);
$userQuery->execute([$_SESSION['user_id']]);
$user = $userQuery->fetch(PDO::FETCH_ASSOC);
?>

<div class="register">
    <div class="form">
        <span class="title">Edit My Info</span>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="inp">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter new name" value="<?= $user['name'] ?>" />
            </div>
            <div class="inp">
                <label for="surname">Surname</label>
                <input type="text" name="surname" id="surname" placeholder="Enter new surname" value="<?= $user['surname'] ?>" />
            </div>
            <!-- <div class="inp">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter new password" />
            </div> -->
            <div class="inp">
                <label for="image">Profile Image</label>
                <input type="file" name="image" id="image" />
                <input type="hidden" name="old_image" value="<?= $user['profile'] ?>">
            </div>
            <div class="inp">
                <span>Gender</span>
                <div class="genderBtns">
                    <div class="inp">
                        <input type="radio" name="gender" value="1" id="male" <?= $user['gender'] == 1 ? "checked" : "" ?> />
                        <label for="male">Male</label>
                    </div>
                    <div class="inp">
                        <input type="radio" name="gender" value="0" id="female" <?= $user['gender'] == 0 ? "checked" : "" ?> />
                        <label for="female">Female</label>
                    </div>
                </div>
            </div>
            <div class="inp">
                <label for="date">Date of Birth</label>
                <input type="date" name="date" id="date" value="<?= $user['dob'] ?>" />
            </div>
            <button type="submit" class="submit">Update</button>
        </form>
    </div>
</div>