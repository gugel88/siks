<section class="content-header">
  <h1>
  Manjemen Guru
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-user"></i> Guru</li>
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

      $simpan_guru = mysqli_query($koneksi, "INSERT INTO tbl_guru(guru_nip,guru_img,guru_nama,guru_alamat,guru_tlp,guru_email,guru_desk,guru_jabatan,guru_walikelas,guru_status) VALUES('$guru_nip', '$guru_img', '$guru_nama', '$guru_alamat', '$guru_tlp', '$guru_email', '$guru_desk', '$guru_jabatan', '$guru_walikelas', 'aktif')");
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
    ?>


    <?php
    if(isset($_GET['guru_id'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    }
    ?>
    <!-- konten guru -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <?php
        if ($user['status'] == 'admin') {
          ?>
          <ul class="nav nav-tabs">
            <li class="<?php echo $tab_list_class; ?>">
              <a data-toggle="tab" href="#daftar">
                <i class="fa fa-bars fa-fw"></i>
                Daftar Guru
              </a>
            </li>
            <li>
              <a data-toggle="tab" href="#tambah">
                <i class="fa fa-plus fa-fw"></i>
                Tambah Guru
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

            <!-- data guru -->
            <div id="daftar" class="<?php echo $tab_pane_class; ?>">
              <div class="panel">
                <div class="panel-body pan table-responsive">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Foto Guru</th>
                        <th>Biodata Guru</th>
                        <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      include "../konfigurasi/enkripsi.php";
                      $ambil_guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru ORDER BY guru_id");
                      if (mysqli_num_rows($ambil_guru) > 0) {
                        $no = 1;
                        while ($guru = mysqli_fetch_array($ambil_guru)) {
                          $guru_id = base64_encode($guru['guru_id']);
                          $token = encrypt($guru_id);
                          ?>
                          <tr>
                            <td><?php echo $no . "."; ?></td>
                            <td><center><img height="80" width="80" class="img img-circle img-thumbnail" src="../img/guru/thumb_<?php echo $guru['guru_img'];?>"></center></td>
                            <td>
                              <p><?=$guru['guru_nama'];?> &nbsp;
                                <?php
                                if ($guru['guru_status'] == 'aktif') {
                                  echo "<small class='label label-warning'> <i class='fa fa-eye'></i> $guru[guru_status] </small>";
                                } else if ($guru['guru_status'] == 'tidak aktif') {
                                  echo "<small class='label label-danger'> <i class='fa fa-eye-slash'></i> $guru[guru_status] </small>";
                                }
                                ?>
                              </p>
                              <hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
                              <small>
                                <p>
                                  <i class="fa fa-envelope fa-fw"></i> <?=$guru['guru_email'];?> &nbsp;
                                  <i class="fa fa-phone fa-fw"></i> <?=$guru['guru_tlp'];?> &nbsp;
                                </p>
                              </small>
                            </td>
                            <td>
                              <a class="tooltips" data-toggle="tooltip" data-original-title="Edit Guru" data-placement="top" href="index.php?p=guruubah&guru_id=<?php echo $guru_id;?>&token=<?php echo encrypt($token);?>"><i class='fa fa-edit'></i>
                              </a>&nbsp;
                              <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Guru' href="halaman/hapus_guru.php?id=<?php echo $guru_id;?>&token=<?php echo encrypt($token);?>" onclick="return confirm('Anda yakin akan menghapus guru ini ?')"><i class='fa fa-trash-o'></i>
                              </a>&nbsp;
                              <?php
                              if ($guru['guru_status'] == 'aktif'){
                                $text = "tidak aktif";
                                $fa_class = "fa fa-eye-slash";
                              } else {
                                $text = "aktif";
                                $fa_class = "fa fa-eye";
                              }
                              ?>
                              <a class="tooltips" data-toggle="tooltip" title="<?=$text;?>" data-placement="top" href="halaman/guru_terbit.php?guru_id=<?php echo $guru['guru_id']; ?>&token=<?php echo encrypt($token);?>" onclick="return confirm('Anda yakin akan melakukan tindakan ini ?')"><i class='<?=$fa_class;?>'></i>
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
            </div> <!-- data guru end -->

            <!-- Form Tambah Guru -->
            <div id="tambah" class="tab-pane fade">
              <section class="panel" style="margin-bottom:0px;">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Tambah Guru</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" id="" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label class="col-lg-2 control-label">NIP<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_nip" id="" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Foto Guru<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_img" id="" value="default.jpg" readonly required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-lg-2 control-label">Nama Guru<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_nama" id="" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Alamat<span class="required"></span></label>
                      <div class="col-lg-10">
                        <textarea type="text" class="form-control" name="guru_alamat" required rows="3" style="overflow:auto;resize:none"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">No. Tlp<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_tlp" id="" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">E-mail<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_email" id="" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Deskripsi<span class="required"></span></label>
                      <div class="col-lg-10">
                        <textarea type="text" class="form-control" name="guru_desk" required id="konten-1"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Jabatan<span class="required"></span></label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="guru_jabatan" value="guru">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Wali Kelas<span class="required"></span></label>
                      <div class="col-lg-10">
                        <select class="form-control" name="guru_walikelas">
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
                        <button type="submit" name="tambah-guru" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-default">Kosongkan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div> <!-- tambah guru end -->
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
  $('#m_sekolah_guru').addClass('active');
</script>

  <?php  
} else if ($user['status'] == 'guru') {
  ?>
<!-- Js Menu -->
<script type="text/javascript" src="../../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_sekolah').addClass('active');
  $('#m_sekolah_guru').addClass('active');
</script>

  <?php
}
?>