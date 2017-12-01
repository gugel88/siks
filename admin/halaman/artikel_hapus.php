<?php
include '../../konfigurasi/konfigurasi.php';
@session_start();
session_name("siks");

$artikel_id  = $_GET['id'];
$ambil_artikel = mysqli_query($koneksi, "SELECT * FROM tbl_artikel WHERE artikel_id='$artikel_id'");
if ($artikel = mysqli_fetch_array($ambil_artikel)) {
	$link_gambar_kc1 = "../../img/artikel/thumb_" . $artikel['artikel_img'];
	$link_gambar_kc2 = "../../img/artikel/thumb/thumb_" . $artikel['artikel_img'];
	unlink($link_gambar_kc1);
	unlink($link_gambar_kc2);

	$komentar_hapus = mysqli_query($koneksi, "DELETE FROM tbl_komentar WHERE artikel_id='$artikel_id'");
	$hapus_artikel = mysqli_query($koneksi, "DELETE FROM tbl_artikel WHERE artikel_id='$artikel_id'"); 
	if ($hapus_artikel){
		if ($_SESSION['status']=='admin') {
			header('location:../index.php?p=artikel');
		} else if ($_SESSION['status']=='guru') {
			header('location:../user/index.php?p=artikel');
		}
	} else {
		echo "<script>alert('Artikel gagal dihapus.')</script>";
		if ($_SESSION['status'] == 'admin') {
			echo "<meta http-equiv='refresh' content='0;url=../index.php?p=artikel'>";
		} else if ($_SESSION['status'] == 'guru') {
			echo "<meta http-equiv='refresh' content='0;url=../user/index.php?p=artikel'>";
		}
	}
}
?>