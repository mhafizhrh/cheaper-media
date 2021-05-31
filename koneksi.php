<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "cheaper-media";
mysql_connect($host, $user, $pass) or die("Gagal Koneksi Ke Mysql : ".mysql_error());
mysql_select_db($db);
?>