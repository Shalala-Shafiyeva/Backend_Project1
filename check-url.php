<?php

$urlsWithoutRequiredAuth = [
    '/backend_project1/auth/login.php',
    '/backend_project1/auth/register.php',
    '/backend_project1/auth/otp.php',
    "/backend_project1/auth/resend-otp.php"
];

if (isset($_SESSION['user_id']) && in_array($_SERVER['REQUEST_URI'], $urlsWithoutRequiredAuth)) {
    header("location:/backend_project1/index.php");
} elseif (!isset($_SESSION['user_id']) && !in_array($_SERVER["REQUEST_URI"], $urlsWithoutRequiredAuth)) {
    header("location:/backend_project1/auth/login.php");
}


$admiURI = [
    '/backend_project1/admin/index.php',
    '/backend_project1/admin/users/index.php',
    '/backend_project1/admin/statistics/index.php',
    '/backend_project1/admin/categories/select.php',
    '/backend_project1/admin/blogs/index.php',
];

if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role'] == 1) {
        if (!in_array($_SERVER['REQUEST_URI'], $admiURI)) {
            header("location:/backend_project1/admin/index.php");
        }
    }

    if ($_SESSION['role'] == 0) {
        if (in_array($_SERVER['REQUEST_URI'], $admiURI)) {
            header("location:/backend_project1/client/index.php");
        }
    }
} 
//else {
    //login olmayib
   // header('location:/backend_project1/auth/login.php');
//}



