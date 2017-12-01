<section class="content-header">
  <h1>
  Manjemen Pengumuman
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-bullhorn"></i> Pengumuman</li>
  </ol>
</section>

<section class="content">
    <!-- pengumuman -->
    <?php 
    if (isset($_POST['tambah-pengumuman'])) {
      $pengumuman_isi    = $_POST['pengumuman_isi'];
      $simpan_pengumuman = mysqli_query($koneksi, "INSERT INTO tbl_pengumuman(pengumuman_isi,pengumuman_status) VALUES('$pengumuman_isi','unpublish')");
      if ($simpan_pengumuman) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=pengumuman' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Mata Pelajaran berhasil disimpan.
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=pengumuman' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>: Mata Pelajaran gagal disimpan.
        </div>
        ";
      }
    }
    if (isset($_POST['perbarui-pengumuman'])) {
      $pengumuman_id       = base64_decode($_GET['pengumuman_id']);
      $pengumuman_isi           = $_POST['pengumuman_isi'];

      $perbarui_pengumuman  = mysqli_query($koneksi, "UPDATE tbl_pengumuman SET pengumuman_isi='$pengumuman_isi' WHERE pengumuman_id='$pengumuman_id'");
      if ($perbarui_pengumuman) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=pengumuman' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil !</strong> pengumuman telah diperbarui.
        </div>
        ";
        echo "<meta http-equiv='refresh'content='0;url=index.php?p=pengumuman' />";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=pengumuman' aria-hidden='true' class='close'>×</a>
          <strong>Gagal !</strong> pengumuman gagal diperbarui.
        </div>
        ";
      }
    }
    ?>

    <?php
    if(isset($_GET['pengumuman_id'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    }
    ?>

    <!-- konten pengumuman -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="<?php echo $tab_list_class; ?>">
            <a data-toggle="tab" href="#daftar">
              <i class="fa fa-bars fa-fw"></i>
              Daftar Pengumuman
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#tambah">
              <i class="fa fa-plus fa-fw"></i>
              Tambah Pengumuman
            </a>
          </li>
          <?php
          if(isset($_GET['pengumuman_id'])){
            echo "
            <li class='active'>
              <a href='#perbarui' data-toggle='tab'>
                <i class='fa fa-edit fa-fw'></i>
                Perbarui Pengumuman
              </a>
            </li>";
          }
          ?>
        </ul>
      </header>

      <div class="panel-body">
        <!-- tab konten -->
        <div class="tab-content">
          <!-- data pengumuman -->
          <div id="daftar" class="<?php echo $tab_pane_class; ?>">
            <div class="panel">
              <div class="panel-body pan table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Isi Pengumuman</th>
                      <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    include "../konfigurasi/enkripsi.php";
                    $ambil_pengumuman = mysqli_query($koneksi, "SELECT * FROM tbl_pengumuman ORDER BY pengumuman_id DESC");
                    $no = 1;
                    while($pengumuman=mysqli_fetch_array($ambil_pengumuman)){
                    $pengumuman_bsd = base64_encode($pengumuman['pengumuman_id']);
                    $token = encrypt($pengumuman_bsd);
                      ?>
                      <tr>
                        <td><?php echo $no . "."; ?></td>
                        <td>
                          <p><?=$pengumuman['pengumuman_isi'];?>
                            <?php
                              if ($pengumuman['pengumuman_status'] == 'publish') {
                                echo "<small class='label label-warning'> <i class='fa fa-eye'></i> $pengumuman[pengumuman_status] </small>";
                              } else if ($pengumuman['pengumuman_status'] == 'unpublish') {
                                echo "<small class='label label-danger'> <i class='fa fa-eye-slash'></i> $pengumuman[pengumuman_status] </small>";
                              }
                            ?>      
                          </p>
                        </td>
                        <td>
                          <a class="tooltips" data-toggle="tooltip" data-original-title="Edit" data-placement="top" href="index.php?p=pengumuman&pengumuman_id=<?php echo $pengumuman_bsd;?>&token=<?php echo encrypt($token);?>"><i class='fa fa-edit'></i>
                          </a>&nbsp;
                          <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus' href="halaman/hapus_pengumuman.php?id=<?php echo $pengumuman_bsd;?>&token=<?php echo encrypt($token);?>" onclick="return confirm('Anda yakin akan menghapus pengumuman ini ?')"><i class='fa fa-trash-o'></i>
                          </a>&nbsp;
                          <?php
                            if ($pengumuman['pengumuman_status'] == 'publish'){
                            $text = "unpublish";
                            $fa_class = "fa fa-eye-slash";
                            } else {
                            $text = "publish";
                            $fa_class = "fa fa-eye";
                            }
                          ?>
                          <a class="tooltips" data-toggle="tooltip" title="<?=$text;?>" data-placement="top" href="halaman/pengumuman_terbit.php?pengumuman_id=<?php echo $pengumuman_bsd;?>&token=<?php echo encrypt($token);?>" onclick="return confirm('Anda yakin akan melakukan tindakan ini ?')"><i class='<?=$fa_class;?>'></i>
                          </a>&nbsp;                          
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
          </div> <!-- data pengumuman end -->

          <!-- tambah-pengumuman -->
          <div id="tambah" class="tab-pane fade">
            <section class="panel" style="margin-bottom:0px;">
              <header class="panel-heading tab-bg-primary text-center">
                <span>Form Tambah pengumuman</span>
              </header>
              <div class="panel-body pan">
                <form class="form-horizontal" id="form_pengumuman" role="form" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Isi Pengumuman<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="pengumuman_isi" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="tambah-pengumuman" class="btn btn-primary">Simpan</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div> <!-- tambah pengumuman end -->

          <!-- edit pengumuman -->
          <?php
          if(isset($_GET['pengumuman_id'])){
            $pengumuman_id    = base64_decode($_GET['pengumuman_id']);
            $ambil_pengumuman = mysqli_query($koneksi, "SELECT * FROM tbl_pengumuman WHERE pengumuman_id='$pengumuman_id'");
            $ganti_pengumuman = mysqli_fetch_array($ambil_pengumuman);
            ?>
            <div id="perbarui" class="tab-pane fade in active">
              <section class="panel">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Ubah Pengumuman</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Isi Pengumuman</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="pengumuman_isi" value="<?php echo $ganti_pengumuman['pengumuman_isi'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="perbarui-pengumuman" class="btn btn-primary">Perbarui</button>
                        <a href="index.php?p=pengumuman" type="button" class="btn btn-default">Batal</a>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div>

            <?php
          } 
          ?><!-- edit pengumuman end -->
        </div><!-- tab konten end -->
      </div><!-- panel body end -->
    </section>
  </section>
<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_pengumuman').addClass('active');
</script>