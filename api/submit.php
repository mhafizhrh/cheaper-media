<?php
    // REQUEST
    session_start();
    if (!isset($_SESSION['username'])) {
      header('location:index.php');
    } else {
      $username = $_SESSION['username'];
    }
    require_once '../koneksi.php';
    // Select From table users
    $select = mysql_query("SELECT * FROM users WHERE username = '$username'");
    $data = mysql_fetch_array($select);

    // Data Users
    $nama = $data['nama'];
    $password = $data['password'];
    $level = $data['level'];
    $saldo = $data['saldo'];
    $ip = $data['ip'];

    require_once 'curl.php';
    $api = new Api();  

    $layanan = $_POST['layanan'];
    $target = $_POST['target'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];


/*

    Examples

   $api = new Api();

   $order = $api->order('https://www.instagram.com/xxx_xxx_xxx/', '1', '100'); // $link, $type - service type, $quantity: return order id or Error
   
   $status = $api->status($order->data->order_id);

*/

// Daftar Layanan
if ($layanan == 1) {
  $service = "Instagram Likes S1 [Min = 100] [Max = 4k] (Rp. 2.000/1000 Likes)";
} else if ($layanan == 2) {
  $service = "Instagram Likes S2 [Min = 100] [Max = 15k] (Rp. 2.500/1000 Likes)";
} else if ($layanan == 3) {
  $service = "Instagram Likes S3 [Min = 100] [Max = 8k] (Rp. 3.000/1000 Likes)";
} else if ($layanan == 4) {
  $service = "Instagram Likes S4 [Min = 50] [Max = 25k] (Rp. 5.000/1000 Likes)";
} else if ($layanan == 5) {
  $service = "Instagram Followers S1 [Min = 200] [Max = 15k] (Rp. 11.000/1000 Followers)";
} else if ($layanan == 6) {
  $service = "Instagram Views S1 [Min = 20] [Max = 999k] (Rp. 3.000/1000 Views)";
} else if ($layanan == 7) {
  $service = "Instagram Views S2 (INSTANT - SUPER FAST) [Min = 20] [Max = 999k] (Rp. 5.000/1000 Views)";
} else if ($layanan == 8) {
  $service = "Instagram Story Views UNLIMITED (USERNAME ONLY) [Min = 1k] [Max = 1M] (Rp. 27.000/1000 Views)";
} else if ($layanan == 9) {
  $service = "Instagram Video Live Likes (INSTANT) [Min = 200] [Max = 10k] (Rp. 11.000/1000 Likes)";
} else if ($layanan == 10) {
  $service = "Instagram ALBUM Likes (REAL - INSTANT) [Min = 100] [Max = 4k] (Rp. 3.000/1000 Likes)";
} else if ($layanan == 11) {
  $service = "Instagram Followers HQ S2 [Min = 100] [Max = 20k] (Rp. 33.000/1000 Followers)";
} else if ($layanan == 12) {
  $service = "Instagram Followers S3 (HQ - INSTANT - FAST - NOT GUARANTEED) [Min = 200] [Max = 15k] (Rp. 27.000/1000 Followers)";
} else if ($layanan == 13) {
  $service = "Instagram Followers S4 (HQ - 30 Days Refill) [Min = 200] [Max = 10k] (Rp. 33.000/1000 Followers)";
} else if ($layanan == 14) {
  $service = "Youtube Views (Multiple Of 1000 - REAL - DESKTOP - 60 Days Warranty) [Min = 1k] [Max = 1M] (Rp. 15.000/1000 Views)";
} else if ($layanan == 15) {
  $service = "Youtube Subscribers (INSTANT - 120 Days GUARANTEE) [Min = 100] [Max = 25k] (Rp. 370.000/1000 Subscribers)";
} else if ($layanan == 16) {
  $service = "Facebook Page Likes (REAL - GUARANTEED - 12 HOURS START) [Min = 100] [Max = 15k] (Rp. 27.000/1000 Likes)";
} else if ($layanan == 17) {
  $service = "Facebook Page Likes (REAL - NON DROP - 60 Days AUTO REFILL - INSTANT - SUPER FAST) [Min = 100] [Max = 180k] (Rp. 40.000/1000 Likes)";
} else if ($layanan == 18) {
  $service = "Facebook Followers (INSTANT - 1k/Day - 60 Days Refill) [Min = 100] [Max = 5k] (Rp. 50.000/1000 Followers)";
} else if ($layanan == 19) {
  $service = "Twitter Followers (USERNAME ONLY - EGGS - INSTANT) [Min = 100] [Max = 5M] (Rp. 12.000/1000 Followers)";
} else if ($layanan == 20) {
  $service = "Twitter Followers (USERNAME ONLY - EGGS - REFILL - INSTANT) [Min = 100] [Max = 300k] (Rp. 20.000/1000 Followers)";
} else if ($layanan == 21) {
  $service = "Twitter Likes/Favorites (INSTANT) [Min = 100] [Max = 500k] (Rp. 9.000/1000 Likes)";
} else if ($layanan == 22) {
  $service = "Twitter Retweets (INSTANT) [Min = 100] [Max = 500k] (Rp. 9.000/1000 Retweets)";
} else if ($layanan == 23) {
  $service = "Youtube Likes (INSTANT - SUPER FAST) [Min = 50] [Max = 20k] (Rp. 80.000/1000 Likes)";
} else if ($layanan == 24) {
  $service = "Youtube Dislikes (INSTANT - SUPER FAST) [Min = 50] [Max = 20k] (Rp. 80.000/1000 Dislikes)";
} else if ($layanan == 25) {
  $service = "Youtube Shares S1 (INSTANT) [Min = 100] [Max = 22k] (Rp. 55.000/1000 Shares)";
} else if ($layanan == 26) {
  $service = "Vine Followers [Min = 100] [Max = 50k] (Rp. 23.000/1.000 Followers)";
} else if ($layanan == 27) {
  $service = "Vine Likes [Min = 100] [Max = 50k] (Rp. 23.000/1.000 Likes)";
} else if ($layanan == 30) {
  $service = "Instagram Followers Aktif Indonesia (Manual - FAST) [Min = 100] [Max = 3k] (Rp. 55.000/1000 Followers)";
} else if ($layanan == 31) {
  $service = "Instagram Followers (20K] [USA - INSTANT] [NON DROP - 60 DAYS REFILL] (Rp. 45.000/1000 Followers)";
} else {
  $service = false;
}







   if (!$layanan || !$target || !$jumlah || !$harga) {
     header("location:../order.php?rand=".rand(11111111111111111111,99999999999999999999)."&note=Tolong masukan form dengan teliti, terimakasih.");
   } else {
      $order = $api->order($target, $layanan, $jumlah);
      $statusss = $api->status($order->order_id);
      $order_id = $order->order_id;
      $start = $statusss->start_count;
      $sisa = $statusss->remains;
      $status = $statusss->status;
     if ($order) {
      header("location:../order.php?rand=".rand(11111111111111111111,99999999999999999999)."&note=Pembelian Berhasil, silahkan cek Riwayat.&tipe=success");
      mysql_query("INSERT INTO riwayat (order_id,username,layanan,link,jumlah,jumlah_awal,sisa,harga,status) VALUES ('$order_id','$username','$service','$target','$jumlah','$start','$sisa','$harga','$status')");
      mysql_query("UPDATE users SET saldo = saldo-$harga WHERE username = '$username'");
     } else if ($order->error == "Order not found") {
      header("location:../order.php?rand=".rand(11111111111111111111,99999999999999999999)."&note=Tolong masukan form dengan teliti, terimakasih.&tipe=fail");
     } else if ($order->error == "Low balance") {
       header("location:../order.php?rand=".rand(11111111111111111111,99999999999999999999)."&note=Maaf, Saldo anda kurang.&tipe=fail");
     } else if ($order->error == "Quantity inccorect") {
       header("location:../order.php?rand=".rand(11111111111111111111,99999999999999999999)."&note=Jumlah kurang / terlalu lebih.&tipe=fail");
     } else if ($order->error == "Incorrect request") {
      header("location:../order.php?rand=".rand(11111111111111111111,99999999999999999999)."&note=Tolong masukan form dengan teliti, terimakasih.&tipe=fail");
     }
   }
?>