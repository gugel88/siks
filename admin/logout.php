<?php
include "konfigurasi/konfigurasi.php";
session_start();
session_name("siks");
//untuk mengakhiri sessionnya
session_destroy();
unset($_SESSION["siks"]);
//setelah berhasil logout, akan diarahkan ke halaman mana?
header("location:../index.php");
exit();
?>