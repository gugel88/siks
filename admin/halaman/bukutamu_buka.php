<?php

include '../../konfigurasi/konfigurasi.php';
$buku_id = $_GET['id'];

$ambil_bukutamu = mysqli_query($koneksi, "SELECT * FROM tbl_bukutamu WHERE buku_id='$buku_id'");
if ($bukutamu = mysqli_fetch_array($ambil_bukutamu))
{
	$ubah_bukutamu = mysqli_query($koneksi, "UPDATE tbl_bukutamu SET buku_status='sudah dibaca' WHERE buku_id='$buku_id'");
	header('location:../index.php?p=bukutamu');
}


?>