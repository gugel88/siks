<?php

include '../../konfigurasi/konfigurasi.php';
@session_start();
session_name("siks");

$pengumuman_id = base64_decode($_GET['pengumuman_id']);

$ambil_pengumuman = mysqli_query($koneksi, "SELECT pengumuman_status FROM tbl_pengumuman WHERE pengumuman_id='$pengumuman_id'");
$pengumuman     = mysqli_fetch_array($ambil_pengumuman);

if ($pengumuman['pengumuman_status'] == 'publish') {
	$sqlstatus = mysqli_query($koneksi, "UPDATE tbl_pengumuman SET pengumuman_status='unpublish' WHERE pengumuman_id='$pengumuman_id'");
	if ($sqlstatus) {
		header('location:../index.php?p=pengumuman');
	}
} else if ($pengumuman['pengumuman_status'] == 'unpublish') {
	$sqlstatus = mysqli_query($koneksi, "UPDATE tbl_pengumuman SET pengumuman_status='publish' WHERE pengumuman_id='$pengumuman_id'");
	if ($sqlstatus) {
		header('location:../index.php?p=pengumuman');
	}
}
?>