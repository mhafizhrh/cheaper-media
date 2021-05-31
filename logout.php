<?php
session_start();
require_once 'koneksi.php';
$username = $_SESSION['username'];
mysql_query("UPDATE users SET ip = '-' WHERE username = '$username'");
unset($_SESSION['username']);
header('location:login.php');
?>