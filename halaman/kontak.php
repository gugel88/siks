<section class="content-header">
  <h1>
    Hubungi
    <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-home"></i><a href="index.php">Beranda</a></li>
    <li class='active'>Hubungi</li>
  </ol>
</section>
<br>
      <!-- row -->
        <div class="col-md-12">
          <?php
          $ambil_kontak = mysqli_query($koneksi, "SELECT * FROM tbl_sekolah ORDER BY sekolah_id LIMIT 1");
          $kontak       = mysqli_fetch_array($ambil_kontak);
          ?>            
          <div class="box box-widget widget-user">
            <div class="widget-user-header bg-blue">
              <h3 class="widget-user-username">Hubungi Kami</h3>
              <h5 class="widget-user-desc">Sistem Informasi Akademik Sekolah (SIKS)</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="img/icon-siks.png" alt="User Avatar">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">Telepon</h5>
                    <span class="description-text"><?php echo $kontak['sekolah_tlp']; ?></span>
                  </div>
                </div>
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">Alamat</h5>
                    <span class="description-text"><?php echo $kontak['sekolah_alamat']; ?></span>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">Email</h5>
                    <span class="description-text"><?php echo $kontak['sekolah_email']; ?></span>
                  </div>
                </div>
                <br>
                <form class="shake" data-toggle="validator" role="form" method="post">
                  <div class="col-md-12">
                  <?php
                  if (isset($_POST['kirim_bukutamu'])) {
                    $nama  = $_POST['buku_nama'];
                    $email = $_POST['buku_email'];
                    $telp  = $_POST['buku_tlp'];
                    $pesan = nl2br($_POST['buku_pesan']);
                    $pesan = mysqli_real_escape_string($koneksi, $pesan);

                    $simpan = mysqli_query($koneksi, "INSERT INTO tbl_bukutamu VALUES(NULL, '$nama', '$email', '$telp', '$pesan', 'baru')");
                    if ($simpan) {
                      echo "
                      <div class='alert alert-success alert-dismissable' style='border-radius:0px;'>
                        <a type='button' href='index.php?p=Hubungi' aria-hidden='true' class='close'>×</a>
                        <strong>Berhasil </strong>: Pesan telah dikirim !
                      </div>
                      ";
                    } else {
                      echo "
                      <div class='alert alert-danger' style='border-radius:0px;'>
                        <a type='button' href='index.php?p=Hubungi' aria-hidden='true' class='close'>×</a>
                        <strong>Gagal </strong>: Gagal mengirim buku tamu !
                      </div>
                      ";
                    }
                  }
                  ?>
                    <div class="form-group">
                      <input class="form-control" placeholder="Nama" name="buku_nama" required="" type="text">
                      <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="buku_email" placeholder="Email" required="" type="email">
                      <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                      <input class="form-control" name="buku_tlp" placeholder="No. Telepon/ Handphone" required="" type="text">
                      <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                      <textarea class="form-control" name="buku_pesan" placeholder="Pesan" required="" rows="3"></textarea>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <button class="btn btn-default btn-flat" name="kirim_bukutamu" type="submit">Kirim Pesan</button>
                  <div class="clearfix"></div>
                  </div>
                </form>
            </div>
          </div>          
        </div>

<!-- Js Menu -->
<script type="text/javascript" src="assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_hubungi').addClass('active');
</script>