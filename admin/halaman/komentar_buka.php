<?php
include '../../konfigurasi/konfigurasi.php';
@session_start();
session_name("siks");
$komentar_id = base64_decode($_GET['id']);

$ambil_komentar = mysqli_query($koneksi, "SELECT * FROM tbl_artikel, tbl_komentar WHERE tbl_artikel.artikel_id=tbl_komentar.artikel_id AND tbl_komentar.komentar_id='$komentar_id'");
if ($artikel = mysqli_fetch_array($ambil_komentar))
{
	$artikel_title = str_replace(" ", "+", $artikel['artikel_judul']);
	$link       = "index.php?p=Artikel&detail=$artikel_title#komentar";

	if ($_SESSION['status']=='admin') {
		if ($artikel['komentar_status']=='2') {
			$ubah_komentar = mysqli_query($koneksi, "UPDATE tbl_komentar SET komentar_status='1' WHERE komentar_id='$komentar_id'");
		} else if ($artikel['komentar_status']=='3') {
			$ubah_komentar = mysqli_query($koneksi, "UPDATE tbl_komentar SET komentar_status='4' WHERE komentar_id='$komentar_id'");
		}
	} else if ($_SESSION['status']=='guru') {
		if ($artikel['komentar_status']=='2') {
			$ubah_komentar = mysqli_query($koneksi, "UPDATE tbl_komentar SET komentar_status='3' WHERE komentar_id='$komentar_id'");
		} else if ($artikel['komentar_status']=='1') {
			$ubah_komentar = mysqli_query($koneksi, "UPDATE tbl_komentar SET komentar_status='4' WHERE komentar_id='$komentar_id'");
		}
	}
	header('location:../../' . $link);
}


?>