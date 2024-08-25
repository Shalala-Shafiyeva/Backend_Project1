<?php
include_once "../index.php";
$errors=[];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = validation(["OTP"]);
    if (empty($errors)) {
        $otp = post("otp");
        $otp_ttl=$_SESSION['otp_ttl'];
        $user_email=$_SESSION['email'];
        if(time()<=$otp_ttl){
            if ($otp == $_SESSION["otp"]) {
                $sql = "UPDATE users SET otp=null WHERE email = ?";
                $updateQuery = $connection->prepare($sql);
                $check = $updateQuery->execute([$_SESSION['email']]);
                if ($check) {
                    $_SESSION = [];
                    header("location:login.php");
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
            <span class="title">OTP CODE</span>
            <form action="" method="post">
                <div class="inp">
                    <label for="otp">OTP code</label>
                    <input type="number" name="otp" id="otp" placeholder="Enter your OTP code" />
                    <?php if (isset($errors["otp"])) { ?>
                        <span class="error"><?= $errors["otp"] ?></span>
                    <?php } ?>
                </div>
                <button type="submit" class="submit">Submit</button>
            </form>
        </div>
    </div>


</body>

</html>