<?php

include '../../konfigurasi/konfigurasi.php';
@session_start();
session_name("siks");

$artikel_id = $_GET['id'];

$ambil_artikel = mysqli_query($koneksi, "SELECT artikel_status FROM tbl_artikel WHERE artikel_id='$artikel_id'");
$artikel     = mysqli_fetch_array($ambil_artikel);

if ($artikel['artikel_status'] == 'publish') {
	$sqlstatus = mysqli_query($koneksi, "UPDATE tbl_artikel SET artikel_status='unpublish' WHERE artikel_id='$artikel_id'");
	if ($sqlstatus) {
		if ($_SESSION['status'] == 'admin') {
			header('location:../index.php?p=artikel');
		} else if ($_SESSION['status'] == 'guru') {
			header('location:../user/index.php?p=artikel');
		}
	}
} else if (($artikel['artikel_status'] == 'unpublish') || ($artikel['artikel_status'] == 'baru')) {
	$sqlstatus = mysqli_query($koneksi, "UPDATE tbl_artikel SET artikel_status='publish' WHERE artikel_id='$artikel_id'");
	if ($sqlstatus) {
		if ($_SESSION['status'] == 'admin') {
			header('location:../index.php?p=artikel');
		} else if ($_SESSION['status'] == 'guru') {
			header('location:../user/index.php?p=artikel');
		}

	}
}
?>