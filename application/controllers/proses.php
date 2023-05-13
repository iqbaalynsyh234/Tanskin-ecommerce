<?php
include "koneksi.php";
include "phpqrcode/qrlib.php";
$folderTemp = 'gbrqrcode/';
$a = $_POST['vou_code'];
$b = $_POST['Disc'];
$c = $a;
$d = $a."png";
$qual = 'H';
$ukuran = 6;
$padding = 0;
QRCode::png($c,$folderTemp.$d,$qual,$ukuran,$padding);
$sql = $conn->query("INSERT INTO voucher VALUES('$a','$b','$d')");
if($sql){
    header('location:list.php');
}else{
    echo"Gagal";
    die($conn->error);
}
?>