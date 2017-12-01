<section class="content-header">
  <h1>
  Profil
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><i class="fa fa-user"></i> Profil</li>
  </ol>
</section>

<section class="content">         
    <div class="row state-overview">
      <div class="col-lg-12">
        <br>
        <div class="panel">
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
            if ($_SESSION['status'] == 'admin') {
              $link = "../";
            } else if ($_SESSION['status'] == 'guru') {
              $link = "../../";
            }
            echo "<img src='$link/img/user/thumb_$_SESSION[gambar]' class='img-thumbnail pull-left' style='margin-top:-50px; margin-right:15px;' />";
            ?>
            <h4>
              <b style="text-transform:uppercase;"><?=$_SESSION['nm_tampilan'];?></b>
              <i class="text-info">[ <?=$_SESSION['status'];?> ]</i>
            </h4>
          </div>
        </div>
      </div>
    </div>

    <!-- proses perbarui profil -->
    <?php
    if (isset($_POST['perbarui-profil'])) {
      $nm_tampilan  = $_POST['edit_nm_tampilan'];
      $nm_pengguna  = $_POST['edit_nm_pengguna'];
      $email        = $_POST['edit_email'];

      $errors        = array();

      $cek_pengguna_lain = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE id_user!=$_SESSION[id_user]");
      while ($pengguna_lain = mysqli_fetch_array($cek_pengguna_lain)){
        if ($pengguna_lain['nm_pengguna'] == $nm_pengguna ) {
          $errors[] = "
          <div class='form-group'>
            <div class='col-sm-12'><center><span class='text-danger'><i class='fa fa-warning fa-fw'></i> Maaf, nama pengguna telah terdaftar dalam basis data !</span>  <a href='index.php?p=profilku'<i class='fa fa-refresh'></i> Ulangi</a></center></div>
          </div>
          ";
        } else if ($pengguna_lain['email'] == $email ) {
          $errors[] = "
          <div class='form-group'>
            <div class='col-sm-12'><center><span class='text-danger'><i class='fa fa-warning fa-fw'></i> Maaf, alamat e-mail ini telah terdaftar dalam basis data !</span>  <a href='index.php?p=profilku'<i class='fa fa-refresh'></i> Ulangi</a></center></div>
          </div>
          ";
        }
      }

      if (count($errors) > 0){
        foreach($errors AS $error){
          echo $error;
        }
      } else {
        $perbarui_profil = mysqli_query($koneksi, "UPDATE tbl_user SET nm_tampilan='$nm_tampilan', email='$email', nm_pengguna='$nm_pengguna' WHERE id_user='$_SESSION[id_user]'");
        if ($perbarui_profil) {
          if ($_SESSION['status']=='admin') {
            $link = "logout.php";
          } else if ($_SESSION['status']=='guru') {
            $link = "../logout.php";
          }
          echo "
          <div class='form-group'>
            <div class='col-sm-12'><center><span class='text-success'>Profil berhasil diperbarui, silakan masuk lagi <i class='fa fa-spin fa-spinner fa-fw'></i></span></center></div>
          </div>
          ";
          echo "<meta http-equiv='refresh' content='3;url=$link' />";
        } else {
          echo "
          <div class='form-group'>
            <div class='col-sm-12'><center><span class='text-danger'><i class='fa fa-warning fa-fw'></i> Gagal, profil gagal diperbarui. Silakan ulangi !</span></center></div>
          </div>
          ";
        }
      }
    }
    ?>

    <!-- proses perbarui katasandi -->
    <?php
    if (isset($_POST['perbarui-sandi'])) {
      $ambil_pengguna = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE id_user='$_SESSION[id_user]'");
      $pengguna = mysqli_fetch_array($ambil_pengguna);

      $katasandi_lama       = $_POST['katasandi_lama'];
      $katasandi_baru       = $_POST['katasandi_baru'];
      $katasandi_konfirmasi = $_POST['katasandi_konfirmasi'];
      $e_kata_sandi         = md5($katasandi_baru);


      if ($katasandi_lama==$pengguna['kata_sandi']) {
        if ($katasandi_baru==$katasandi_konfirmasi) {
          $update_sandi = mysqli_query($koneksi, "UPDATE tbl_user SET kata_sandi='$katasandi_baru', sandi_md5='$e_kata_sandi' WHERE id_user='$_SESSION[id_user]'");
          if ($update_sandi) {
            echo "
            <div class='form-group'>
              <div class='col-sm-12'><center><span class='text-success'>Kata sandi berhasil diganti, silakan masuk lagi <i class='fa fa-spin fa-spinner fa-fw'></i></span></center></div>
            </div>
            ";
            if ($_SESSION['status']=='admin') {
              echo "<meta http-equiv='refresh' content='2;url=logout.php' />";
            } else if ($_SESSION['status']=='guru') {
              echo "<meta http-equiv='refresh' content='2;url=../logout.php' />";
            }
          } else {
            echo "
            <div class='form-actions pal'>
              <span class='text-danger'>Kata sandi gagal diganti <i class='fa fa-warning fa-fw'></i></span>
            </div>
            ";
          }
        } else {
          echo "
          <div class='form-actions pal'>
            <center><span class='text-danger'><i class='fa fa-warning fa-fw'></i> Konfirmasi kata sandi tidak cocok </span></center>
          </div>
          ";
        }
      } else {
        echo "
        <div class='form-actions pal'>
          <center><span class='text-danger'>Kata sandi lama salah <i class='fa fa-warning fa-fw'></i></span></center>
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
        $direktori          = "../img/user/";
        $file               = $direktori.$uploadName;
      } else if ($_SESSION['status'] == 'guru') {
        $direktori          = "../../img/user/";
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
        $thumbWidth1        = 65;
        $thumbHeight1       = 65;
        $thumbWidth2        = 29;
        $thumbHeight2       = 29;

    //mengubah ukuran gambar 1
        $thumbImage1 = imagecreatetruecolor($thumbWidth1, $thumbHeight1);
        imagecopyresampled($thumbImage1, $realImages, 0,0,0,0, $thumbWidth1, $thumbHeight1, $width, $height);
    //mengubah ukuran gambar 2
        $thumbImage2 = imagecreatetruecolor($thumbWidth2, $thumbHeight2);
        imagecopyresampled($thumbImage2, $realImages, 0,0,0,0, $thumbWidth2, $thumbHeight2, $width, $height);

    //simpan gambar thumbnail 1
        imagejpeg($thumbImage1,$direktori."thumb_".$uploadName);
    //simpan gambar thumbnail 2
        imagejpeg($thumbImage2,$direktori."kc_".$uploadName);

    //hapus objek gambar dalam memori
        imagedestroy($realImages);
        imagedestroy($thumbImage1);
        imagedestroy($thumbImage2);

    //hapus gambar utama
        unlink($direktori.$uploadName);
      }

      $gambar        = $_FILES['gambar']['tmp_name'];
      $gambar_name   = $_FILES['gambar']['name'];
      $gambar_type   = $_FILES['gambar']['type'];
      $gambar_size   = $_FILES['gambar']['size'];

      if ($gambar_size < 1044070) {
        Upload($gambar_name);
        $perbarui_pengguna = mysqli_query($koneksi, "UPDATE tbl_user SET gambar='$gambar_name' WHERE id_user='$_SESSION[id_user]'");
        if ($perbarui_pengguna) {
          echo "
          <div class='alert alert-success alert-dismissable'>
            <a href='index.php?p=profilku' type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</a>
            <strong>Berhasil :</strong> Foto Profil telah diperbarui.
          </div>
          ";       
          echo "<meta http-equiv='refresh'content='0;url=index.php?p=profilku' />";
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

    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="active">
            <a data-toggle="tab" href="#profil">
              Perbarui Profil
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#katasandi">
              Perbarui Kata Sandi
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#poto">
              Perbarui Gambar Profil
            </a>
          </li>
        </ul>
      </header>
      <div class="panel-body">
        <div class="tab-content">
          <!-- profile -->
          <?php
          $ambil_pengguna = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE id_user='$_SESSION[id_user]'");
          $pengguna_detail     = mysqli_fetch_array($ambil_pengguna);
          ?>
          <div id="profil" class="tab-pane fade in active">
            <section class="panel">
              <div class="panel-body pan">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Nama Lengkap</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="edit_nm_tampilan" value="<?php echo $pengguna_detail['nm_tampilan'];?>"">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Nama Pengguna</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="edit_nm_pengguna" value="<?php echo $pengguna_detail['nm_pengguna'];?>"">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Alamat E-mail</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="edit_email" value="<?php echo $pengguna_detail['email'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Kata Sandi</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" readonly value="<?php echo $pengguna_detail['kata_sandi'];?>"">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="perbarui-profil" class="btn btn-success">
                        Perbarui
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>

          <!-- katasandi -->
          <div id="katasandi" class="tab-pane fade">
            <section class="panel" style="margin-bottom:0px;">
              <div class="panel-body pan">
                <form class="form-horizontal" id="register_form" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Kata Sandi Lama<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="katasandi_lama" readonly value="<?php echo $pengguna_detail['kata_sandi'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="sandi" class="col-lg-2 control-label">Kata Sandi Baru<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="password" class="form-control" name="katasandi_baru" id="sandi" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="konfirmasi" class="col-lg-2 control-label">Konfirmasi Kata Sandi<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="password" class="form-control" name="katasandi_konfirmasi" id="konfirmasi" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="perbarui-sandi" class="btn btn-success">Perbarui</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>

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

        </div>
      </div>
    </section>
  </section>

<?php
if ($user['status'] == 'admin') {
  ?>
  <!-- javascripts -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.scrollTo.min.js"></script>
  <script type="text/javascript" src="js/jquery.nicescroll.js"></script>
  <script type="text/javascript" src="js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/form-validation-script.js"></script>
  <script type="text/javascript" src="assets/jquery-knob/js/jquery.knob.js"></script>
  <script type="text/javascript" src="js/scripts.js"></script>

  <script>

      //knob
    $(".knob").knob();

  </script>

  <?php  
} else if ($user['status'] == 'guru') {
  ?>

  <!-- javascripts -->
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/jquery.scrollTo.min.js"></script>
  <script type="text/javascript" src="../js/jquery.nicescroll.js"></script>
  <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="../js/form-validation-script.js"></script>
  <script type="text/javascript" src="../assets/jquery-knob/js/jquery.knob.js"></script>
  <script type="text/javascript" src="../js/scripts.js"></script>

  <script>

      //knob
    $(".knob").knob();

  </script>

  <?php
}
?>