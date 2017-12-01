<?php

include '../../konfigurasi/konfigurasi.php';
@session_start();
session_name("siks");

$siswa_id = $_GET['siswa_id'];

$ambil_siswa = mysqli_query($koneksi, "SELECT siswa_status FROM tbl_siswa WHERE siswa_id='$siswa_id'");
$siswa     = mysqli_fetch_array($ambil_siswa);

if ($siswa['siswa_status'] == 'aktif') {
	$sqlstatus = mysqli_query($koneksi, "UPDATE tbl_siswa SET siswa_status='tidak aktif' WHERE siswa_id='$siswa_id'");
	if ($sqlstatus) {
		header('location:../index.php?p=siswa');
	}
} else if ($siswa['siswa_status'] == 'tidak aktif') {
	$sqlstatus = mysqli_query($koneksi, "UPDATE tbl_siswa SET siswa_status='aktif' WHERE siswa_id='$siswa_id'");
	if ($sqlstatus) {
		header('location:../index.php?p=siswa');
	}
}
?>