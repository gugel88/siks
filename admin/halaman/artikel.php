<section class="content-header">
  <h1>
  Manjemen Artikel
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-newspaper-o"></i> Artrikel</li>
  </ol>
</section>
<br>
<div class="col-lg-12">
    <!-- proses tambah, perbarui -->
    <?php
    if (isset($_POST['tambah-artikel'])) {
      function Upload($uploadName){
        if ($_SESSION['status'] == 'admin') {
          $direktori          = "../img/artikel/";
          $direktoriThumb1    = "../img/artikel/";
          $direktoriThumb2    = "../img/artikel/thumb/";
        } else if ($_SESSION['status'] == 'guru') {
          $direktori          = "../../img/artikel/";
          $direktoriThumb1    = "../../img/artikel/";
          $direktoriThumb2    = "../../img/artikel/thumb/"; 
        }
        $file               = $direktori.$uploadName;

        $realImagesName     = $_FILES['image']['tmp_name'];
        move_uploaded_file($realImagesName, $file);

        $realImages         = imagecreatefromjpeg($file);
        $width              = imageSX($realImages);
        $height             = imageSY($realImages);

        if ($width > 690) {
          $thumb1Width        = 690;
          $thumb1Height       = ($thumb1Width / $width) * $height;
        } else {
          $thumb1Width        = $width;
          $thumb1Height       = $height;
        }

        $thumb2Width          = 120;
        $thumb2Height         = ($thumb2Width / $width) * $height;

        $thumbImage1 = imagecreatetruecolor($thumb1Width, $thumb1Height);
        imagecopyresampled($thumbImage1, $realImages, 0,0,0,0, $thumb1Width, $thumb1Height, $width, $height);
        $thumbImage2 = imagecreatetruecolor($thumb2Width, $thumb2Height);
        imagecopyresampled($thumbImage2, $realImages, 0,0,0,0, $thumb2Width, $thumb2Height, $width, $height);

        imagejpeg($thumbImage1,$direktoriThumb1."thumb_".$uploadName);
        imagejpeg($thumbImage2,$direktoriThumb2."thumb_".$uploadName);

        imagedestroy($realImages);
        imagedestroy($thumbImage1);
        imagedestroy($thumbImage2);

        unlink($direktori.$uploadName);
      }

      $id_user          = $_SESSION['id_user'];
      $judul            = $_POST['judul'];
      $konten           = $_POST['konten'];
      $label            = $_POST['label'];
      $kategori_id      = $_POST['kategori_id'];

      $image            = $_FILES['image']['tmp_name'];
      $image_name       = time() . '_' . $_FILES['image']['name'];
      $image_name       = str_replace(" ", "-", $image_name);
      $image_type       = $_FILES['image']['type'];
      $image_size       = $_FILES['image']['size'];

      if ($image_size < 2044070) {
        Upload($image_name);

        if ($_SESSION['status'] == 'admin') {
          $simpan_artikel = mysqli_query($koneksi, "INSERT INTO tbl_artikel(id_user,artikel_judul,artikel_tgl,artikel_img,artikel_konten,artikel_label,artikel_hitung,kategori_id,artikel_status) VALUES('$id_user','$judul',NOW(),'$image_name','$konten','$label','0','$kategori_id','publish')");
        } else if ($_SESSION['status'] == 'guru') {
          $simpan_artikel = mysqli_query($koneksi, "INSERT INTO tbl_artikel(id_user,artikel_judul,artikel_tgl,artikel_img,artikel_konten,artikel_label,artikel_hitung,kategori_id,artikel_status) VALUES('$id_user','$judul',NOW(),'$image_name','$konten','$label','0','$kategori_id','baru')");
        }
        if ($simpan_artikel) {
          echo "
          <div class='alert alert-success alert-dismissable'>
            <a href='index.php?p=artikel' type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</a>
            <strong>Berhasil !</strong> artikel baru telah disimpan.
          </div>
          ";
          echo "<meta http-equiv='refresh'content='0;url=index.php?p=artikel' />";
        } else {
          echo "
          <div class='alert alert-danger alert-dismissable'>
            <button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
            <strong>Gagal !</strong> artikel baru gagal disimpan.
          </div>
          ";
        }
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
          <strong>Informasi :</strong> Ukuran gambar terlalu besar. Harap pilih gambar maksimal 2 MB.
        </div>";
      }
    }

    if (isset($_POST['perbarui-artikel'])) {
      $artikel_id       = base64_decode($_GET['artikel_id']);
      $judul           = $_POST['judul'];
      $konten          = $_POST['konten'];
      $label           = $_POST['label'];

      $perbarui_artikel = mysqli_query($koneksi, "UPDATE tbl_artikel SET artikel_judul='$judul', artikel_konten='$konten', artikel_label='$label' WHERE artikel_id='$artikel_id'");
      if ($perbarui_artikel) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=artikel' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil !</strong> artikel telah diperbarui.
        </div>
        ";
        echo "<meta http-equiv='refresh'content='0;url=index.php?p=artikel' />";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=artikel' aria-hidden='true' class='close'>×</a>
          <strong>Gagal !</strong> artikel gagal diperbarui.
        </div>
        ";
      }
    }
    ?>

    <?php
    if (isset($_GET['publikasi_id'])) {
      $pub_id = base64_decode($_GET['publikasi_id']);
      echo "
      <div class='alert alert-info'>
        <i class='fa fa-warning fa-fw'></i> <strong>Perhatian :</strong> Anda yakin akan publikasikan atau batal publikasi ? &nbsp;&nbsp;
        <a type='button' class='alert-link btn btn-default' href='halaman/artikel_terbit.php?id=$pub_id'>Ya</a>
        <a href='index.php?p=artikel' class='alert-link btn btn-default' type='button' data-dismiss='alert' aria-hidden='true' class='close'>Tidak </a>
      </div>
      ";
    }
    ?>

    <?php
    if(isset($_GET['hapus_artikel_id'])){
      $del_id = base64_decode($_GET['hapus_artikel_id']);
      if ($user['status'] == 'admin') {
        $link = "halaman";
      } else if ($user['status'] == 'guru') {
        $link = "../halaman";
      }
      echo "
      <div class='alert alert-danger'>
        <i class='fa fa-warning fa-fw'></i> <strong>Perhatian :</strong> Tindakan ini akan menghapus juga semua komentar dari artikel ini. Anda yakin akan menghapus ? &nbsp;&nbsp;
        <a type='button' class='alert-link btn btn-default' href='$link/artikel_hapus.php?id=$del_id'>Ya</a>
        <a type='button' class='alert-link btn btn-default' href='index.php?p=artikel'>Tidak</a>
      </div>
      ";
    }
    ?>

    <?php
    if(isset($_GET['artikel_id'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    }
    ?>

    <!-- konten artikel -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="<?php echo $tab_list_class; ?>">
            <a data-toggle="tab" href="#daftar">
              <i class="fa fa-bars fa-fw"></i>
              Daftar Artikel
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#tambah">
              <i class="fa fa-plus fa-fw"></i>
              Tambah Artikel
            </a>
          </li>
          <?php
          if(isset($_GET['artikel_id'])){
            echo "
            <li class='active'>
              <a href='#perbarui' data-toggle='tab'>
                <i class='fa fa-edit fa-fw'></i>
                Perbarui Artikel
              </a>
            </li>";
          }
          ?>
        </ul>
      </header>

      <div class="panel-body">
        <!-- tab konten -->
        <div class="tab-content">
          <!-- data artikel -->
          <div id="daftar" class="<?php echo $tab_pane_class; ?>">
            <div class="panel">
              <div class="panel-body pan table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Artikel</th>
                      <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if ($user['status'] == 'admin') {
                      include "../konfigurasi/enkripsi.php";
                      $ambil_artikel = mysqli_query($koneksi, "SELECT tbl_user.*, tbl_kategori.*, tbl_artikel.* FROM tbl_user, tbl_kategori, tbl_artikel WHERE tbl_user.id_user=tbl_artikel.id_user AND tbl_kategori.kategori_id=tbl_artikel.kategori_id ORDER BY artikel_status DESC"); 
                    } else if ($user['status'] == 'guru') {
                      include "../../konfigurasi/enkripsi.php";
                      $ambil_artikel = mysqli_query($koneksi, "SELECT tbl_kategori.*, tbl_artikel.* FROM tbl_kategori, tbl_artikel WHERE tbl_kategori.kategori_id=tbl_artikel.kategori_id AND tbl_artikel.id_user='$_SESSION[id_user]' ORDER BY artikel_status DESC");
                    }
                    if (mysqli_num_rows($ambil_artikel) > 0) {
                      $no = 1;
                      while ($artikel = mysqli_fetch_array($ambil_artikel)) {
                        $ubah_tanggal = mysqli_query($koneksi, "SELECT DATE_FORMAT('$artikel[artikel_tgl]', '%d %b %Y - %r') AS tanggal");
                        $tanggal      = mysqli_fetch_array($ubah_tanggal);
                        $artikel_tgl    = $tanggal['tanggal'];
                        $artikel_konten = substr($artikel['artikel_konten'],0,250);
                        $artikel_konten = substr($artikel['artikel_konten'],0,strrpos($artikel_konten," "));
                        $artikel_konten = strip_tags($artikel_konten, "<p>");
                        $artikel_bsd     = base64_encode($artikel['artikel_id']);
                        $token = encrypt($artikel_bsd);
                        $ambil_komentar = mysqli_query($koneksi, "SELECT COUNT(*) AS jmlKomentar FROM tbl_komentar WHERE artikel_id='$artikel[artikel_id]'");
                        $komentar          = mysqli_fetch_array($ambil_komentar);

                        echo "
                        <tr>
                          <td>$no.</td>
                          <td>
                            <p><b>$artikel[artikel_judul]</b> &nbsp; <i class='text-info'> <small class='label label-info'><i class='fa fa-tags'></i> $artikel[kategori_nama]</small> </i></p>
                            <p><small>$artikel_konten [ ... ]</small></p>
                            <p><small>$artikel_tgl 
                              ";
                              if ($artikel['artikel_status'] == 'baru') {
                                echo "<small class='label label-success'><i class='fa fa-thumbs-o-up'></i> $artikel[artikel_status] </small>";
                              } else if ($artikel['artikel_status'] == 'publish') {
                                echo "<small class='label label-success'><i class='fa fa-eye'></i> $artikel[artikel_status] </small>";
                              } else if ($artikel['artikel_status'] == 'unpublish') {
                                echo "<small class='label label-success'><i class='fa fa-eye-slash'></i> $artikel[artikel_status] </small>";
                              }
                              echo "</p>"; 
                              if ($user['status'] == 'admin') {
                                echo "<p><small>Pengirim : $artikel[nm_tampilan]</small></p>";
                              } 
                              echo "
                            </td>
                            <td>
                              <p><a class='tooltips' title='Edit' data-placement='top' href='index.php?p=artikel&artikel_id=$artikel_bsd&token=$token'><i class='fa fa-edit'></i></a> &nbsp;&nbsp;
                                <a class='tooltips' title='Hapus' data-placement='top' href='index.php?p=artikel&hapus_artikel_id=$artikel_bsd&token=$token'><i class='fa fa-trash-o'></i></a> &nbsp;&nbsp;
                                ";
                                if ($user['status'] == 'admin') {
                                  if ($artikel['artikel_status'] == 'publish'){
                                    $text = "Unpublish";
                                    $fa_class = "fa fa-eye-slash";
                                  } else {
                                    $text = "Publish";
                                    $fa_class = "fa fa-eye";
                                  }
                                  echo "
                                  <a class='tooltips' title='Lihat Artikel' data-placement='top' href='../index.php?p=Artikel&detail=".str_replace(" ", "+", $artikel['artikel_judul'])."' target='blank'><i class='fa fa-search-plus'></i></a> &nbsp;&nbsp;
                                  <a class='tooltips' title='$text' data-placement='top' href='index.php?p=artikel&publikasi_id=$artikel_bsd&token=$token'><i class='$fa_class'></i></a>
                                  ";
                                } else if ($user['status'] == 'guru') {
                                  echo "
                                  <a class='tooltips' title='Lihat Artikel Lengkap' data-placement='top' href='../../index.php?p=Artikel&detail=".str_replace(" ", "+", $artikel['artikel_judul'])."' target='blank'><i class='fa fa-search-plus'></i></a>
                                  ";
                                }
                                echo "
                              </p>
                            </td>
                          </tr>
                          ";
                          $no++;
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div> <!-- data artikel end -->

            <!-- tambah-artikel -->
            <div id="tambah" class="tab-pane fade">
              <section class="panel" style="margin-bottom:0px;">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Tambah Artikel</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" id="register_form" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label for="judul" class="col-lg-2 control-label">Judul Artikel<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="judul" id="judul" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="kategori" class="col-lg-2 control-label">Kategori Artikel<span class="required"></span></label>
                      <div class="col-lg-7">
                        <select for="kategori" name="kategori_id" id="kategori" class="form-control" required>
                          <option value="selected">--- Kategori Artikel ---</option>
                          <?php
                          $ambil_ktg = mysqli_query($koneksi, "SELECT * FROM tbl_kategori WHERE kategori_tentang='artikel'");
                          while ($kategori = mysqli_fetch_array($ambil_ktg)) {
                            echo "<option value='$kategori[kategori_id]'>$kategori[kategori_nama]</option>";
                          }
                          ?>
                        </option>
                      </select>
                      <small><span>* Pilih salah satu kategori artikel. (Catatan : Untuk Guru pilih hanya Materi dan Tugas).</span></small>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Gambar Untuk Artikel</label>
                    <div class="col-lg-5">
                      <input type="file" class="form-control" accept="image/jpeg" name="image" id="">
                      <small><span>* Pilih gambar dengan ekstensi .JPG maksimal berukuran 2 MB.</span></small>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Konten Artikel</label>
                    <div class="col-lg-10">
                      <textarea name="konten" id="konten-tambah" class="form-control" required></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Label Artikel</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="label" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="tambah-artikel" class="btn btn-primary">Simpan</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div> <!-- tambah artikel end -->

          <!-- edit artikel -->
          <?php
          if(isset($_GET['artikel_id'])){
            $artikel_id    = base64_decode($_GET['artikel_id']);
            $ambil_artikel = mysqli_query($koneksi, "SELECT * FROM tbl_artikel WHERE artikel_id='$artikel_id'");
            $ganti_artikel = mysqli_fetch_array($ambil_artikel);
            ?>
            <div id="perbarui" class="tab-pane fade in active">
              <section class="panel">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Ubah Artikel</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Judul Artikel</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="judul" value="<?php echo $ganti_artikel['artikel_judul'];?>"">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Konten Artikel</label>
                      <div class="col-lg-10">
                        <textarea name="konten" id="konten-edit" placeholder="Konten Artikel" class="form-control"><?php echo $ganti_artikel['artikel_konten']; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Label Artikel</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="label" value="<?php echo $ganti_artikel['artikel_label'];?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="perbarui-artikel" class="btn btn-success">
                          Perbarui
                        </button>
                        <a href="index.php?p=artikel" type="button" class="btn btn-danger">
                          Batal
                        </a>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div>

            <?php
          } 
          ?>

          <!-- edit artikel end -->

        </div><!-- tab konten end -->
      </div><!-- panel body end -->
</section>
</div>

<?php
if ($user['status'] == 'admin') {
  ?>
<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script>
<script src="../assets/bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(function () {
    CKEDITOR.replace('konten-tambah')
    CKEDITOR.replace('konten-edit')
    $('.textarea').wysihtml5()
  })
</script> 
<script type="text/javascript">
  $('#m_artikel').addClass('active');
  $('#m_artikel_lihat').addClass('active');
</script>
  <?php  
} else if ($user['status'] == 'guru') {
  ?>
<script type="text/javascript" src="../../assets/js/jquery-min.js"></script>
<script src="../../assets/bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(function () {
    CKEDITOR.replace('konten-tambah')
    CKEDITOR.replace('konten-edit')
    $('.textarea').wysihtml5()
  })
</script>   
<!-- Js Menu -->
<script type="text/javascript" src="../../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_artikel').addClass('active');
</script>
  <?php
}
?>