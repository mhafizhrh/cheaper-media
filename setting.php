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
    <link rel="icon" href="assets/images/cm-icon.png">

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
        <div class="col-md-8 col-md-offset-2">
<?php
require_once 'koneksi.php';
if (isset($_POST['ubah'])) {
  $nama = $_POST['nama'];
  $password = $_POST['password'];
  $s = mysql_query("SELECT * FROM users WHERE username = '$username'");
  $d = mysql_fetch_array($s);
  if (!$nama || !$password) {
    echo "<div class='alert alert-danger text-center'>Tolong lengkapi data</div>";
  } else {
    mysql_query("UPDATE users SET nama = '$nama' WHERE username = '$username'");
    mysql_query("UPDATE users SET password = '$password' WHERE username = '$username'");
    echo "<div class='alert alert-success text-center'>Sukses</div>";
  }
}
?>
          <div class="panel panel-info">
          	<div class="panel-heading text-center">
          	  Profil
          	</div>
          	<div class="panel-body">
      			  <form class="form-horizontal" method="post">
        				<div class="form-group">
        				  <label class="col-sm-2 control-label">Nama</label>
        				  <div class="col-sm-10">
        				    <input type="text" name="nama" class="form-control" value="<?=$nama?>" required>
        				  </div>
        				</div>
        				<div class="form-group">
        				  <label class="col-sm-2 control-label">Password</label>
        				  <div class="col-sm-10">
        				    <input type="password" name="password" class="form-control" value="<?=$password?>" required>
        				  </div>
        				</div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
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
