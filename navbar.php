<?php
//session_start();
include_once "helper/helper.php";
require_once "config/database.php";
$authUser = auth();
$name = $surname = $profileImg = $profileTxt = '';
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $sql = "SELECT * FROM users WHERE id=?";
    $userQuery = $connection->prepare($sql);
    $userQuery->execute([$_SESSION['user_id']]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);
    if ($authUser) {
        $name = $user['name'];
        $surname = $user['surname'];
        $profileImg = $user['profile'];
        if (!$profileImg) {
            $nameFirstLetter = substr($name, 0, 1);
            $surnameFirstLetter = substr($surname, 0, 1);
            $profileTxt = $nameFirstLetter . $surnameFirstLetter;
        }
    }
}
?>

<header>
    <nav>
        <ul>
            <?php if (!$authUser) {
            ?>
                <li>
                    <a href="/backend_project1/auth/login.php">Login</a>
                </li>
                <li>
                    <a href="/backend_project1/auth/register.php">Register</a>
                </li>
            <?php
            }
            if ($authUser) {
            ?>
                <li>
                    <a class="name" href="/backend_project1/client/profile.php">
                        <span class="nameNavbar"><?= $name ?></span>
                        <div class="img">
                            <?php if ($profileImg) {
                            ?>
                                <img src="/backend_project1/<?= $profileImg ?>" alt="Profile Image">
                            <?php
                            } else {
                            ?>
                                <span><?= $profileTxt ?></span>
                            <?php
                            } ?>
                        </div>
                    </a>
                </li>
                <?php if (isset($user['role']) && !$user['role']) {
                ?>
                    <li>
                        <a href="/backend_project1/client/index.php">All Blogs</a>
                    </li>
                    <li>
                        <a href="/backend_project1/client/blog/select.php">My Blogs</a>
                    </li>
                    <li>
                        <a href="/backend_project1/client/profile.php">Profile</a>
                    </li>
                <?php
                }
                //if (isset($user['role']) && $user['role']) {
                ?>
                    <!-- <li>
                        <a href="/backend_project1/admin/categories/select.php">Categories</a>
                    </li> -->
                <?php
                //}
                ?>
                <li>
                    <a href="/backend_project1/auth/logout.php">Logout</a>
                </li>
            <?php
            }
            ?>
        </ul>
    </nav>
</header>