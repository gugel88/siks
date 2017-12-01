<section class="content-header">
  <h1>
  Ubah Data Guru
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><i class="fa fa-user"></i> Ubah Data Guru</li>
  </ol>
</section>

<section class="content">

    <?php
    if (isset($_POST['tambah-guru'])) {

      $guru_nip     = $_POST['guru_nip'];
      $guru_img     = $_POST['guru_img'];
      $guru_nama    = $_POST['guru_nama'];
      $guru_alamat  = $_POST['guru_alamat'];
      $guru_tlp     = $_POST['guru_tlp'];
      $guru_email   = $_POST['guru_email'];
      $guru_desk    = $_POST['guru_desk'];
      $guru_jabatan = $_POST['guru_jabatan'];
      $guru_walikelas = $_POST['guru_walikelas'];  

      $simpan_guru = mysqli_query($koneksi, "INSERT INTO tbl_guru(guru_nip,guru_img,guru_nama,guru_alamat,guru_tlp,guru_email,guru_desk,guru_jabatan, guru_walikelas,guru_status) VALUES('$guru_nip', '$guru_img', '$guru_nama', '$guru_alamat', '$guru_tlp', '$guru_email', '$guru_desk', '$guru_jabatan', '$guru_walikelas' 'aktif')");
      if ($simpan_guru) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a href='index.php?p=guru' type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil :</strong> guru baru telah disimpan.
        </div>
        ";       
        echo "<meta http-equiv='refresh'content='0;url=index.php?p=guru' />";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
          <strong>Gagal :</strong> guru baru gagal disimpan.
        </div>
        ";
      }
    }
    if (isset($_POST['perbarui-guru'])) {
      $guru_id      = base64_decode($_GET['guru_id']);
      $guru_nip     = $_POST['guru_nip'];
      $guru_nama    = $_POST['guru_nama'];
      $guru_alamat  = $_POST['guru_alamat'];
      $guru_tlp     = $_POST['guru_tlp'];
      $guru_email   = $_POST['guru_email'];
      $guru_desk    = $_POST['guru_desk'];
      $guru_jabatan = $_POST['guru_jabatan'];
      $guru_walikelas = $_POST['guru_walikelas'];

      $perbarui_pengguna = mysqli_query($koneksi, "UPDATE tbl_guru SET guru_nip='$guru_nip', guru_nama='$guru_nama', guru_alamat='$guru_alamat', guru_tlp='$guru_tlp', guru_email='$guru_email', guru_desk='$guru_desk', guru_jabatan='$guru_jabatan', guru_walikelas='$guru_walikelas' WHERE guru_id='$guru_id'");
      if ($perbarui_pengguna) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          ";
          if ($_SESSION['status'] == 'admin') {
            echo "<a type='button' href='index.php?p=guru' aria-hidden='true' class='close'>×</a>
            <meta http-equiv='refresh'content='0;url=index.php?p=guru' />";
          } else if ($_SESSION['status'] == 'guru') {
            echo "<button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>";
          }
          echo "
          <strong>Berhasil !</strong> Profil guru telah diperbarui.
        </div>
        "; 
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
          <strong>Gagal :</strong> Profil guru gagal diperbarui.
        </div>
        ";
      }
    }
    ?>
    <?php
    if (isset($_POST['perbarui-gambar'])) {
      // membuat fungsi resize gambar thumbnail
      function Upload($uploadName){
        if ($_SESSION['status'] == 'admin') {
          $direktori          = "../img/guru/";
          $file               = $direktori.$uploadName;
        } else if ($_SESSION['status'] == 'guru') {
          $direktori          = "../../img/guru/";
          $file               = $direktori.$uploadName;
        }

    //simpan gambar ukuran sebenernya
        $realImagesName     = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($realImagesName, $file);

    //identitas file gambar
        $realImages         = imagecreatefromjpeg($file);
        $width              = imageSX($realImages);
        $height             = imageSY($realImages);

    //simpan ukuran thumbnail
        $thumbWidth        = 270;
        $thumbHeight       = 270;

    //mengubah ukuran gambar 1
        $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresampled($thumbImage, $realImages, 0,0,0,0, $thumbWidth, $thumbHeight, $width, $height);

    //simpan gambar thumbnail 1
        imagejpeg($thumbImage,$direktori."thumb_".$uploadName);

    //hapus objek gambar dalam memori
        imagedestroy($realImages);
        imagedestroy($thumbImage);

    //hapus gambar utama
        unlink($direktori.$uploadName);
      }

      $guru_id      = base64_decode($_GET['guru_id']);
      $gambar        = $_FILES['gambar']['tmp_name'];
      $gambar_name   = $_FILES['gambar']['name'];
      $gambar_type   = $_FILES['gambar']['type'];
      $gambar_size   = $_FILES['gambar']['size'];

      if ($gambar_size < 1044070) {
        Upload($gambar_name);
        $perbarui_pengguna = mysqli_query($koneksi, "UPDATE tbl_guru SET guru_img='$gambar_name' WHERE guru_id='$guru_id'");
        if ($perbarui_pengguna) {
          echo "
          <div class='alert alert-success alert-dismissable'>
            ";
            if ($_SESSION['status'] == 'admin') {
              echo "<a type='button' href='index.php?p=guru' aria-hidden='true' class='close'>×</a>
              <meta http-equiv='refresh'content='0;url=index.php?p=guru' />";
            } else if ($_SESSION['status'] == 'guru') {
              echo "<button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>";
            }
            echo "
            <strong>Berhasil !</strong> Profil guru telah diperbarui.
          </div>
          ";
        } else {
          echo "
          <div class='alert alert-danger alert-dismissable'>
            <button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
            <strong>Gagal :</strong> Foto Profil gagal diperbarui.
          </div>
          ";
        }
      } else {
        echo "<script>alert('Ukuran gambar terlalu besar. Maksimal 2Mb.')</script>";
      }
    }
    ?>


    <!-- konten guru -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="active">
            <a data-toggle="tab" href="#daftar">
              <i class="fa fa-bars fa-fw"></i>
              Biodata Guru
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#perbarui">
              <i class="fa fa-plus fa-fw"></i>
              Perbarui Biodata Guru
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#poto">
              <i class="fa fa-image fa-fw"></i>
              Perbarui Foto Guru
            </a>
          </li>
        </ul>    
      </header>

      <div class="panel-body">
        <!-- tab konten -->
        <div class="tab-content">
          <!-- tambah-pengguna -->
          <div id="daftar" class="tab-pane fade in active">
            <section class="panel" style="margin-bottom:0px;">
              <div class="row">
                <div class="col-lg-12">
                  <div class="panel panel-default">
                    <div class="panel-body" style="padding:0;">
                      <?php
                      if ($_SESSION['status'] == 'admin') {
                        $link = "../";
                      } else if ($_SESSION['status'] == 'guru') {
                        $link = "../..";
                      }
                      ?>

                    </div>
                    <div class="panel-body" style="padding-top:20px;">
                      <?php
                      include "../../konfigurasi/enkripsi.php";
                      if(isset($_GET['guru_id'])){
                        $guru_id    = base64_decode($_GET['guru_id']);
                        $token = encrypt($guru_id);
                        $ambil_guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru WHERE guru_id='$guru_id'");
                        $guru       = mysqli_fetch_array($ambil_guru);
                        
                        if ($_SESSION['status'] == 'admin') {
                          $link = "../";
                        } else if ($_SESSION['status'] == 'guru') {
                          $link = "../../";
                        }
                        echo "<img src='$link/img/guru/thumb_$guru[guru_img]' class='img-thumbnail pull-left' style='margin-top:8px; margin-right:15px;' />";
                        ?>
                        <h4>
                          <b style="text-transform:uppercase;"><?=$guru['guru_nama'];?></b> &nbsp;
                          <?php
                          if ($guru['guru_status'] == 'aktif') {
                            echo "<i class='text-info'>[ $guru[guru_status] ]</i></small>";
                          } else if ($guru['guru_status'] == 'tidak aktif') {
                            echo "<i class='text-danger'>[ $guru[guru_status] ]</i></small>";
                          }
                          ?>
                        </h4>
                        <p>NIP : <?=$guru['guru_nip'];?>&nbsp;&nbsp;&nbsp;
                          <i class="fa fa-envelope-o"></i> <?=$guru['guru_email'];?>&nbsp;&nbsp;&nbsp;
                          <i class="fa fa-phone"></i> <?=$guru['guru_tlp'];?>
                        </p>
                        <hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
                        <p><i class="fa fa-map-marker"></i> <?=$guru['guru_alamat'];?></p>
                        <hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
                        <br>
                        <p><?=$guru['guru_desk'];?></p>

                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div> <!-- tambah pengguna end -->
          <!-- edit guru -->
          <?php
          if(isset($_GET['guru_id'])){
            $guru_id    = base64_decode($_GET['guru_id']);
            $ambil_guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru WHERE guru_id='$guru_id'");
            $guru       = mysqli_fetch_array($ambil_guru);
            ?>
            <div id="perbarui" class="tab-pane fade">
              <section class="panel">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Ubah guru</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" id="" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label class="col-lg-2 control-label">NIP<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_nip" id="" required value="<?php echo $guru['guru_nip'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-lg-2 control-label">Nama guru<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_nama" id="" required value="<?php echo $guru['guru_nama'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Alamat<span class="required"></span></label>
                      <div class="col-lg-10">
                        <textarea type="text" class="form-control" name="guru_alamat" required rows="3" style="overflow:auto;resize:none"><?php echo $guru['guru_alamat'];?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">No. Tlp<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_tlp" id="" required value="<?php echo $guru['guru_tlp'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">E-mail<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_email" id="" required value="<?php echo $guru['guru_email'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Deskripsi<span class="required"></span></label>
                      <div class="col-lg-10">
                        <textarea type="text" class="form-control" name="guru_desk" required id="konten-1"><?php echo $guru['guru_desk'];?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Jabatan<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_jabatan" required value="<?php echo $guru['guru_jabatan'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Wali Kelas<span class="required"></span></label>
                      <div class="col-lg-10">
                        <select class="form-control" name="guru_walikelas">
                          <option selected="selected"><?php echo $guru['guru_walikelas'] ?></option>
                          <option value="" disabled>-- Pilih Kelas --</option>
                          <option value="Tidak">Tidak</option>
                          <?php $ambil_kelas = mysqli_query($koneksi, "SELECT kelas_nama FROM tbl_kelas");
                          while ($kelas = mysqli_fetch_array($ambil_kelas)){
                          echo "<option>$kelas[kelas_nama]</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="perbarui-guru" class="btn btn-success">Perbarui</button>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div>

            <?php
          } 
          ?><!-- edit guru end -->
          <!-- gambar -->
          <div id="poto" class="tab-pane fade">
            <section class="panel" style="margin-bottom:0px;">
              <div class="panel-body pan">
                <form class="form-horizontal" id="register_form" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label for="gambar" class="col-lg-2 control-label">Gambar<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="file" class="form-control" name="gambar" id="gambar" required value="<?php echo $pengguna_detail['gambar'];?>">
                      <small>* pilih ekstensi gambar tipe JPG <b>( disarankan gambar bentuk kotak ukuran 65x65px )</b></small>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="perbarui-gambar" class="btn btn-success">Perbarui</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>
        </div><!-- tab konten end -->
      </div><!-- panel body end -->
    </section>
  </section>


<?php
if ($user['status'] == 'admin') {
  ?>
<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_sekolah').addClass('active');
  $('#m_sekolah_guru').addClass('active');
</script>

  <?php  
} else if ($user['status'] == 'guru') {
  ?>
<!-- Js Menu -->
<script type="text/javascript" src="../../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_pengguna').addClass('active');
</script>

  <?php
}
?>