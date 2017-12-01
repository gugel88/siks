<section class="content-header">
  <h1>
  Manjemen Siswa
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-mortar-board"></i> Siswa</li>
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
    ?>


    <?php
    if(isset($_GET['siswa_id'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    }
    ?>
    <!-- konten siswa -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <?php
        if ($user['status'] == 'admin') {
          ?>
          <ul class="nav nav-tabs">
            <li class="<?php echo $tab_list_class; ?>">
              <a data-toggle="tab" href="#daftar">
                <i class="fa fa-bars fa-fw"></i>
                Daftar Siswa
              </a>
            </li>
            <li>
              <a data-toggle="tab" href="#tambah">
                <i class="fa fa-plus fa-fw"></i>
                Tambah Siswa
              </a>
            </li>
          </ul>
          <?php
        }
        ?>
      </header>

      <div class="panel-body">
        <!-- tab konten -->
        <div class="tab-content">

          <?php
          if ($user['status'] == 'admin') {
            ?>

            <!-- data siswa -->
            <div id="daftar" class="<?php echo $tab_pane_class; ?>">
              <div class="panel">
                <div class="panel-body pan table-responsive">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Foto Siswa</th>
                        <th>Biodata Siswa</th>
                        <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $ambil_siswa = mysqli_query($koneksi, "SELECT * FROM tbl_siswa ORDER BY siswa_id");
                      if (mysqli_num_rows($ambil_siswa) > 0) {
                        $no = 1;
                        while ($siswa = mysqli_fetch_array($ambil_siswa)) {
                          $siswa_id = base64_encode($siswa['siswa_id']);
                          ?>
                          <tr>
                            <td><?php echo $no . "."; ?></td>
                            <td><center><img height="80" width="80" class="img img-circle img-thumbnail" src="../img/siswa/thumb_<?php echo $siswa['siswa_img'];?>"></td></center>
                            <td>
                              <p><strong><?=$siswa['siswa_nama'];?></strong>
                                <small>[<?=$siswa['siswa_kelamin'];?>]</small>
                                &nbsp;
                                <?php
                                if ($siswa['siswa_status'] == 'aktif') {
                                  echo "<small class='label label-warning'> <i class='fa fa-eye'></i> $siswa[siswa_status] </small>";
                                } else if ($siswa['siswa_status'] == 'tidak aktif') {
                                  echo "<small class='label label-danger'> <i class='fa fa-eye-slash'></i> $siswa[siswa_status] </small>";
                                }
                                ?>
                              </p>
                              <p><small><i class="fa fa-trophy"></i> Kelas: <?=$siswa['siswa_kelas'];?></small</p>
                              <hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
                              <small>
                                <p>
                                  <i class="fa fa-map-marker fa-fw"></i>  <?=$siswa['siswa_alamat'];?>
                                </p>
                                <p>
                                  <i class="fa fa-envelope fa-fw"></i> <?=$siswa['siswa_email'];?> &nbsp;
                                  <i class="fa fa-phone fa-fw"></i> <?=$siswa['siswa_tlp'];?> &nbsp;
                                </p>
                              </small>
                            </td>
                            <td>
                              <a class="tooltips" data-toggle="tooltip" data-original-title="Edit Siswa" data-placement="top" href="index.php?p=siswaubah&siswa_id=<?php echo $siswa_id;?>"><i class='fa fa-edit'></i>
                              </a>&nbsp;
                              <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Siswa' href="halaman/hapus_siswa.php?id=<?php echo $siswa_id;?>" onclick="return confirm('Anda yakin akan menghapus siswa ini ?')"><i class='fa fa-trash-o'></i>
                              </a>&nbsp;
                              <?php
                              if ($siswa['siswa_status'] == 'aktif'){
                                $text = "tidak aktif";
                                $fa_class = "fa fa-eye-slash";
                              } else {
                                $text = "aktif";
                                $fa_class = "fa fa-eye";
                              }
                              ?>
                              <a class="tooltips" data-toggle="tooltip" title="<?=$text;?>" data-placement="top" href="halaman/siswa_terbit.php?siswa_id=<?php echo $siswa['siswa_id']; ?>" onclick="return confirm('Anda yakin akan melakukan tindakan ini ?')"><i class='<?=$fa_class;?>'></i>
                              </a>&nbsp;
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
            </div> <!-- data siswa end -->

            <!-- Form Tambah siswa -->
            <div id="tambah" class="tab-pane fade">
              <section class="panel" style="margin-bottom:0px;">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Tambah siswa</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" id="" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label class="col-lg-2 control-label">NIS<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="siswa_nis" id="" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Foto Siswa<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="siswa_img" id="" value="default.jpg" readonly required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-lg-2 control-label">Nama Siswa<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="siswa_nama" id="" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-lg-2 control-label">Jenis Kelamin</label>
                      <div class="col-lg-10">
                        <select class="form-control" name="siswa_kelamin" required>
                          <option value="">-- Pilih --</option>
                          <option value="LAKI-LAKI">LAKI-LAKI</option>
                          <option value="PEREMPUAN">PEREMPUAN</option>
                        </select>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Alamat<span class="required"></span></label>
                      <div class="col-lg-10">
                        <textarea type="text" class="form-control" name="siswa_alamat" required rows="3" style="overflow:auto;resize:none"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">No. Tlp<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="siswa_tlp" id="" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">E-mail<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="email" class="form-control" name="siswa_email" id="" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-lg-2 control-label">Kelas</label>
                      <div class="col-lg-10">
                        <select class="form-control" name="siswa_kelas" required>
                          <option value="">-- Pilih --</option>
                          <?php $ambil_kelas = mysqli_query($koneksi, "SELECT kelas_nama FROM tbl_kelas"); 
                          while($kelas = mysqli_fetch_array($ambil_kelas)){
                          echo "<option>$kelas[kelas_nama]</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>                     
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="tambah-siswa" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-default">Kosongkan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div> <!-- tambah siswa end -->
            <?php 
          }
          ?>
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