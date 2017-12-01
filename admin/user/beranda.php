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
                $ambil_komentar = mysqli_query($koneksi, "SELECT COUNT(*) As Komentar FROM tbl_komentar WHERE komentar_status='2'");
                $jml_komentar = mysqli_fetch_array($ambil_komentar);
                ?>
                <li><a href="index.php?p=komentar">Komentar baru <span class="pull-right badge bg-green"><?php echo $jml_komentar['Komentar']; ?></span></a></li>
              </ul>
            </div>
          </div>
        </div>

<!-- Js Menu -->
<script type="text/javascript" src="../../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_beranda').addClass('active');
</script>