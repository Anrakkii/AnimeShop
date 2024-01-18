<?php

define("DB_HOST","localhost");
define("DB_USER","demouser_animeshop");
define("DB_PASS","animeshop");
define("DB_NAME","demouser_animeshop");
define('SITE_ROOT',realpath(dirname(__FILE__)));

// $con = mysqli_connect("localhost","root","","demouser_animeshop");

$con = mysqli_connect("localhost","demouser_animeshop","animeshop", "demouser_animeshop");
mysqli_set_charset($con, 'UTF8');
?>