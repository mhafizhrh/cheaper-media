<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('location:login.php');
} else {
  $username = $_SESSION['username'];
}
require_once 'koneksi.php';
// Select From table users
$select = mysql_query("SELECT * FROM users WHERE username = '$username'");
$data = mysql_fetch_array($select);
$select2 = mysql_query("SELECT * FROM riwayat WHERE username = '$username'");
$select3 = mysql_query("SELECT SUM(harga) AS saldo_terpakai FROM riwayat WHERE username = '$username'");
// Data Users
$nama = $data['nama'];
$password = $data['password'];
$level = $data['level'];
$saldo = $data['saldo'];
$ip = $data['ip'];
$total_pembelian = mysql_num_rows($select2);
$data3 = mysql_fetch_array($select3);
$saldo_terpakai = $data3['saldo_terpakai'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Web Panel SMM termasuk Instagram, Youtube, Facebook, Twitter, dan Vine dengan harga yang murah.">
    <meta name="author" content="Hafizh Rahman">
    <link rel="icon" href="favicon.png">

    <title>Swift Panel</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/offcanvas.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  </head>

  <body>
    <nav class="navbar navbar-fixed-top navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Swift Panel</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" data-toggle="dropdown"><b>Fitur <?=$level?> <span class="caret"></span></b></a>
              <ul class="dropdown-menu">
                <li><a href="register.php">Tambah User
                </a></li>
                <?php if ($level == "Agen" || $level == "Member") { echo false;} else { ?><li><a href="transfer.php">Transfer Saldo</a></li><?php } ?>
              </ul>
            </li>
            <li><a href="order.php">Pembelian Baru</a></li>
            <li><a href="riwayat-order.php">Riwayat Pembelian</a></li>
            <li class="active"><a href="deposit.php">Tambah Saldo</a></li>
            <li><a href="bantuan.php">Bantuan</a></li>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown"><b><?=$nama?> <span class="caret"></span></b></a>
              <ul class="dropdown-menu">
                <li><a href="setting.php"><i class="fa fa-cog"></i> Setting</a></li>
                <li><a href="logout.php"><i class="fa fa-power-off"></i> Keluar</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->


    <div class="container">

      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-info text-center">
            <b>Jika anda mau mengisi Saldo, Anda bisa hubungi kami.</b>
          </div>
        </div>
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              Deposit Saldo
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <center>
                        <img src="https://graph.facebook.com/100005269455914/picture" width="75" class="img-circle">
                        <br>Hafizh Rahman
                        <hr>
                        <p><b>Level :</b> Admin</p>
                        <hr>
                        <p><b>Facebook :</b><a href="https://www.facebook.com/messages/t/100005289455914" target="_blank"> Pesan</a></p>
                        <hr>
                        <p><b>WA :</b> 082133779498</p>
                        <hr>
                        <p><b>Line :</b> <a href="http://line.me/R/ti/p/~mhafizhrh" target="_blankx">Add Friend+</a></p>
                      </center>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="panel panel-default">
                    <div class="panel-body">
                      <center>
                        <img src="https://graph.facebook.com/100005269455914/picture" width="75" class="img-circle">
                        <br>Kosong
                        <hr>
                        <p><b>Level :</b> Admin</p>
                        <hr>
                        <p><b>Facebook :</b><a href="https://www.facebook.com/messages/t/100005289455914" target="_blank"> Pesan</a></p>
                        <hr>
                        <p><b>WA :</b> -</p>
                        <hr>
                        <p><b>Line :</b> <a href="#" target="_blankx">-</a></p>
                      </center>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!--/.container-->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="offcanvas.js"></script>
    <script src="assets/js/order.js"></script>
  </body>
</html>
