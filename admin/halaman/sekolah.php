<section class="content-header">
  <h1>
  Profil Sekolah
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-diamond"></i> Profil Sekolah</li>
  </ol>
</section>

<section class="content">
    <!-- profil sekolah -->
    <?php
    if (isset($_POST['perbarui-profilsekolah'])) {
      $sekolah_profil     = $_POST['profil'];

      $perbarui_sekolah = mysqli_query($koneksi, "UPDATE tbl_sekolah SET sekolah_profil='$sekolah_profil'");
      if ($perbarui_sekolah) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=sekolah' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Profil Sekolah telah diperbarui
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=sekolah' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>:  Profil Sekolah gagal diperbarui.
        </div>
        ";
      }
    }
    ?>
    <!-- visi&misi sekolah -->
    <?php
    if (isset($_POST['perbarui-visimisi'])) {
      $sekolah_visimisi   = $_POST['visimisi'];

      $perbarui_sekolah = mysqli_query($koneksi, "UPDATE tbl_sekolah SET sekolah_visimisi='$sekolah_visimisi'");
      if ($perbarui_sekolah) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=sekolah' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Visi & Misi Sekolah telah diperbarui
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=sekolah' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>:  Visi & Misi Sekolah gagal diperbarui.
        </div>
        ";
      }
    }
    ?>
    <!-- struktur organisasi sekolah -->
    <?php
    if (isset($_POST['perbarui-organisasi'])) {
      $sekolah_organisasi = $_POST['organisasi'];

      $perbarui_sekolah = mysqli_query($koneksi, "UPDATE tbl_sekolah SET sekolah_organisasi='$sekolah_organisasi'");
      if ($perbarui_sekolah) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=sekolah' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Struktur Organisasi Sekolah telah diperbarui
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=sekolah' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>:  Struktur Organisasi Sekolah gagal diperbarui.
        </div>
        ";
      }
    }
    ?>
    <!-- kontak sekolah -->
    <?php
    if (isset($_POST['perbarui-kontak'])) {
      $sekolah_alamat     = $_POST['alamat'];
      $sekolah_tlp        = $_POST['tlp'];
      $sekolah_email      = $_POST['email'];

      $perbarui_sekolah = mysqli_query($koneksi, "UPDATE tbl_sekolah SET sekolah_alamat='$sekolah_alamat', sekolah_tlp='$sekolah_tlp', sekolah_email='$sekolah_email'");
      if ($perbarui_sekolah) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=sekolah' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Kontak Sekolah telah diperbarui
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=sekolah' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>:  Kontak Sekolah gagal diperbarui.
        </div>
        ";
      }
    }
    ?>
    <!-- section profil sekolah -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#sekolah"><i class="icon_archive_alt"></i> Profil Sekolah</a></li>
          <li><a data-toggle="tab" href="#visimisi"><i class="icon_archive_alt"></i> Visi &amp; Misi</a></li>
          <li><a data-toggle="tab" href="#struktur"><i class="icon_archive_alt"></i> Struktur Organisasi</a></li>
          <li><a data-toggle="tab" href="#kontak"><i class="icon_phone"></i> Kontak</a></li>
        </ul>
      </header>

      <div class="panel-body">
        <div class="tab-content">
            <!-- data profil sekolah -->
            <div id="sekolah" class="tab-pane active">
              <div class="panel">
                <div class="panel-body">
                  <?php
                  $ambil_sekolah = mysqli_query($koneksi, "SELECT * FROM tbl_sekolah ORDER BY sekolah_id DESC LIMIT 1");
                  $sekolah       = mysqli_fetch_array($ambil_sekolah);

                  $id          = $sekolah['sekolah_id'];
                  $profil      = $sekolah['sekolah_profil'];
                  ?>
                  <form method='post' role="form" enctype='multipart/form-data'> 
                    <div class='form-group'>
                      <label class='control-label'>Profil Sekolah</label>
                      <textarea id='profil' name='profil' class='form-control' required>
                        <?=$sekolah['sekolah_profil'];?>
                      </textarea>
                    </div>

                    <br>
                    <div class='row'>
                      <div class='col-md-8 col-md-offset-5'>
                        <div class='form-group'>
                          <label class='control-label'></label>
                          <button type='submit' name='perbarui-profilsekolah' class='btn btn-success'>
                            Perbarui
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- data visimisi sekolah -->
            <div id="visimisi" class="tab-pane fade">
              <div class="panel">
                <div class="panel-body">
                  <?php
                  $ambil_sekolah = mysqli_query($koneksi, "SELECT * FROM tbl_sekolah ORDER BY sekolah_id DESC LIMIT 1");
                  $sekolah       = mysqli_fetch_array($ambil_sekolah);
                  $id          = $sekolah['sekolah_id'];
                  $visimisi    = $sekolah['sekolah_visimisi'];
                  ?>
                  <form method='post' role="form" enctype='multipart/form-data'> 
                    <div class='form-group'>
                      <label class='control-label'>Visi & Misi Sekolah</label>
                      <textarea id='vm' name='visimisi' class='form-control' required>
                        <?=$sekolah['sekolah_visimisi'];?>
                      </textarea>
                    </div>
                    <br>
                    <div class='row'>
                      <div class='col-md-8 col-md-offset-5'>
                        <div class='form-group'>
                          <label class='control-label'></label>
                          <button type='submit' name='perbarui-visimisi' class='btn btn-success'>
                            Perbarui
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- data organisasi sekolah -->
            <div id="struktur" class="tab-pane fade">
              <div class="panel">
                <div class="panel-body">
                  <?php
                  $ambil_sekolah = mysqli_query($koneksi, "SELECT * FROM tbl_sekolah ORDER BY sekolah_id DESC LIMIT 1");
                  $sekolah       = mysqli_fetch_array($ambil_sekolah);

                  $id          = $sekolah['sekolah_id'];
                  $organisasi    = $sekolah['sekolah_organisasi'];
                  ?>
                  <form method='post' role="form" enctype='multipart/form-data'> 
                    <div class='form-group'>
                      <label class='control-label'>Struktur Organisasi Sekolah</label>
                      <textarea id='organisasi' name='organisasi' class='form-control' required>
                        <?=$sekolah['sekolah_organisasi'];?>
                      </textarea>
                    </div>
                    <br>
                    <div class='row'>
                      <div class='col-md-8 col-md-offset-5'>
                        <div class='form-group'>
                          <label class='control-label'></label>
                          <button type='submit' name='perbarui-organisasi' class='btn btn-success'>
                            Perbarui
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- data kontak sekolah -->
            <div id="kontak" class="tab-pane fade">
              <div class="panel">
                <div class="panel-body">
                  <?php
                  $ambil_sekolah = mysqli_query($koneksi, "SELECT * FROM tbl_sekolah ORDER BY sekolah_id DESC LIMIT 1");
                  $sekolah       = mysqli_fetch_array($ambil_sekolah);
                  $id          = $sekolah['sekolah_id'];
                  $alamat      = $sekolah['sekolah_alamat'];
                  $tlp         = $sekolah['sekolah_tlp'];
                  $email       = $sekolah['sekolah_email'];
                  ?>
                  <form method='post' role="form" enctype='multipart/form-data'> 
                    <section class="panel">
                      <header class="panel-heading tab-bg-primary">
                        Kontak Sekolah
                      </header>
                      <div class="panel-body">
                        <div class='row'>
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label>Alamat</label>
                              <textarea type="text" class="form-control" name="alamat" rows="2" required style="width:100%;resize:none;"><?=$sekolah['sekolah_alamat'];?></textarea>
                            </div>
                          </div>
                        </div>
                        <div class='row'>
                          <div class='col-md-6'>
                            <div class='form-group'>
                              <label>No. Telepon</label>
                              <input type='text' name='tlp' class='form-control' value='<?=$sekolah['sekolah_tlp'];?>' required>
                            </div>
                          </div>
                          <div class='col-md-6'>
                            <div class='form-group'>
                              <label>Alamat E-Mail</label>
                              <input type='email' name='email' class='form-control' value='<?=$sekolah['sekolah_email'];?>' required>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <br>
                    <div class='row'>
                      <div class='col-md-8 col-md-offset-5'>
                        <div class='form-group'>
                          <label class='control-label'></label>
                          <button type='submit' name='perbarui-kontak' class='btn btn-success'>
                            Perbarui
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div><!-- tab konten end -->
        </div><!-- panel body end -->
      </section><!-- panel end -->
    </section><!-- wrapper end -->

  <!-- javascripts -->
  <script type="text/javascript" src="../assets/js/ckeditor/ckeditor.js"></script>
  <script src='../assets/js/tinymce/tinymce.min.js'></script>
  <script>
    tinymce.init({
      selector: '#profil',
      height: 200,
      plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table contextmenu paste code'
      ],
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      content_css: [
      '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
      '//www.tinymce.com/css/codepen.min.css'
      ]
    });
  </script> 
  <script>
    tinymce.init({
      selector: '#vm',
      height: 200,
      plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table contextmenu paste code'
      ],
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      content_css: [
      '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
      '//www.tinymce.com/css/codepen.min.css'
      ]
    });
  </script>   
  <script>
    tinymce.init({
      selector: '#organisasi',
      height: 200,
      plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table contextmenu paste code'
      ],
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      content_css: [
      '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
      '//www.tinymce.com/css/codepen.min.css'
      ]
    });
  </script>

<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_sekolah').addClass('active');
  $('#m_sekolah_profil').addClass('active');
</script>