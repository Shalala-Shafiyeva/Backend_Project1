<?php
$sql="SELECT profile FROM users WHERE id=?";
$userQuery=$connection->prepare($sql);
$userQuery->execute([$_SESSION['user_id']]);
$user = $userQuery->fetch(PDO::FETCH_ASSOC);
?>

<div class="topBar">
    <div class="toggle">
        <img src="/backend_project1/public/menu.svg" alt="Toggle Btn">
    </div>
    <div class="profile">
        <a href="#">
            <img src="/backend_project1/<?= $user['profile'] ?>" alt="Profile">
        </a>
    </div>
</div>