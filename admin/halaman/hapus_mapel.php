<?php
	include '../../konfigurasi/konfigurasi.php';
	$mapel_id = base64_decode($_GET['id']);

	$hapus_mapel = mysqli_query($koneksi, "DELETE FROM tbl_mapel WHERE mapel_id='$mapel_id'");
	if ($hapus_mapel) {
		header('location:../index.php?p=mapel');
	} else {
		echo "<script>alert('Mata Pelajaran gagal dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=mapel'>";
	}
?>