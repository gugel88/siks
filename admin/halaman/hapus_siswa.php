<?php
	include '../../konfigurasi/konfigurasi.php';
	$siswa_id = base64_decode($_GET['id']);

	$hapus_siswa = mysqli_query($koneksi, "DELETE FROM tbl_siswa WHERE siswa_id='$siswa_id'");
	if ($hapus_siswa) {
		header('location:../index.php?p=siswa');
	} else {
		echo "<script>alert('siswa gagal dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=siswa'>";
	}
?>