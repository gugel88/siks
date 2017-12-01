<?php
	include '../../konfigurasi/konfigurasi.php';
	$buku_id = $_GET['id'];

	$hapus_bukutamu = mysqli_query($koneksi, "DELETE FROM tbl_bukutamu WHERE buku_id='$buku_id'");
	if ($hapus_bukutamu) {
		header('location:../index.php?p=bukutamu');
	} else {
		echo "<script>alert('Bukutamu gagal dihapus.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=../index.php?p=bukutamu'>";
	}
?>