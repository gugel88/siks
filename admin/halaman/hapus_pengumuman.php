<?php
	include '../../konfigurasi/konfigurasi.php';
	$pengumuman_id = base64_decode($_GET['id']);

	$hapus_pengumuman = mysqli_query($koneksi, "DELETE FROM tbl_pengumuman WHERE pengumuman_id='$pengumuman_id'");
	if ($hapus_pengumuman) {
		header('location:../index.php?p=pengumuman');
	} else {
		echo "<script>alert('Pengumuman gagal dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=pengumuman'>";
	}
?>