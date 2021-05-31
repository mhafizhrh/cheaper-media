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
            <li><a href="deposit.php">Tambah Saldo</a></li>
            <li class="active"><a href="bantuan.php">Bantuan</a></li>
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
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          #1 Cara Beli
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <ol>
        	<li>Pilih Jenis pada Pilihan <b>Jenis.</b></li>
        	<li>Pilih Layanan yang akan kamu pakai untuk membeli kebutuhan Sosial Media.</li>
        	<li>Masukan data di <b>Target/Link</b> yang akan kamu Targetkan.</li>
        	<li>Masukan Jumlah sesuai <b>Keterangan</b> yang ada.</li>
        	<li>Silahkan cek kembali, apa data sudah benar atau belum, jika sudah benar silahkan tekan <b>Submit</b></li>
        </ol>
        <br>
        <br>
        <b>Terimakasih, Hafizh (Developers)</b>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          #2 Cara mengisi Saldo
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <ol>
        	<li>Masuk ke Halaman <b>Tambah Saldo.</b></li>
        	<li>dan di Halaman <b>Tambah Saldo</b> anda akan menemukan Staf kami.</li>
        	<li>Silahkan Kontak kepada Staf untuk mengisi Saldo anda.</li>
        </ol>
        <br>
        <br>
        <b>Terimakasih, Hafizh (Developers).</b>
      </div>
    </div>
  </div>
</div>
<center><h1>Terimakasih, Semoga Membantu ^_^</h1></center>
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
