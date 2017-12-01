<section class="content-header">
  <h1>
  Manjemen Ruang Kelas
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-trophy"></i> Ruang Kelas</li>
  </ol>
</section>

<section class="content">
    <!-- kelas -->
    <?php 
    if (isset($_POST['tambah-kelas'])) {
      $kelas = $_POST['kelas'];
      $ruang = $_POST['ruang'];
      $kelas_nama = "$kelas $ruang";      
      $kelas_jumlahsiswa = $_POST['kelas_jumlahsiswa'];
      $kelas_thnajaran = $_POST['kelas_thnajaran'];

      $simpan_kelas = mysqli_query($koneksi, "INSERT INTO tbl_kelas VALUES(NULL, '$kelas_nama','$kelas_jumlahsiswa','$kelas_thnajaran')");
      if ($simpan_kelas) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=kelas' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: kelas baru telah disimpan.
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=kelas' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>: kelas gagal disimpan.
        </div>
        ";
      }
    }
    if (isset($_POST['perbarui-kelas'])) {
      $kelas_id = base64_decode($_GET['kelas_id']);
      $kelas = $_POST['kelas'];
      $ruang = $_POST['ruang'];
      $kelas_nama = "$kelas $ruang";      
      $kelas_jumlahsiswa = $_POST['kelas_jumlahsiswa'];
      $kelas_thnajaran = $_POST['kelas_thnajaran'];

      $perbarui_kelas  = mysqli_query($koneksi, "UPDATE tbl_kelas SET kelas_nama='$kelas_nama', kelas_jumlahsiswa='$kelas_jumlahsiswa', kelas_thnajaran='$kelas_thnajaran' WHERE kelas_id='$kelas_id'");
      if ($perbarui_kelas) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=kelas' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil !</strong> kelas telah diperbarui.
        </div>
        ";
        echo "<meta http-equiv='refresh'content='0;url=index.php?p=kelas' />";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=kelas' aria-hidden='true' class='close'>×</a>
          <strong>Gagal !</strong> kelas gagal diperbarui.
        </div>
        ";
      }
    }
    ?>

    <?php
    if(isset($_GET['kelas_id'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    }
    ?>

    <!-- konten kelas -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="<?php echo $tab_list_class; ?>">
            <a data-toggle="tab" href="#daftar">
              <i class="fa fa-bars fa-fw"></i>
              Daftar Ruang Kelas
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#tambah">
              <i class="fa fa-plus fa-fw"></i>
              Tambah Ruang Kelas
            </a>
          </li>
          <?php
          if(isset($_GET['kelas_id'])){
            echo "
            <li class='active'>
              <a href='#perbarui' data-toggle='tab'>
                <i class='fa fa-edit fa-fw'></i>
                Perbarui Ruang Kelas
              </a>
            </li>";
          }
          ?>
        </ul>
      </header>

      <div class="panel-body">
        <!-- tab konten -->
        <div class="tab-content">
          <!-- data kelas -->
          <div id="daftar" class="<?php echo $tab_pane_class; ?>">
            <div class="panel">
              <div class="panel-body pan table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Ruang Kelas</th>
                      <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include "../konfigurasi/enkripsi.php";
                    $ambil_kelas = mysqli_query($koneksi, "SELECT * FROM tbl_kelas ORDER BY kelas_id DESC");
                    $no = 1;
                    while($kelas = mysqli_fetch_array($ambil_kelas)){
                    $kelas_bsd = base64_encode($kelas['kelas_id']);
                    $token = encrypt($kelas_bsd);  
                      ?>
                      <tr>
                        <td><?php echo $no . "."; ?></td>
                        <td>
                          <p><?=$kelas['kelas_nama'];?> &nbsp;
                            <?php
                            echo "<small class='label label-info'>Jumlah Siswa: $kelas[kelas_jumlahsiswa] </small>";
                            ?>
                          </p>
                          <hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
                          <small>
                            <p>
                              <?php
                              echo "<i class='fa fa-calendar-check-o fa-fw'></i>Tahun Akademik: $kelas[kelas_thnajaran]";
                              ?>
                            </p>
                          </small>                          
                        </td>
                        <td>
                          <a class="tooltips" data-toggle="tooltip" data-original-title="Edit" data-placement="top" href="index.php?p=kelas&kelas_id=<?php echo $kelas_bsd;?>&token=<?php echo encrypt($token);?>"><i class='fa fa-edit'></i>
                          </a>&nbsp;
                          <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus' href="halaman/hapus_kelas.php?id=<?php echo $kelas_bsd; ?>&token=<?php echo encrypt($token);?>" onclick="return confirm('Anda yakin akan menghapus kelas ini ?')"><i class='fa fa-trash-o'></i>
                          </a>
                        </td>
                      </tr>
                      <?php
                      $no++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div> <!-- data kelas end -->


          <!-- tambah-kelas -->
          <div id="tambah" class="tab-pane fade">
            <section class="panel" style="margin-bottom:0px;">
              <header class="panel-heading tab-bg-primary text-center">
                <span>Form Tambah kelas</span>
              </header>
              <div class="panel-body pan">
                <form class="form-horizontal" id="form_kelas" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Nama Ruangan<span class="required"></span></label>
                    <div class="col-lg-2">
                      <select class="form-control" name="kelas">
                        <option value="VII">VII</option>
                        <option value="VIII">VIII</option>
                        <option value="IX">IX</option>
                      </select>
                    </div>
                    <div class="col-lg-2">
                      <select class="form-control" name="ruang"><?php for($i=1;$i<=10;$i++){echo "<option>$i</option>"; } ?></select>
                    </div>                    
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Jumlah Siswa<span class="required"></span></label>
                    <div class="col-lg-4">
                      <select class="form-control" name="kelas_jumlahsiswa">
                        <?php for($i=1;$i<=45;$i++){echo "<option>$i</option>";}?>
                      </select>                      
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Tahun Pelajaran<span class="required"></span></label>
                    <div class="col-lg-4">
                      <input type="text" class="form-control" name="kelas_thnajaran" required>
                    </div>
                  </div>                  
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="tambah-kelas" class="btn btn-primary">Simpan</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div> <!-- tambah kelas end -->

          <!-- edit kelas -->
          <?php
          if(isset($_GET['kelas_id'])){
            $kelas_id    = base64_decode($_GET['kelas_id']);
            $ambil_kelas = mysqli_query($koneksi, "SELECT * FROM tbl_kelas WHERE kelas_id='$kelas_id'");
            $ganti_kelas = mysqli_fetch_array($ambil_kelas);
            $ambil_kelas = explode(" ",$ganti_kelas['kelas_nama']);
            ?>
            <div id="perbarui" class="tab-pane fade in active">
              <section class="panel">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Ubah Ruang Kelas</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <input type="hidden" name="kelas_id" value="<?php echo $_GET['kelas_id'] ?>"/>                    
                    <label class="col-lg-2 control-label">Nama Ruangan<span class="required"></span></label>
                    <div class="col-lg-2">
                    <select class="form-control" name="kelas">
                      <option selected="selected"><?php echo $ambil_kelas[0]?></option>
                      <option value="VII">VII</option>
                      <option value="VIII">VIII</option>
                      <option value="IX">IX</option>
                    </select>
                    </div>
                    <div class="col-lg-2">
                    <select class="form-control" name="ruang">
                      <option selected="selected"><?php echo $ambil_kelas[1]?></option>
                      <?php for($i=1;$i<=10;$i++){echo "<option>$i</option>"; } ?>
                    </select>
                    </div>                    
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Jumlah Siswa<span class="required"></span></label>
                    <div class="col-lg-4">
                    <select class="form-control" name="kelas_jumlahsiswa">
                      <option selected="selected"><?php echo $ganti_kelas['kelas_jumlahsiswa'];?></option>
                      <?php for($i=1;$i<=45;$i++){echo "<option>$i</option>";}?>
                    </select>                   
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Tahun Pelajaran<span class="required"></span></label>
                    <div class="col-lg-4">
                      <input type="text" class="form-control" name="kelas_thnajaran" value="<?php echo $ganti_kelas['kelas_thnajaran'];?>" required>
                    </div>
                  </div>                   
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="perbarui-kelas" class="btn btn-success">Perbarui</button>
                        <a href="index.php?p=kelas" type="button" class="btn btn-danger">Batal</a>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div>

            <?php
          } 
          ?><!-- edit kelas end -->
        </div><!-- tab konten end -->
      </div><!-- panel body end -->
    </section>
  </section>
<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_sekolah').addClass('active');
  $('#m_sekolah_akademik').addClass('active');
  $('#m_sekolah_akademik_kelas').addClass('active');
</script>