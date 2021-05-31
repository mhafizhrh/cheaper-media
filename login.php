<?php
session_start();
if (!isset($_SESSION['username'])) {
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
    <link rel="icon" href="assets/images/favicon.png">

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
            <li class="active"><a href="login.php">Masuk</a></li>
            <li><a href="daftar-harga.php">Daftar Harga</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="container">

      <div class="row">
        <div class="col-md-5 col-md-offset-3">
<?php
require_once 'koneksi.php';
if (isset($_POST['masuk'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $ip       = $_SERVER['REMOTE_ADDR'];
  $query    = mysql_query("SELECT * FROM users WHERE username = '$username'");
    $rows     = mysql_num_rows($query);
    $array    = mysql_fetch_array($query);
    if (!$username || !$password) {
        echo "<div class='alert alert-danger text-center'>Tolong lengkapi data</div>";
    } else {
        if ($rows == 0) {
            echo "<div class='alert alert-danger text-center'>Username tidak ada</div>";
        } elseif ($password <> $array['password']) {
            echo "<div class='alert alert-danger text-center'>Password salah</div>";
        } else {
            $_SESSION['username'] = $array['username'];
            mysql_query("UPDATE users SET ip = '$ip' WHERE username = '$username'");
            header('location:index.php');
        }
    }
}
?>
          <div class="alert alert-info">Jika anda tidak di arahkan ke Halaman Pembelian baru, silahkan refresh page / <a href="index.php">Klik Disini</a></div>
          <div class="panel panel-info">
            <div class="panel-heading text-center">
              Masuk dengan akun Swift Panel
            </div>
            <div class="panel-body">
              <form method="post">
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Username anda">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password anda">
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block" name="masuk">Masuk</button>
                </div>
                <div class="form-group">
                  Belum punya akun? <a href="https://facebook.com/hafizh.rh">Daftar</a>
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

<?php
} else {
  $username = $_SESSION['username'];
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
            <li class="active"><a href="order.php">Pembelian Baru</a></li>
            <li><a href="riwayat-order.php">Riwayat Pembelian</a></li>
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
        <div class="col-md-8">
<?php
  if (isset($_GET['rand'])) {
    $note = $_GET['note'];
    $tipe = $_GET['tipe'];
    if ($tipe == "fail") {
      echo "<div class='alert alert-danger'>".$note."</div>";
    } else {
      echo "<div class='alert alert-success'>".$note."</div>";
    }
  }
?>
          <div class="alert alert-danger text-center">Orderan <b>Partial / Canceled / Error ?</b> hubungi <a href="https://facebook.com/hafizh.rh" target="_blank">Admin.</a></div>
          <div class="panel panel-info">
            <div class="panel-heading text-center">
              Sosial Media
            </div>
            <div class="panel-body">
              <form action="api/submit.php" method="post">
                <div class="form-group">
                  <label>Jenis :</label>
                  <select class="form-control" id="jenis" required>
                    <option value="pilih" disabled selected>-- Pilih Jenis --</option>
                    <option value="1">Instagram</option>
                    <option value="2">Youtube</option>
                    <option value="3">Facebook</option>
                    <option value="4">Twitter</option>
                    <option value="5">Vine</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Layanan :</label>
                  <select class="form-control" id="layanan" name="layanan" required>
                    <option>Pilih dulu Jenisnya</option>
                  </select>
                </div>
                <div id="keterangan">
                    
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <label>Target/Link :</label>
                    <input type="text" id="target" class="form-control" name="target" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Jumlah :</label>
                    <input type="number" id="jumlah" class="form-control" onkeyup="rate();" name="jumlah" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Harga :</label>
                    <div class="input-group">
                      <span class="input-group-addon">Rp.</span>
                      <textarea class="form-control" rows="1" id="harga" name="harga" readonly required></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block pull-right" required><i class="fa fa-shopping-cart"></i> Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              Detail Akun
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label>Nama :</label>
                <label class="pull-right"><?=$nama?></label>
                <hr>
              </div>
              <div class="form-group">
                <label>Username :</label>
                <label class="pull-right"><?=$username?></label>
                <hr>
              </div>
              <div class="form-group">
                <label>Saldo :</label>
                <label class="pull-right">Rp. <?=$saldo?></label>
                <hr>
              </div>
              <div class="form-group">
                <label>Saldo Terpakai :</label>
                <label class="pull-right">Rp. <?=$saldo_terpakai?></label>
                <hr>
              </div>
              <div class="form-group">
                <label>Total Pembelian :</label>
                <label class="pull-right"><?=$total_pembelian?></label>
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
<?php } ?>