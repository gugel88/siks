<?php
include 'konfigurasi/konfigurasi.php';
session_start();
session_name('siaksi');
if (isset($_SESSION['id_user'])) {
  $get_user = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE id_user='$_SESSION[id_user]'");
  $user     = mysqli_fetch_array($get_user);
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>
        <?php
        if (isset($_GET['p'])) {            
          if (isset($_GET['db'])) {       
            echo $_GET['db'];               
          } else if (isset($_GET['dd'])) {  
          echo $_GET['dd'];
        } else if (isset($_GET['dpr'])) {
          echo $_GET['dpr'];
        } else {
          echo $_GET['p'];
        }
      } else {
        echo "Beranda";
      }
      ?>
      - SIKS
    </title>
    <link rel="icon" href="img/icon-siks.png">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="assets/bower_components/morris.js/morris.css">
    <link rel="stylesheet" href="assets/dist/font-awesome-animation.min.css">
    <link rel="stylesheet" href="assets/bower_components/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script type="text/javascript">
      bkLib.onDomLoaded(function(){
        nicEditors.allTextAreas(({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','html','image']})) });
    </script>
  </head>
  <body class="hold-transition skin-purple layout-top-nav">
    <div class="wrapper">
      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="index.php" class="navbar-brand">SIKS</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                <li id="m_beranda"><a href="index.php">Beranda</a></li>
                <li id="m_artikel" class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Artikel <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li id="m_artikel_materi"><a href="index.php?p=Artikel&kategori=Materi">Materi</a></li>
                    <li id="m_artikel_tugas"><a href="index.php?p=Artikel&kategori=Tugas">Tugas</a></li>
                    <li id="m_artikel_pengumuman"><a href="index.php?p=Artikel&kategori=Pengumuman">Pengumuman</a></li>
                  </ul>
                </li>
                <li id="m_unduh"><a href="index.php?p=Unduh">Unduh</a></li>
                <li id="m_hubungi"><a href="index.php?p=Hubungi">Hubungi</a></li>
              </ul>
              <form class="navbar-form navbar-left" role="search" action="index.php?p=Pencarian" method="post">
                <div class="form-group">
                  <input type="text" class="form-control" id="navbar-search-input" name="artikel_judul" placeholder="Pencarian">
                </div>
              </form>
            </div>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <li id="m_kontak" class="dropdown tasks-menu">
                  <a href="index.php?p=Masuk" title="Masuk siaksi"><i class="fa fa-user"></i> Masuk</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="content-wrapper">
        <div class="container">      
          <section class="content">            
            <?php
            $ambil_pengumuman = mysqli_query($koneksi, "SELECT * FROM tbl_pengumuman WHERE pengumuman_status='publish' ORDER BY pengumuman_id DESC");
            $pengumuman=mysqli_fetch_array($ambil_pengumuman);
            ?>            
            <div class="callout alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="fa fa-bullhorn faa-tada animated"></i>&nbsp;
              <?=$pengumuman['pengumuman_isi'];?>
            </div>
            <div class="row">
              <?php
              if (empty($_GET['p'])) {
                include 'halaman/beranda.php';
              } else if ($_GET['p'] == 'Artikel') {
                include 'halaman/artikel.php';
              } else if ($_GET['p'] == 'Masuk') {
                include 'halaman/login.php';
              } else if ($_GET['p'] == 'Unduh') {
                include 'halaman/download.php';
              } else if ($_GET['p'] == 'Hubungi') {
                include 'halaman/kontak.php';
              } else if ($_GET['p'] == 'Pencarian') {
                include 'halaman/pencarian.php';
              } else {
                include 'halaman/404.php';
              }
              ?>            
            </div>
          </section>
        </div>
      </div>
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Version</b> 0.1-beta
          </div>
          Copyright &copy; <?php echo date('Y') ?> <a href="mailto:abdulmujib005@ummi.ac.id"><strong>SIKS</a></strong>. All rights reserved.
        </div>
      </footer> 
    </div>
    <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="assets/dist/js/adminlte.min.js"></script>
    <script src="assets/dist/js/demo.js"></script>
    <script src="assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>    
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
  </body>
</html>