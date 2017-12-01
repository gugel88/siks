<?php
include '../konfigurasi/konfigurasi.php';
@session_start();
session_name('siks');
if(isset($_SESSION['nm_pengguna'])){
  if($_SESSION['status']=='admin'){
    $get_user = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE nm_pengguna='$_SESSION[nm_pengguna]'");
    $user     = mysqli_fetch_array($get_user);
    ?>
<html>
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $_SESSION['nm_tampilan'];?> - Admin SIKS</title>
  <link rel="icon" href="../img/icon-siks.png">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../assets/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="../assets/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="../assets/bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="../assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="../assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="../assets/dist/font-awesome-animation.min.css">
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script type="text/javascript">
    bkLib.onDomLoaded(function(){
      nicEditors.allTextAreas(({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','image']})) });
  </script>
  </head>
  <body class="hold-transition skin-purple sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <a href="index.php" class="logo">
          <span class="logo-mini"><b>S</b>KS</span>
          <span class="logo-lg">SIKS</span>
        </a>
        <nav class="navbar navbar-static-top">
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <!-- Pemberitahuan User -->
                <?php
                  $ambil_artikel = mysqli_query($koneksi, "SELECT COUNT(*) As Artikel FROM tbl_artikel WHERE artikel_status='baru'");
                    $jml_artikel = mysqli_fetch_array($ambil_artikel);
                  $ambil_komentar = mysqli_query($koneksi, "SELECT COUNT(*) As Komentar FROM tbl_komentar WHERE komentar_status='2'");
                    $jml_komentar = mysqli_fetch_array($ambil_komentar);
                  $ambil_bukutamu = mysqli_query($koneksi, "SELECT COUNT(*) As Bukutamu FROM tbl_bukutamu WHERE buku_status='baru'");
                    $jml_bukutamu = mysqli_fetch_array($ambil_bukutamu);                                                                    
                ?>                 
                <li class="dropdown notifications-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell faa-ring animated"></i>
                    <span class="label label-warning"><?php echo $jml_artikel['Artikel']+$jml_komentar['Komentar']+$jml_bukutamu['Bukutamu']; ?></span>
                  </a>
                  <ul class="dropdown-menu">              
                    <li class="header"> Anda memiliki <?php echo $jml_artikel['Artikel']+$jml_komentar['Komentar']+$jml_bukutamu['Bukutamu']; ?> pemberitahuan baru</li>
                    <li>
                      <ul class="menu">
                        <li>
                          <a href="index.php?p=artikel">
                            <i class="fa fa-newspaper-o text-aqua"></i> <?php echo $jml_artikel['Artikel']; ?> Artikel perlu persetujuan
                          </a>
                        </li>                       
                        <li>
                          <a href="index.php?p=komentar">
                            <i class="fa fa-comment text-yellow"></i> <?php echo $jml_komentar['Komentar']; ?> Komentar masuk
                          </a>
                        </li>                         
                        <li>
                          <a href="index.php?p=bukutamu">
                            <i class="fa fa-envelope text-red"></i> <?php echo $jml_bukutamu['Bukutamu']; ?> Pesan masuk belum dibaca
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <!-- Info User -->                
                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="../img/user/kc_<?php echo $_SESSION['gambar']; ?>" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?php echo $_SESSION['nm_tampilan'];?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="user-header">
                      <img src="../img/user/kc_<?php echo $_SESSION['gambar']; ?>" class="img-circle" alt="User Image">
                      <p>
                        <?php echo $_SESSION['nm_tampilan'];?>
                        <small>SIKS - Sistem Informasi Akademik Sekolah</small>
                      </p>
                    </li>
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="index.php?p=profilku" class="btn btn-info btn-flat"><i class="fa fa-user"></i> Profil</a>
                      </div>
                      <div class="pull-right">
                        <a href="logout.php" class="btn btn-danger btn-flat"><i class="fa fa-power-off"></i> Keluar</a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                  <a title="Lihat web" href="../index.php" target="_blank"><i class="fa fa-rocket"></i></a>
                </li>                
              </ul>
          </div> 
        </nav>       
      </header>
      <aside class="main-sidebar">
        <section class="sidebar">
        <?php include "menu.php"; ?>
        </section>        
      </aside>
      <div class="content-wrapper">
        <section class="content">
          <div class="col-lg-12">
            <?php
            $ambil_pengumuman = mysqli_query($koneksi, "SELECT * FROM tbl_pengumuman WHERE pengumuman_status='publish' ORDER BY pengumuman_id DESC");
            $pengumuman=mysqli_fetch_array($ambil_pengumuman);
            ?>            
            <div class="callout alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="fa fa-bullhorn faa-tada animated"></i>&nbsp;
              <?=$pengumuman['pengumuman_isi'];?>
            </div>
          </div>           
          <div class="row">
            <div class="col-lg-12">
              <?php
              if (empty($_GET['p'])) {
                include 'halaman/beranda.php';
              } else if ($_GET['p']=='artikel') {
                include 'halaman/artikel.php';
              } else if ($_GET['p']=='pengumuman') {
                include 'halaman/pengumuman.php';
              } else if ($_GET['p']=='kategori') {
                include 'halaman/kategori.php';
              } else if ($_GET['p']=='guru') {
                include 'halaman/guru.php';
              } else if ($_GET['p']=='guruubah') {
                include 'halaman/guru_ubah.php';
              } else if ($_GET['p']=='siswa') {
                include 'halaman/siswa.php';
              } else if ($_GET['p']=='siswaubah') {
                include 'halaman/siswa_ubah.php';
              } else if ($_GET['p']=='sekolah') {
                include 'halaman/sekolah.php';
              } else if ($_GET['p']=='kelas') {
                include 'halaman/kelas.php';           
              } else if ($_GET['p']=='jadwal_pelajaran') {
                include 'halaman/jadwal.php';           
              } else if ($_GET['p']=='mapel') {
                include 'halaman/mapel.php';           
              } else if ($_GET['p']=='nilai_siswa') {
                include 'halaman/nilai.php';           
              } else if ($_GET['p']=='nilai_siswa_detail') {
                include 'halaman/nilai_detail.php';           
              } else if ($_GET['p']=='berkas') {
                include 'halaman/berkas.php';
              } else if ($_GET['p']=='galeri') {
                include 'halaman/galeri.php';
              } else if ($_GET['p']=='bukutamu') {
                include 'halaman/bukutamu.php';
              } else if ($_GET['p']=='komentar') {
                include 'halaman/komentar.php';
              } else if ($_GET['p']=='pengguna') {
                include 'halaman/pengguna.php';
              } else if ($_GET['p']=='tentang') {
                include 'halaman/tentang.php';
              } else if ($_GET['p']=='profilku') {
                include 'halaman/profil.php';
              } else if ($_GET['p']=='error') {
                include 'halaman/404.php';
              }
              ?>
            </div>
          </div>
        </section>  
      </div>
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 0.1-beta
        </div>
        Copyright &copy; <?php echo date('Y') ?> <a href="mailto:abdulmujib005@ummi.ac.id"><strong>SIKS</a></strong>. All rights reserved.
      </footer>
    </div>
  </body>
</html>
    <?php
  } else if ($_SESSION['status'] == 'user') {
    echo "<meta http-equiv='refresh' content='0;url=user/'>";
  } else {
    echo "<script>alert('Anda tidak memiliki hak akses !')</script>";
    echo "<meta http-equiv='refresh' content='0;url=../' />";
  }
} else {
  echo "<script>alert('Anda tidak memiliki hak akses !')</script>";
  echo "<meta http-equiv='refresh' content='0;url=../' />";
}
?>

<script src="../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="../assets/bower_components/fastclick/lib/fastclick.js"></script>
<script src="../assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="../assets/dist/js/adminlte.min.js"></script>
<script src="../assets/dist/js/demo.js"></script>
<script src="../assets/plugins/jQueryUI/jquery-ui.min.js"></script>

<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>