<section class="content-header">
  <h1>
  Manjemen Pengguna
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><i class="fa fa-users"></i> Pengguna</li>
  </ol>
</section>

<section class="content">

    <?php
    if (isset($_POST['tambah-pengguna'])) {

      $nm_pengguna   = $_POST['nm_pengguna'];
      $nm_tampilan   = $_POST['nm_tampilan'];
      $email         = $_POST['email'];
      $kata_sandi    = $_POST['kata_sandi'];
      $sandi_md5     = md5($kata_sandi);
      $status        = $_POST['status'];
      $guru_id       = $_POST['guru_id'];
      $gambar        = $_POST['gambar'];
      

      $simpan_pengguna = mysqli_query($koneksi, "INSERT INTO tbl_user(nm_pengguna,nm_tampilan,email,kata_sandi,sandi_md5,status,guru_id,gambar) VALUES('$nm_pengguna','$nm_tampilan','$email','$kata_sandi','$sandi_md5','$status','$guru_id','$gambar')");
      if ($simpan_pengguna) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a href='index.php?p=pengguna' type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil :</strong> Pengguna baru telah disimpan.
        </div>
        ";       
        echo "<meta http-equiv='refresh'content='0;url=index.php?p=pengguna' />";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
          <strong>Gagal :</strong> Pengguna baru gagal disimpan.
        </div>
        ";
      }
    }
    if (isset($_POST['perbarui-pengguna'])) {

      $id_user       = $_GET['id_user'];
      $nm_pengguna   = $_POST['nm_pengguna'];
      $nm_tampilan   = $_POST['nm_tampilan'];
      $email         = $_POST['email'];
      $kata_sandi    = $_POST['kata_sandi'];
      $sandi_md5     = md5($kata_sandi);
      $status        = $_POST['status'];

      $perbarui_pengguna = mysqli_query($koneksi, "UPDATE tbl_user SET nm_pengguna='$nm_pengguna', nm_tampilan='$nm_tampilan', email='$email', kata_sandi='$kata_sandi', sandi_md5='$sandi_md5', status='$status' WHERE id_user='$id_user'");
      if ($perbarui_pengguna) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a href='index.php?p=pengguna' type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil :</strong> Pengguna telah diperbarui.
        </div>
        ";       
        echo "<meta http-equiv='refresh'content='0;url=index.php?p=pengguna' />";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
          <strong>Gagal :</strong> Pengguna gagal diperbarui.
        </div>
        ";
      }
    }
    ?>

    <?php
    if(isset($_GET['id_user'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    }
    ?>
    <!-- konten pengguna -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="<?php echo $tab_list_class; ?>">
            <a data-toggle="tab" href="#daftar">
              <i class="fa fa-bars fa-fw"></i>
              Daftar Pengguna
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#tambah">
              <i class="fa fa-plus fa-fw"></i>
              Tambah Pengguna
            </a>
          </li>
          <?php
          if(isset($_GET['id_user'])){
            echo "
            <li class='active'>
              <a href='#perbarui' data-toggle='tab'>
                <i class='fa fa-edit fa-fw'></i>
                Perbarui Pengguna
              </a>
            </li>";
          }
          ?>
        </ul>
      </header>

      <div class="panel-body">
        <!-- tab konten -->
        <div class="tab-content">
          <!-- data pengguna -->
          <div id="daftar" class="<?php echo $tab_pane_class; ?>">
            <div class="panel">
              <div class="panel-body pan table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Foto Profil</th>
                      <th>Info Pengguna</th>
                      <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $ambil_pengguna = mysqli_query($koneksi, "SELECT * FROM tbl_user ORDER BY id_user");
                    if (mysqli_num_rows($ambil_pengguna) > 0) {
                      $no = 1;
                      while ($pengguna = mysqli_fetch_array($ambil_pengguna)) {
                        ?>
                        <tr>
                          <td><?php echo $no . "."; ?></td>
                          <td><img class="thumbnail" src="../img/user/thumb_<?php echo $pengguna['gambar'];?>"></td>
                          <td>
                            <p><?=$pengguna['nm_tampilan'];?> &nbsp;
                              <?php
                              if ($pengguna['status'] == 'admin') {
                                echo "<i class='text-info'>[ $pengguna[status] ]</i></small>";
                              } else if ($pengguna['status'] == 'guru') {
                                echo "<i class='text-success'>[ $pengguna[status] ]</i></small>";
                              } else if ($pengguna['status'] == 'pengunjung') {
                                echo "<i class='text-warning'>[ $pengguna[status] ]</i></small>";
                              }
                              ?>
                            </p>
                            <hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
                            <small>
                              <p>
                                <i class="fa fa-envelope fa-fw"></i> <?=$pengguna['email'];?> &nbsp;
                                <i class="fa fa-user fa-fw"></i> <?=$pengguna['nm_pengguna'];?> &nbsp;
                                <i class="fa fa-key fa-fw"></i> <?=$pengguna['kata_sandi'];?>
                              </p>
                            </small>
                          </td>
                          <td>
                            <a class="tooltips" data-toggle="tooltip" data-original-title="Edit Pengguna" data-placement="top" href="index.php?p=pengguna&id_user=<?php echo $pengguna['id_user'];?>"><i class='fa fa-edit'></i>
                            </a>&nbsp;
                            <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Pengguna' href="halaman/hapus_pengguna.php?id=<?php echo $pengguna['id_user']; ?>" onclick="return confirm('Anda yakin akan menghapus pengguna ini ?')"><i class='fa fa-trash-o'></i>
                            </a>
                          </td>
                        </tr>
                        <?php
                        $no++;
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div> <!-- data pengguna end -->

          <!-- tambah-pengguna -->
          <div id="tambah" class="tab-pane fade">
            <section class="panel" style="margin-bottom:0px;">
              <header class="panel-heading tab-bg-primary text-center">
                <span>Form Tambah Pengguna</span>
              </header>
              <div class="panel-body pan">
                <form class="form-horizontal" id="register_form" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label for="tampilan" class="col-lg-2 control-label">Nama Lengkap<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="nm_tampilan" id="tampilan" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="pengguna" class="col-lg-2 control-label">Nama Pengguna<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="nm_pengguna" id="pengguna" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-lg-2 control-label">Alamat E-mail<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="sandi" class="col-lg-2 control-label">Kata Sandi<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="password" class="form-control" name="kata_sandi" id="sandi" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="konfirmasi" class="col-lg-2 control-label">Konfirmasi Kata Sandi<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="password" class="form-control" name="sandi_md5" id="konfirmasi" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="kategorii" class="col-lg-2 control-label">Status<span class="required"></span></label>
                    <div class="col-lg-4">
                      <select for="kategori" name="status" id="kategori" class="form-control" required>
                        <option value="selected">--- Status Pengguna ---</option>
                        <option>admin</option>
                        <option>guru</option>
                      </select>
                    </div>
                    <label for="kategorii" class="col-lg-2 control-label">ID Guru<span class="required"></span></label>
                    <div class="col-lg-4">
                      <select name="guru_id" class="form-control">
                        <option value="#">-- Pilih ID Guru --</option>
                        <?php
                        $ambil_guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru ORDER BY guru_id");
                        while ($guru = mysqli_fetch_array($ambil_guru)) {
                          echo "
                          <option value='$guru[guru_id]'>$guru[guru_nama]</option>
                          ";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Gambar</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="gambar" value="default.jpg" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="tambah-pengguna" class="btn btn-primary">Simpan</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div> <!-- tambah pengguna end -->

          <!-- edit pengguna -->
          <?php
          if(isset($_GET['id_user'])){
            $id_user    = $_GET['id_user'];
            $ambil_pengguna = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE id_user='$id_user'");
            $pengguna = mysqli_fetch_array($ambil_pengguna);
            ?>
            <div id="perbarui" class="tab-pane fade in active">
              <section class="panel">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Ubah Pengguna</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" id="register_form" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label for="tampilan" class="col-lg-2 control-label">Nama Lengkap<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="nm_tampilan" id="tampilan" required value="<?php echo $pengguna['nm_tampilan'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="pengguna" class="col-lg-2 control-label">Nama Pengguna<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="nm_pengguna" id="pengguna" required value="<?php echo $pengguna['nm_pengguna'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email" class="col-lg-2 control-label">Alamat E-mail<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="email" class="form-control" name="email" id="email" required value="<?php echo $pengguna['email'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Status<span class="required"></span></label>
                      <div class="col-lg-4">
                      <select for="kategori" name="status" class="form-control" required>
                          <option value="<?php echo $pengguna['status'];?>"></option>
                          <option>admin</option>
                          <option>guru</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="sandi" class="col-lg-2 control-label">Kata Sandi<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="password" class="form-control" name="kata_sandi" id="sandi" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="konfirmasi" class="col-lg-2 control-label">Konfirmasi Kata Sandi<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="password" class="form-control" name="sandi_md5" id="konfirmasi" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="perbarui-pengguna" class="btn btn-primary">Perbarui</button>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div>

            <?php
          } 
          ?><!-- edit pengguna end -->


        </div><!-- tab konten end -->
      </div><!-- panel body end -->
    </section>
  </section>

<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_pengguna').addClass('active');
</script>