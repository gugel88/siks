<?php
	include '../../konfigurasi/konfigurasi.php';
	$guru_id = base64_decode($_GET['id']);

	$hapus_guru = mysqli_query($koneksi, "DELETE FROM tbl_guru WHERE guru_id='$guru_id'");
	if ($hapus_guru) {
		header('location:../index.php?p=guru');
	} else {
		echo "<script>alert('Guru gagal dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=guru'>";
	}
?>