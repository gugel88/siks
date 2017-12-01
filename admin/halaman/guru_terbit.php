<?php

include '../../konfigurasi/konfigurasi.php';
@session_start();
session_name("siks");

$guru_id = $_GET['guru_id'];

$ambil_guru = mysqli_query($koneksi, "SELECT guru_status FROM tbl_guru WHERE guru_id='$guru_id'");
$guru     = mysqli_fetch_array($ambil_guru);

if ($guru['guru_status'] == 'aktif') {
	$sqlstatus = mysqli_query($koneksi, "UPDATE tbl_guru SET guru_status='tidak aktif' WHERE guru_id='$guru_id'");
	if ($sqlstatus) {
		header('location:../index.php?p=guru');
	}
} else if ($guru['guru_status'] == 'tidak aktif') {
	$sqlstatus = mysqli_query($koneksi, "UPDATE tbl_guru SET guru_status='aktif' WHERE guru_id='$guru_id'");
	if ($sqlstatus) {
		header('location:../index.php?p=guru');
	}
}
?>