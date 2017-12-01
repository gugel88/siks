<section class="content-header">
  <h1>
  Ubah Data siswa
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Ubah Data siswa</li>
  </ol>
</section>

<section class="content">

    <?php
    if (isset($_POST['tambah-siswa'])) {

      $siswa_nis     = $_POST['siswa_nis'];
      $siswa_img     = $_POST['siswa_img'];
      $siswa_nama    = $_POST['siswa_nama'];
      $siswa_kelamin = $_POST['siswa_kelamin'];
      $siswa_alamat  = $_POST['siswa_alamat'];
      $siswa_tlp     = $_POST['siswa_tlp'];
      $siswa_kelas   = $_POST['siswa_kelas'];
      $siswa_email   = $_POST['siswa_email']; 

      $simpan_siswa = mysqli_query($koneksi, "INSERT INTO tbl_siswa(siswa_nis,siswa_img,siswa_nama,siswa_kelamin,siswa_alamat,siswa_tlp,siswa_email,siswa_kelas,siswa_status) VALUES('$siswa_nis', '$siswa_img', '$siswa_nama', '$siswa_kelamin', '$siswa_alamat', '$siswa_tlp', '$siswa_email', '$siswa_kelas', 'aktif')");
      if ($simpan_siswa) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a href='index.php?p=siswa' type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil :</strong> siswa baru telah disimpan.
        </div>
        ";       
        echo "<meta http-equiv='refresh'content='0;url=index.php?p=siswa' />";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
          <strong>Gagal :</strong> siswa baru gagal disimpan.
        </div>
        ";
      }
    }
    if (isset($_POST['perbarui-siswa'])) {
      $siswa_id      = base64_decode($_GET['siswa_id']);
      $siswa_nis     = $_POST['siswa_nis'];
      $siswa_nama    = $_POST['siswa_nama'];
      $siswa_kelamin = $_POST['siswa_kelamin'];
      $siswa_alamat  = $_POST['siswa_alamat'];
      $siswa_tlp     = $_POST['siswa_tlp'];
      $siswa_kelas   = $_POST['siswa_kelas'];
      $siswa_email   = $_POST['siswa_email'];

      
      $perbarui_pengguna = mysqli_query($koneksi, "UPDATE tbl_siswa SET siswa_nis='$siswa_nis', siswa_nama='$siswa_nama', siswa_kelamin='$siswa_kelamin', siswa_alamat='$siswa_alamat', siswa_tlp='$siswa_tlp', siswa_kelas='$siswa_kelas', siswa_email='$siswa_email' WHERE siswa_id='$siswa_id'");
      if ($perbarui_pengguna) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          ";
          if ($_SESSION['status'] == 'admin') {
            echo "<a type='button' href='index.php?p=siswa' aria-hidden='true' class='close'>×</a>
            <meta http-equiv='refresh'content='0;url=index.php?p=siswa' />";
          } else if ($_SESSION['status'] == 'siswa') {
            echo "<button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>";
          }
          echo "
          <strong>Berhasil !</strong> Profil siswa telah diperbarui.
        </div>
        "; 
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
          <strong>Gagal :</strong> Profil siswa gagal diperbarui.
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
          $direktori          = "../img/siswa/";
          $file               = $direktori.$uploadName;
        } else if ($_SESSION['status'] == 'siswa') {
          $direktori          = "../../img/siswa/";
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

      $siswa_id      = base64_decode($_GET['siswa_id']);
      $gambar        = $_FILES['gambar']['tmp_name'];
      $gambar_name   = $_FILES['gambar']['name'];
      $gambar_type   = $_FILES['gambar']['type'];
      $gambar_size   = $_FILES['gambar']['size'];

      if ($gambar_size < 1044070) {
        Upload($gambar_name);
        $perbarui_pengguna = mysqli_query($koneksi, "UPDATE tbl_siswa SET siswa_img='$gambar_name' WHERE siswa_id='$siswa_id'");
        if ($perbarui_pengguna) {
          echo "
          <div class='alert alert-success alert-dismissable'>
            ";
            if ($_SESSION['status'] == 'admin') {
              echo "<a type='button' href='index.php?p=siswa' aria-hidden='true' class='close'>×</a>
              <meta http-equiv='refresh'content='0;url=index.php?p=siswa' />";
            } else if ($_SESSION['status'] == 'siswa') {
              echo "<button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>";
            }
            echo "
            <strong>Berhasil !</strong> Profil siswa telah diperbarui.
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


    <!-- konten siswa -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="active">
            <a data-toggle="tab" href="#daftar">
              <i class="fa fa-bars fa-fw"></i>
              Biodata siswa
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#perbarui">
              <i class="fa fa-plus fa-fw"></i>
              Perbarui Biodata siswa
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#poto">
              <i class="fa fa-image fa-fw"></i>
              Perbarui Foto siswa
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
                      } else if ($_SESSION['status'] == 'siswa') {
                        $link = "../..";
                      }
                      ?>

                    </div>
                    <div class="panel-body" style="padding-top:20px;">
                      <?php
                      if(isset($_GET['siswa_id'])){
                        $siswa_id    = base64_decode($_GET['siswa_id']);
                        $ambil_siswa = mysqli_query($koneksi, "SELECT * FROM tbl_siswa WHERE siswa_id='$siswa_id'");
                        $siswa       = mysqli_fetch_array($ambil_siswa);
                        
                        if ($_SESSION['status'] == 'admin') {
                          $link = "../";
                        } else if ($_SESSION['status'] == 'siswa') {
                          $link = "../../";
                        }
                        echo "<img src='$link/img/siswa/thumb_$siswa[siswa_img]' class='img-thumbnail pull-left' style='margin-top:8px; margin-right:15px;' />";
                        ?>
                        <h4>
                          <b style="text-transform:uppercase;"><?=$siswa['siswa_nama'];?></b> &nbsp;
                          <?php
                          if ($siswa['siswa_status'] == 'aktif') {
                            echo "<i class='text-info'>[ $siswa[siswa_status] ]</i></small>";
                          } else if ($siswa['siswa_status'] == 'tidak aktif') {
                            echo "<i class='text-danger'>[ $siswa[siswa_status] ]</i></small>";
                          }
                          ?>
                        </h4>
                        <p>nis : <?=$siswa['siswa_nis'];?>&nbsp;&nbsp;&nbsp;
                          <i class="fa fa-envelope-o"></i> <?=$siswa['siswa_email'];?>&nbsp;&nbsp;&nbsp;
                          <i class="fa fa-phone"></i> <?=$siswa['siswa_tlp'];?>
                        </p>
                        <hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
                        <p><i class="fa fa-map-marker"></i> <?=$siswa['siswa_alamat'];?></p>
                        <hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
                        <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div> <!-- tambah pengguna end -->
          <!-- edit siswa -->
          <?php
          if(isset($_GET['siswa_id'])){
            $siswa_id    = base64_decode($_GET['siswa_id']);
            $ambil_siswa = mysqli_query($koneksi, "SELECT * FROM tbl_siswa WHERE siswa_id='$siswa_id'");
            $siswa       = mysqli_fetch_array($ambil_siswa);
            ?>
            <div id="perbarui" class="tab-pane fade">
              <section class="panel">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Ubah siswa</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" id="" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label class="col-lg-2 control-label">NIS<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="siswa_nis" id="" required value="<?php echo $siswa['siswa_nis'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-lg-2 control-label">Nama Siswa<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="siswa_nama" id="" required value="<?php echo $siswa['siswa_nama'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-lg-2 control-label">Jenis Kelamin<span class="required"></span></label>
                      <div class="col-lg-10">
                      <select class='form-control' name='siswa_kelamin' required>
                        <option value="">-- Pilih --</option>
                        <option value="LAKI-LAKI" <?php if($siswa['siswa_kelamin'] == 'LAKI-LAKI'){ echo 'selected'; } ?>>LAKI-LAKI</option>
                        <option value="PEREMPUAN" <?php if($siswa['siswa_kelamin'] == 'PEREMPUAN'){ echo 'selected'; } ?>>PEREMPUAN</option> 
                      </select>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Alamat<span class="required"></span></label>
                      <div class="col-lg-10">
                        <textarea type="text" class="form-control" name="siswa_alamat" required rows="3" style="overflow:auto;resize:none"><?php echo $siswa['siswa_alamat'];?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">No. Tlp<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="siswa_tlp" id="" required value="<?php echo $siswa['siswa_tlp'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">E-mail<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="email" class="form-control" name="siswa_email" id="" required value="<?php echo $siswa['siswa_email'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-lg-2 control-label">Kelas<span class="required"></span></label>
                      <div class="col-lg-10">
                      <select class='form-control' name='siswa_kelas' required>
                        <?php $ambil_siswa = mysqli_query($koneksi, "SELECT kelas_nama FROM tbl_kelas"); 
                        while($qry = mysqli_fetch_array($ambil_siswa)){
                        if($qry['kelas_nama']==$siswa['siswa_kelas']){
                        echo "<option selected=\"selected\">$qry[kelas_nama]</option>";
                        }else{
                        echo "<option>$qry[kelas_nama]</option>";
                        }}
                        ?> 
                      </select>
                      </div>
                    </div>                     
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="perbarui-siswa" class="btn btn-success">Perbarui</button>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div>

            <?php
          } 
          ?><!-- edit siswa end -->
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
  $('#m_sekolah_siswa').addClass('active');
</script>

  <?php  
} else if ($user['status'] == 'siswa') {
  ?>
  <?php
}
?>