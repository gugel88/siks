<?php
	include '../../konfigurasi/konfigurasi.php';
	$idmapel = $_GET['id_mapel'];
	$idkelas = $_GET['id_kelas'];

	$love = mysqli_query($koneksi, "DELETE FROM tbl_jadpel WHERE mapel_id ='$idmapel' AND kelas_id = '$idkelas'");
	$you = mysqli_query($koneksi, "DELETE FROM tbl_guru_mapel WHERE mapel_id ='$idmapel' AND kelas_id = '$idkelas'");
	if (!$love || !$you){	
		header('location:../index.php?p=jadwal_pelajaran');
	} else {
		echo "<script>alert('Jadwal pelajaran berhasil dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=jadwal_pelajaran'>";
	}
?>