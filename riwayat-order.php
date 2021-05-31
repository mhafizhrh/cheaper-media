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
            <li class="active"><a href="riwayat-order.php">Riwayat Pembelian</a></li>
            <li><a href="deposit.php">Tambah Saldo</a></li>
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
 			<div class="col-md-12" style="overflow-y: scroll;">
 				<table class="table table-bordered table-hover">
 					<thead>
 						<tr>
 							<th>No</th>
 							<th>Order ID</th>
 							<th>Layanan</th>
 							<th>Link</th>
 							<th>Jumlah</th>
 							<th>Jumlah Awal</th>
 							<th>Sisa</th>
 							<th>Harga</th>
 							<th>Status</th>
 						</tr>
 					</thead>
 					<tbody>
 						<?php
 							$select4 = mysql_query("SELECT * FROM riwayat WHERE username = '$username' ORDER BY id DESC");
 							$i = 1;
 							require_once 'api/curl.php';
 							$api = new Api();
 							while ($data4 = mysql_fetch_array($select4)) {
 								if ($api->status($data4['order_id'])->status == "Success") {
 									$status = "<label style='padding:2px 3px;font-size:12px;color:white;background-color:green;'>".$api->status($data4['order_id'])->status."</label>";
 								} else if ($api->status($data4['order_id'])->status == "Pending" || $api->status($data4['order_id'])->status == "Processing") {
 									$status = "<label style='padding:2px 3px;font-size:12px;color:white;background-color:orange'>Pending</label>";
 								} else {
 									$status = "<label style='padding:2px 3px;font-size:12px;color:white;background-color:red;'>".$api->status($data4['order_id'])->status."</label>";
 								}
 								$start = $api->status($data4['order_id'])->start_count;
 								$sisa = $api->status($data4['order_id'])->remains;
 								mysql_query("UPDATE riwayat SET jumlah_awal = '$start' WHERE order_id = '$data4[order_id]'");
 								mysql_query("UPDATE riwayat SET sisa = '$sisa' WHERE order_id = '$data4[order_id]'");
 								echo "
 									<tr>
 										<td>$i</td>
 										<td>$data4[order_id]</td>
 										<td>$data4[layanan]</td>
 										<td>$data4[link]</td>
 										<td>$data4[jumlah]</td>
 										<td>$start</td>
 										<td>$sisa</td>
 										<td>$data4[harga]</td>
 										<td>$status</td>
 									</tr>
 								";
 								$i++;
 							}
 						?>
 					</tbody>
 				</table>;
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
