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

// Data Users
$nama = $data['nama'];
$password = $data['password'];
$level = $data['level'];
$saldo = $data['saldo'];
$ip = $data['ip'];
if ($level == "Member") {
  echo "<script>alert('Maaf, anda tidak mempunyai akses untuk masuk kesini');location.assign('index.php');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
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
          <a class="navbar-brand" href="#">Cheaper Media</a>
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
            <li><a href="bantuan.php">Bantuan</a></li>
            <li class="dropdown active">
              <a href="#" data-toggle="dropdown"><b><?=$nama?> <span class="caret"></span></b></a>
              <ul class="dropdown-menu">
                <li class="active"><a href="setting.php"><i class="fa fa-cog"></i> Setting</a></li>
                <li><a href="logout.php"><i class="fa fa-power-off"></i> Keluar</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->


    <!--Modal-->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="saldo">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
          </div>
          <div class="modal-body">
            <div class="input-group">
              <span class="input-group-addon">Rp.</span>
              <input type="number" class="form-control" value="<?=$saldo?>" readonly>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="modal">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
          </div>
          <div class="modal-body">
            <a href="profil.php" class="btn btn-default btn-block"><i class="fa fa-user"></i> Profil</a>
            <a href="pengaturan.php" class="btn btn-info btn-block"><i class="fa fa-cog"></i> Pengaturan</a>
            <a href="bantuan.php" class="btn btn-default btn-block"><i class="fa fa-support"></i> Bantuan</a>
            <a href="keluar.php" class="btn btn-default btn-block"><i class="fa fa-power-off"></i> Keluar</a>
          </div>
        </div>
      </div>
    </div>
    <!--/Modal-->


    <div class="container">

      <div class="row">
        <div class="col-md-4 col-md-offset-4">
<?php
require_once 'koneksi.php';
if (isset($_POST['ubah'])) {
  $nama = $_POST['nama'];
  $password = $_POST['password'];
  $username2 = $_POST['username'];
  $level = $_POST['level'];
  if ($level == "Member") {
    $bonus = 5000;
    $harga = 10000;
  } else if ($level == "Agen") {
    $bonus = 15000;
    $harga = 20000;
  } else if ($level == "Reseller") {
    $bonus = 50000;
    $harga = 60000;
  }
  $cek = mysql_query("SELECT * FROM users WHERE username = '$username2'");
  if (!$nama || !$password || !$username2 || !$level) {
    echo "<div class='alert alert-danger text-center'>Tolong lengkapi data</div>";
  } else if ($saldo < $harga) {
    echo "<div class='alert alert-danger text-center'>Saldo anda kurang</div>";
  } else if (mysql_num_rows($cek) <> 0) {
    echo "<div class='alert alert-danger text-center'>Username sudah ada</div>";
  } else {
    $submit = mysql_query("INSERT INTO users (nama,username,password,level,saldo) VALUES ('$nama','$username2','$password','$level','$bonus')");
    $submit = mysql_query("UPDATE users SET saldo = saldo-$harga WHERE username='$username'");
    if ($submit) { 
      echo "<div class='alert alert-success text-center'>Sukses mendaftarkan ".$level.", dengan bonus saldo ".$bonus."</div>";
    } else {
      echo "Gagal, Hubungi admin.";
    }
  }
}
?>
          <div class="alert alert-info">
            Harga Penjualan Umum : <br>
            -Member + 5000 Saldo = Rp. 15.000 <br>
            -Agen + 15000 Saldo = Rp. 30.000 <br>
            -Reseller + 50000 Saldo = Rp. 75.000 <br>
          </div>
          <div class="panel panel-info">
          	<div class="panel-heading text-center">
          	  Profil
          	</div>
          	<div class="panel-body">
      			  <form method="post">
                <div class="form-group">
                  <label>Nama :</label>
                  <div>
                    <input type="text" name="nama" class="form-control" value="" required>
                  </div>
                </div>
        				<div class="form-group">
        				  <label>Username :</label>
        				  <div>
        				    <input type="text" name="username" class="form-control" value="" required>
        				  </div>
        				</div>
        				<div class="form-group">
        				  <label>Password</label>
        				  <div>
        				    <input type="password" name="password" class="form-control" value="" required>
        				  </div>
        				</div>
                <div class="form-group">
                  <label>Level :</label>
                  <div>
                    <select name="level" class="form-control" required>
                      <option selected disabled>-- Pilih Level --</option>
                      <?php if ($level == "Agen" || $level == "Reseller" || $level == "Admin") { ?><option value="Member">Member + 5000 Saldo (Rp. 10.000)</option><?php } ?>
                      <?php if ($level == "Admin" || $level == "Reseller") { ?><option value="Agen">Agen + 15000 Saldo (Rp. 20.000)</option><?php } ?>
                      <?php if ($level == "Admin") { ?><option value="Reseller">Reseller + 50000 Saldo (Rp. 60.000)</option><?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label></label>
                  <div>
                    <button type="submit" class="btn btn-primary" name="ubah">Tambah</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                  </div>
                </div>
      			  </form>
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
  </body>
</html>
