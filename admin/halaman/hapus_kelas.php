<?php
	include '../../konfigurasi/konfigurasi.php';
	$kelas_id = base64_decode($_GET['id']);

	$hapus_kelas = mysqli_query($koneksi, "DELETE FROM tbl_kelas WHERE kelas_id='$kelas_id'");
	if ($hapus_kelas) {
		header('location:../index.php?p=kelas');
	} else {
		echo "<script>alert('kelas gagal dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=kelas'>";
	}
?>