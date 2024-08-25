<?php
#Login var yoxsa yox/ yoxdursa-> auth/login.php
#Daxil ollan userin role un teyini
#role - admindirse admin/index.php
#role - clientdirse client/index.php
session_start();
include_once "check-url.php";
require_once "config/database.php";
include_once "helper/helper.php";
include_once "head.php";
include_once "navbar.php";
