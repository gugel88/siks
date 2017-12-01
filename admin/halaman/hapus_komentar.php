<?php
include '../../konfigurasi/konfigurasi.php';
@session_start();
session_name("siks");
$komentar_id = base64_decode($_GET['id']);

$komentar_hapus = mysqli_query($koneksi, "DELETE FROM tbl_komentar WHERE komentar_id='$komentar_id'");
if ($komentar_hapus){
	if ($_SESSION['status']=='admin') {
		header('location:../index.php?p=komentar');
	} else if ($_SESSION['status']=='guru') {
		header('location:../user/index.php?p=komentar');
	}
} else {
	echo "<script>alert('komentar gagal dihapus.')</script>";
	if ($_SESSION['status'] == 'admin') {
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=komentar'>";
	} else if ($_SESSION['status'] == 'guru') {
		echo "<meta http-equiv='refresh' content='0;url=../user/index.php?p=komentar'>";
	}
}
?>