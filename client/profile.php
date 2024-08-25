<?php
include "../index.php";
if (isset($_SESSION['role']) && !$_SESSION['role']) {
    // $name = $_SESSION['name'];
    // $surname = $_SESSION['surname'];
    // $email = $_SESSION['email'];
    // $gender = $_SESSION['gender'] ? "Male" : "Female";
    // $dob = $_SESSION['dob'];
    // $profile = !empty($_SESSION['profile']) ? '/backend_project1/' . $_SESSION['profile'] : "/backend_project1/public/userImage.jpeg";
    $sql = "SELECT * FROM users WHERE id=?";
    $userQuery = $connection->prepare($sql);
    $userQuery->execute([$_SESSION['user_id']]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);
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
    <section class="profile">
        <div class="cover">
            <div class="clientInfo">
                <div class="head">
                    <div class="profile">
                        <img src="<?= '/backend_project1/' . $user['profile'] ?>" alt="Profile">
                    </div>
                    <div class="fullName"><?= $user['name'] . " " . $user['surname'] ?></div>
                    <div class="dob"><?= $user['dob'] ?></div>
                </div>
                <div class="middle">
                    <div class="box">
                        <span>Melumatlarim</span>
                    </div>
                    <div class="box">
                        <div class="boxItem">
                            <span>Email</span>
                            <span class="email"><?= $user['email'] ?></span>
                        </div>
                        <div class="boxItem">
                            <span>Gender</span>
                            <span class="gender"><?= $user['gender'] ? "Male" : "Female" ?></span>
                        </div>
                    </div>
                </div>
                <div class="btn">
                    <a href="editInfo.php">Edit</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>