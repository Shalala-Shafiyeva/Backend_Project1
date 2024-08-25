<?php
include_once "../../adminIndex.php";
if ($_SESSION['role'] == 1) {
    $sql = "SELECT * FROM users WHERE role =?";
    $userQuery = $connection->prepare($sql);
    $userQuery->execute(["0"]);
    $users = $userQuery->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM users WHERE active =? AND role = ?";
    $userQuery = $connection->prepare($sql);
    $userQuery->execute(["1", "0"]);
    $activeUsers = $userQuery->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM users WHERE active =? AND role = ?";
    $userQuery = $connection->prepare($sql);
    $userQuery->execute(["0", "0"]);
    $deactiveUsers = $userQuery->fetchAll(PDO::FETCH_ASSOC);
}
?>

<section class="adminPanel">
    <?php include_once "../dashboard.php" ?>
    <div class="content">
        <?php include_once "../topBar.php" ?>
        <div class="main">
            <div class="cover">
                <div class="allUsers">
                    <span>All Users</span>
                    <?php
                    if (empty($users)) {
                        echo "<span class='empty'>No Users</span>";
                    } else {
                    ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>DoB</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Statis</th>
                                    <th>Profile</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= $user['name'] ?></td>
                                        <td><?= $user['surname'] ?></td>
                                        <td><?= $user['dob'] ?></td>
                                        <td><?= $user['gender'] ? "Male" : "Female" ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td>
                                            <div>
                                                <span>
                                                    <?= $user['active'] ?>
                                                </span>
                                                <a href="activate.php?id=<?= $user['id'] ?>" class="activateBtn">
                                                    <img src="/backend_project1/public/activatebtn.svg" alt="Activate Btn">
                                                </a>
                                            </div>
                                        </td>
                                        <td><?= $user['profile'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
                <div class="someUsers">
                    <div class="activeUsers">
                        <span>Active Users</span>
                        <?php
                        if (empty($activeUsers)) {
                            echo "<span class='empty'>No Active Users</span>";
                        } else {
                        ?>
                            <table>
                                <thead>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Surname</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <?php foreach ($activeUsers as $activeUser) : ?>
                                        <tr>
                                            <td><?= $activeUser['name'] ?></td>
                                            <td><?= $activeUser['surname'] ?></td>
                                            <td><?= $activeUser['email'] ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                </thead>
                            </table><?php } ?>
                    </div>
                    <div class="deactiveUsers">
                        <span>Deactive Users</span>
                        <?php
                        if (empty($deactiveUsers)) {
                            echo "<span class='empty'>No Deactive Users</span>";
                        } else {
                        ?>
                            <table>
                                <thead>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Surname</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <?php foreach ($deactiveUsers as $activeUser) : ?>
                                        <tr>
                                            <td><?= $activeUser['name'] ?></td>
                                            <td><?= $activeUser['surname'] ?></td>
                                            <td><?= $activeUser['email'] ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                </thead>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>