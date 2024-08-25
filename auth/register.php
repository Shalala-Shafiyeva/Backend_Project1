<?php
include_once "../index.php";

use PHPMailer\PHPMailer\PHPMailer;

require "../vendor/PHPMailer/src/Exception.php";
require "../vendor/PHPMailer/src/PHPMailer.php";
require "../vendor/PHPMailer/src/SMTP.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //date input-un value-su
    if (strtotime($_POST['date'])) {
        $new_date = date('Y-m-d', strtotime($_POST['date']));
    }
    $errors = validation(['Name', "Surname", "Email", 'Password', "password_confirm", "Gender", "Date of Birth"]);
    
    
    //CHECK DOES WE HAVE SUCH USER EMAIL(CAUSE THEY ARE UNIQUE)
    $sql = "SELECT email FROM users WHERE email=?";
    $query = $connection->prepare($sql);
    $query->execute([post('email')]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $errors['email'] = "Email aleary existes";
    }

    
    $fileName = fileUpload("../public/", $_FILES['image']);
    if (empty($errors)) {
        if (post('password') !== post('password_confirm')) {
            $errors['password_confirm'] = 'Password and password confirmation do not match';
        } else {
            $otp = rand(1000, 9999);
            $otp_email = post('email');
            $otp_ttl = time() + 300;
            $passwordHash = password_hash(post('password'), PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, surname, gender, dob, profile, email, password, otp)
                    VALUE (?, ?, ?, ?, ?, ?, ?, ?)";
            $insertQuery = $connection->prepare($sql);
            $check = $insertQuery->execute([
                post('name'),
                post('surname'),
                intval(post('gender')),
                $new_date,
                $fileName ? "public/" . $fileName : "public/userImage.jpeg",
                post('email'),
                $passwordHash,
                $otp
            ]);
            if ($check) {
                $_SESSION['otp'] = $otp;
                $_SESSION['email'] = $otp_email;
                $_SESSION['otp_ttl'] = $otp_ttl;
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = "suleymanov.emin2001@gmail.com";
                    $mail->Password = "rocu lkku qbfk ygkf";
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $mail->setFrom("suleymanov.emin2001@gmail.com", "Coders Caravan");
                    $mail->addAddress("shalala.shafiyeva23@gmail.com");
                    $mail->isHTML(true);
                    $mail->Subject = "Coders Caravan OTP Code";
                    $mail->Body = "Your OTP is: " . $otp;
                    $mail->send();

                    header("Location:otp.php");
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
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
            <span class="title">Sign Up</span>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="inp">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your name" />
                    <?php if (isset($errors["name"])) { ?>
                        <span class="error"><?= $errors["name"] ?></span>
                    <?php } ?>
                </div>
                <div class="inp">
                    <label for="surname">Surname</label>
                    <input type="text" name="surname" id="surname" placeholder="Enter your surname" />
                    <?php if (isset($errors["surname"])) { ?>
                        <span class="error"><?= $errors["surname"] ?></span>
                    <?php } ?>
                </div>
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
                <div class="inp">
                    <label for="password_confirm">Password Confirmation</label>
                    <input type="password" name="password_confirm" id="password_confirm" placeholder="Enter your password" />
                    <?php if (isset($errors["password_confirm"])) {
                        $errors['password_confirm'] = "Password confirmation is required" ?>
                        <span class="error"><?= $errors["password_confirm"] ?></span>
                    <?php } ?>
                </div>
                <div class="inp">
                    <label for="image">Profile Image</label>
                    <input type="file" name="image" id="image" />
                </div>
                <div class="inp">
                    <span>Gender</span>
                    <div class="genderBtns">
                        <div class="inp">
                            <input type="radio" name="gender" value="1" id="male" />
                            <label for="male">Male</label>
                        </div>
                        <div class="inp">
                            <input type="radio" name="gender" value="0" id="female" />
                            <label for="female">Female</label>
                        </div>
                    </div>
                    <?php if (isset($errors["gender"])) { ?>
                        <span class="error"><?= $errors["gender"] ?></span>
                    <?php } ?>
                </div>
                <div class="inp">
                    <label for="date">Date of Birth</label>
                    <input type="date" name="date" id="date" />
                    <?php if (isset($errors["date of birth"])) { ?>
                        <span class="error"><?= $errors["date of birth"] ?></span>
                    <?php } ?>
                </div>
                <button type="submit" class="submit">Sign Up</button>
            </form>
        </div>
    </div>


</body>

</html>