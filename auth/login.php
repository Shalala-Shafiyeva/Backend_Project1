<?php
include_once "../index.php";
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $errors = validation(['Email', 'Password']);
    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE email=? AND active = ?";
        $query = $connection->prepare($sql);
        $query->execute([post('email'), "1"]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user &&  $user['otp'] !== NULL) {
            $errors['otp'] = "OTP code daxil edilmeyib";
            $_SESSION['otp_email'] = post('email');
            $_SESSION['otp'] = $user['otp'];
            $_SESSION['otp_ttl'] = time() + 300;
        } else if ($user && password_verify(post('password'), $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            // $_SESSION['surname'] = $user['surname'];
            // $_SESSION['email'] = $user['email'];
            // $_SESSION['gender'] = $user['gender'];
            // $_SESSION['profile'] = $user['profile'];
            // $_SESSION['dob'] = $user['dob'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] == 0 && $user['active'] == 1) {
                header("location:/backend_project1/client/index.php");
            } elseif ($user['role'] == 1) {
                header("location:/backend_project1/admin/index.php");
            }
        }else{
            $errors['login'] = "Email or password is incorrect";
        }
    }
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

    <div class="register">
        <div class="form">
            <span class="title">Sign In</span>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="inp">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" />
                    <?php if (isset($errors["email"])) { ?>
                        <span class="error"><?= $errors["email"] ?></span>
                    <?php } ?>
                </div>
                <div class="inp">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" />
                    <?php if (isset($errors["password"])) { ?>
                        <span class="error"><?= $errors["password"] ?></span>
                    <?php } ?>
                </div>
                <?php
                if(isset($errors['login'])){
                    ?>
                    <span class="error"><?= $errors['login'] ?></span>
                    <?php
                }
                if (isset($errors['otp'])) {
                ?>
                    <div class="inp">
                        <a id="resend" style="color: #AE1100 !important; font-size: 18px !important;" href="resend-otp.php">Resend OTP code</a>
                    </div>
                <?php
                }
                ?>
                <button type="submit" class="submit">Sign In</button>
            </form>
        </div>
    </div>


</body>

</html>