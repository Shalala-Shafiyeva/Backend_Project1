<?php
include_once "../index.php";

use PHPMailer\PHPMailer\PHPMailer;

require "../vendor/PHPMailer/src/Exception.php";
require "../vendor/PHPMailer/src/PHPMailer.php";
require "../vendor/PHPMailer/src/SMTP.php";

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validation(["email"]);
    if (empty($erros)) {
        $email = post('email');
        $otp = rand(1000, 9999);
        $otp_email = post('email');
        $otp_ttl = time() + 300;
        $sql = "SELECT * FROM users WHERE email = ?";
        $resendQuery = $connection->prepare($sql);
        $resendQuery->execute([$email]);
        $user = $resendQuery->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $sql = "UPDATE users SET otp = ? WHERE email = ?";
            $updateQuery = $connection->prepare($sql);
            $check = $updateQuery->execute([$otp, $email]);
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
        } else {
            $errors['email'] = "Email not found";
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
            <span class="title">Resend OTP</span>
            <form action="" method="post">
                <div class="inp">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" />
                    <?php if (isset($errors["email"])) { ?>
                        <span class="error"><?= $errors["email"] ?></span>
                    <?php } ?>
                </div>
                <button type="submit" class="submit">Resend</button>
            </form>
        </div>
    </div>


</body>

</html>