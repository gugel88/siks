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
<div class="col-md-8">
  <div class="box box-widget widget-user-2">
    <div class="widget-user-header bg-blue">
      <div class="widget-user-image">
        <img class="img-circle" src="img/icon-siks.png" alt="User Avatar">
      </div>
      <h3 class="widget-user-username">Halo! Selamat datang di</h3>
      <h5 class="widget-user-desc">Sistem Informasi Akademik Sekolah (SIKS)</h5>
    </div>
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs pull-right">
        <li class="active"><a href="#tab_1-1" data-toggle="tab">Profil Sekolah</a></li>
        <li><a href="#tab_2-2" data-toggle="tab">Visi &amp; Misi</a></li>
        <li><a href="#tab_3-2" data-toggle="tab">Struktur Organisasi</a></li>
      </ul>
      <div class="tab-content">
        <?php
        $ambil_profil = mysqli_query($koneksi, "SELECT * FROM tbl_sekolah ORDER BY sekolah_id LIMIT 1");
        $sekolah       = mysqli_fetch_array($ambil_profil);
        ?>        
        <div class="tab-pane active" id="tab_1-1">
          <?=$sekolah['sekolah_profil'];?>
        </div>
        <div class="tab-pane" id="tab_2-2">
          <?=$sekolah['sekolah_visimisi'];?>
        </div>
        <div class="tab-pane" id="tab_3-2">
          <?=$sekolah['sekolah_organisasi'];?>
        </div>
      </div>
    </div>  
  </div>
</div>
<?php include "konten_kanan.php"; ?>

<!-- Js Menu -->
<script type="text/javascript" src="assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_beranda').addClass('active');
</script>