<?php
include '../../konfigurasi/konfigurasi.php';
@session_start();
session_name("siks");
$berkas_id = base64_decode($_GET['id']);
$ambil_berkas = mysqli_query($koneksi, "SELECT * FROM tbl_berkas WHERE berkas_id='$berkas_id'");
if ($berkas = mysqli_fetch_array($ambil_berkas)) {
	$lokasi = "../../file/" . $berkas['berkas_lokasi'];
	unlink($lokasi);

	$hapus_berkas = mysqli_query($koneksi, "DELETE FROM tbl_berkas WHERE berkas_id='$berkas_id'"); 
	if ($hapus_berkas){
		if ($_SESSION['status']=='admin') {
			header('location:../index.php?p=berkas');
		} else if ($_SESSION['status']=='guru') {
			header('location:../user/index.php?p=berkas');
		}
	} else {
		echo "<script>alert('berkas gagal dihapus.')</script>";
		if ($_SESSION['status'] == 'admin') {
			echo "<meta http-equiv='refresh' content='0;url=../index.php?p=berkas'>";
		} else if ($_SESSION['status'] == 'guru') {
			echo "<meta http-equiv='refresh' content='0;url=../user/index.php?p=berkas'>";
		}
	}
}
?>