<section class="content-header">
  <h1>
  Manjemen Mata Pelajaran
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-book"></i> Mata Pelajaran</li>
  </ol>
</section>

<section class="content">
    <!-- mapel -->
    <?php 
    if (isset($_POST['tambah-mapel'])) {
      $mapel_nama    = $_POST['mapel_nama'];
      $mapel_keterangan = $_POST['mapel_keterangan'];

      $simpan_mapel = mysqli_query($koneksi, "INSERT INTO tbl_mapel VALUES(NULL, '$mapel_nama','$mapel_keterangan')");
      if ($simpan_mapel) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=mapel' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Mata Pelajaran berhasil disimpan.
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=mapel' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>: Mata Pelajaran gagal disimpan.
        </div>
        ";
      }
    }
    if (isset($_POST['perbarui-mapel'])) {
      $mapel_id       = base64_decode($_GET['mapel_id']);
      $nama           = $_POST['nama'];
      $tentang        = $_POST['tentang'];

      $perbarui_mapel  = mysqli_query($koneksi, "UPDATE tbl_mapel SET mapel_nama='$nama', mapel_keterangan='$tentang' WHERE mapel_id='$mapel_id'");
      if ($perbarui_mapel) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=mapel' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil !</strong> mapel telah diperbarui.
        </div>
        ";
        echo "<meta http-equiv='refresh'content='0;url=index.php?p=mapel' />";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=mapel' aria-hidden='true' class='close'>×</a>
          <strong>Gagal !</strong> mapel gagal diperbarui.
        </div>
        ";
      }
    }
    ?>

    <?php
    if(isset($_GET['mapel_id'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    }
    ?>

    <!-- konten mapel -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="<?php echo $tab_list_class; ?>">
            <a data-toggle="tab" href="#daftar">
              <i class="fa fa-bars fa-fw"></i>
              Daftar Mata Pelajaran
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#tambah">
              <i class="fa fa-plus fa-fw"></i>
              Tambah Mata Pelajaran
            </a>
          </li>
          <?php
          if(isset($_GET['mapel_id'])){
            echo "
            <li class='active'>
              <a href='#perbarui' data-toggle='tab'>
                <i class='fa fa-edit fa-fw'></i>
                Perbarui Mata Pelajaran
              </a>
            </li>";
          }
          ?>
        </ul>
      </header>

      <div class="panel-body">
        <!-- tab konten -->
        <div class="tab-content">
          <!-- data mapel -->
          <div id="daftar" class="<?php echo $tab_pane_class; ?>">
            <div class="panel">
              <div class="panel-body pan table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Mata Pelajaran</th>
                      <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $ambil_mapel = mysqli_query($koneksi, "SELECT * FROM tbl_mapel ORDER BY mapel_id DESC");
                    $no = 1;
                    while($mapel=mysqli_fetch_array($ambil_mapel)){
                    $mapel_bsd = base64_encode($mapel['mapel_id']);
                      ?>
                      <tr>
                        <td><?php echo $no . "."; ?></td>
                        <td>
                          <p><?=$mapel['mapel_nama'];?> &nbsp;
                            <?php
                            echo "<small class='label label-info'>Keterangan: $mapel[mapel_keterangan] </small>";
                            ?>
                          </p>
                        </td>
                        <td>
                          <a class="tooltips" data-toggle="tooltip" data-original-title="Edit Mata Pelajaran" data-placement="top" href="index.php?p=mapel&mapel_id=<?php echo $mapel_bsd;?>"><i class='fa fa-edit'></i>
                          </a>&nbsp;
                          <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Mata Pelajaran' href="halaman/hapus_mapel.php?id=<?php echo $mapel_bsd;?>" onclick="return confirm('Anda yakin akan menghapus mapel ini ?')"><i class='fa fa-trash-o'></i>
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
          </div> <!-- data mapel end -->

          <!-- tambah-mapel -->
          <div id="tambah" class="tab-pane fade">
            <section class="panel" style="margin-bottom:0px;">
              <header class="panel-heading tab-bg-primary text-center">
                <span>Form Tambah mapel</span>
              </header>
              <div class="panel-body pan">
                <form class="form-horizontal" id="form_mapel" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Nama Mata Pelajaran<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="mapel_nama" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Keterangan<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="mapel_keterangan" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="tambah-mapel" class="btn btn-primary">Simpan</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div> <!-- tambah mapel end -->

          <!-- edit mapel -->
          <?php
          if(isset($_GET['mapel_id'])){
            $mapel_id    = base64_decode($_GET['mapel_id']);
            $ambil_mapel = mysqli_query($koneksi, "SELECT * FROM tbl_mapel WHERE mapel_id='$mapel_id'");
            $ganti_mapel = mysqli_fetch_array($ambil_mapel);
            ?>
            <div id="perbarui" class="tab-pane fade in active">
              <section class="panel">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Ubah Mata Pelajaran</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Nama Mata Pelajaran</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="nama" value="<?php echo $ganti_mapel['mapel_nama'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Keterangan</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="tentang" value="<?php echo $ganti_mapel['mapel_keterangan'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="perbarui-mapel" class="btn btn-primary">Perbarui</button>
                        <a href="index.php?p=mapel" type="button" class="btn btn-default">Batal</a>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div>

            <?php
          } 
          ?><!-- edit mapel end -->
        </div><!-- tab konten end -->
      </div><!-- panel body end -->
    </section>
  </section>
<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_sekolah').addClass('active');
  $('#m_sekolah_akademik').addClass('active');
  $('#m_sekolah_akademik_mapel').addClass('active');
</script>