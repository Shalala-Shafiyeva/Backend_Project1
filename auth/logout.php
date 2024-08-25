<?php
include_once "../index.php";
$_SESSION=[];
session_destroy();
header("location:/backend_project1/auth/login.php");