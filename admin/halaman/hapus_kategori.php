<?php
	include '../../konfigurasi/konfigurasi.php';
	$kategori_id = $_GET['id'];

	$hapus_kategori = mysqli_query($koneksi, "DELETE FROM tbl_kategori WHERE kategori_id='$kategori_id'");
	if ($hapus_kategori) {
		header('location:../index.php?p=kategori');
	} else {
		echo "<script>alert('kategori gagal dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=kategori'>";
	}
?>