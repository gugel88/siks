<section class="content-header">
  <h1>
  Beranda
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li class="active"><i class="fa fa-home"></i> Beranda</a></li>
  </ol>
</section>
<br>
        <?php
        if ($_SESSION['status'] == 'admin') {
        $link = "../";
        } else if ($_SESSION['status'] == 'guru') {
        $link = "../..";
        }
        ?>
        </div>
        <div class="panel-body">
        <?php
        if ($_SESSION['status'] == 'admin') {
        $link = "../";
        } else if ($_SESSION['status'] == 'guru') {
        $link = "../../";
        }
        echo " ";
        ?>
        <div class="col-md-12">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img class="img-circle" <?php echo "<img src='$link/img/user/thumb_$_SESSION[gambar]'/>"; ?>
              </div>
              <h3 class="widget-user-username">Selamat datang <b><?=$_SESSION['nm_tampilan'];?></b></h3>
              <h5 class="widget-user-desc">Anda login sebagai <i><?=$_SESSION['status'];?></i>, silahkan lihat pemberitahuan terbaru dibawah ini.</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php
                $ambil_artikel = mysqli_query($koneksi, "SELECT COUNT(*) As Artikel FROM tbl_artikel WHERE artikel_status='baru'");
                $jml_artikel = mysqli_fetch_array($ambil_artikel);
                $ambil_bukutamu = mysqli_query($koneksi, "SELECT COUNT(*) As Bukutamu FROM tbl_bukutamu WHERE buku_status='baru'");
                $jml_bukutamu = mysqli_fetch_array($ambil_bukutamu);
                $ambil_komentar = mysqli_query($koneksi, "SELECT COUNT(*) As Komentar FROM tbl_komentar WHERE komentar_status='2'");
                $jml_komentar = mysqli_fetch_array($ambil_komentar);
                ?>
                <li><a href="index.php?p=bukutamu">Pesan baru <span class="pull-right badge bg-blue"><?php echo $jml_bukutamu['Bukutamu']; ?></span></a></li>
                <li><a href="index.php?p=artikel">Artikel baru <span class="pull-right badge bg-aqua"><?php echo $jml_artikel['Artikel']; ?></span></a></li>
                <li><a href="index.php?p=komentar">Komentar baru <span class="pull-right badge bg-green"><?php echo $jml_komentar['Komentar']; ?></span></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class='col-lg-2 col-xs-6'>
          <div class='small-box bg-aqua'>
            <div class='inner'>
              <?php
              $query_jml_art = mysqli_query($koneksi, "SELECT COUNT(*) As art FROM tbl_artikel");
              $jml_art = mysqli_fetch_array($query_jml_art);
              ?>
              <h3><?php echo $jml_art['art']; ?></h3>
              <p>Jumlah Artikel</p>
            </div>
            <div class='icon'>
              <i class='ion ion-person-stalker'></i>
            </div>
            <a href='index.php?p=artikel' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
          </div>
        </div>
        <div class='col-lg-2 col-xs-6'>
          <div class='small-box bg-green'>
            <div class='inner'>
              <?php
              $query_jml_guru = mysqli_query($koneksi, "SELECT COUNT(*) As guru FROM tbl_guru");
              $jml_guru = mysqli_fetch_array($query_jml_guru);
              ?>
              <h3><?php echo $jml_guru['guru']; ?></h3>
              <p>Jumlah Guru</p>
            </div>
            <div class='icon'>
              <i class='ion ion-stats-bars'></i>
            </div>
            <a href='index.php?p=guru' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
          </div>
        </div>
        <div class='col-lg-2 col-xs-6'>
          <div class='small-box bg-yellow'>
            <div class='inner'>
              <?php
              $query_jml_berkas = mysqli_query($koneksi, "SELECT COUNT(*) As berkas FROM tbl_berkas");
              $jml_berkas = mysqli_fetch_array($query_jml_berkas);
              ?>
              <h3><?php echo $jml_berkas['berkas']; ?></h3>
              <p>Jumlah Berkas</p>
            </div>
            <div class='icon'>
              <i class='ion ion-ios-briefcase'></i>
            </div>
            <a href='index.php?p=berkas' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
          </div>
        </div>
        <div class='col-lg-2 col-xs-6'>
          <div class='small-box bg-red'>
            <div class='inner'>
              <?php
              $query_jml_buku= mysqli_query($koneksi, "SELECT COUNT(*) As buku FROM tbl_bukutamu");
              $jml_buku = mysqli_fetch_array($query_jml_buku);
              ?>
              <h3><?php echo $jml_buku['buku']; ?></h3>
              <p>Jumlah Buku Tamu</p>
            </div>
            <div class='icon'>
              <i class='ion ion-person'></i>
            </div>
            <a href='index.php?p=bukutamu' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
          </div>
        </div>
        <div class='col-lg-2 col-xs-6'>
          <div class='small-box bg-aqua'>
            <div class='inner'>
              <?php
              $query_jml_pengguna = mysqli_query($koneksi, "SELECT COUNT(*) As pengguna FROM tbl_user");
              $jml_pengguna = mysqli_fetch_array($query_jml_pengguna);
              ?>
              <h3><?php echo $jml_pengguna['pengguna']; ?></h3>
              <p>Jumlah Pengguna</p>
            </div>
            <div class='icon'>
              <i class='ion ion-person'></i>
            </div>
            <a href='index.php?p=pengguna' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
          </div>
        </div>
        <div class='col-lg-2 col-xs-6'>
          <div class='small-box bg-green'>
            <div class='inner'>
              <?php
              $query_jml_siswa = mysqli_query($koneksi, "SELECT COUNT(*) As siswa FROM tbl_siswa");
              $jml_siswa = mysqli_fetch_array($query_jml_siswa);
              ?>
              <h3><?php echo $jml_siswa['siswa']; ?></h3>
              <p>Jumlah Siswa</p>
            </div>
            <div class='icon'>
              <i class='ion ion-person'></i>
            </div>
            <a href='index.php?p=siswa' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
          </div>
        </div>

<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_beranda').addClass('active');
</script>