<?php
	include '../../konfigurasi/konfigurasi.php';
	$portal_id = $_GET['id'];

	$hapus_portal = mysqli_query($koneksi, "DELETE FROM tb_portal WHERE portal_id='$portal_id'");
	if ($hapus_portal) {
		header('location:../index.php?p=prodi');
	} else {
		echo "<script>alert('Portal gagal dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=prodi'>";
	}
?>