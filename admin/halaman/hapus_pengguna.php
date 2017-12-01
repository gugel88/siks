<?php
include '../../konfigurasi/konfigurasi.php';
@session_start();
session_name("siks");

$pengguna_id = $_GET['id'];

$ambil_pengguna = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE id_user='$pengguna_id'");
if ($pengguna = mysqli_fetch_array($ambil_pengguna)) {
	$link_gambar_kc1 = "../../img/user/kc_" . $pengguna['gambar'];
	$link_gambar_kc2 = "../../img/user/thumb_" . $pengguna['gambar'];
	unlink($link_gambar_kc1);
	unlink($link_gambar_kc2);

	$hapus_pengguna = mysqli_query($koneksi, "DELETE FROM tbl_user WHERE id_user='$pengguna_id'");
	if ($hapus_pengguna) {
		header('location:../index.php?p=pengguna');
	} else {
		echo "<script>alert('Pengguna gagal dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=pengguna'>";
	}
}
?>