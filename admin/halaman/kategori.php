<section class="content-header">
  <h1>
  Manjemen Kategori Artikel
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-tag"></i> Kategori</li>
  </ol>
</section>

<section class="content">
    <!-- kategori -->
    <?php 
    if (isset($_POST['tambah-kategori'])) {
      $kategori_nama    = $_POST['kategori_nama'];
      $kategori_tentang = $_POST['kategori_tentang'];

      $simpan_kategori = mysqli_query($koneksi, "INSERT INTO tbl_kategori VALUES(NULL, '$kategori_nama','$kategori_tentang')");
      if ($simpan_kategori) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=kategori' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Kategori baru telah disimpan.
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=kategori' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>: Kategori gagal disimpan.
        </div>
        ";
      }
    }
    if (isset($_POST['perbarui-kategori'])) {
      $kategori_id    = $_GET['kategori_id'];
      $nama           = $_POST['nama'];
      $tentang        = $_POST['tentang'];

      $perbarui_kategori  = mysqli_query($koneksi, "UPDATE tbl_kategori SET kategori_nama='$nama', kategori_tentang='$tentang' WHERE kategori_id='$kategori_id'");
      if ($perbarui_kategori) {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=kategori' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil !</strong> kategori telah diperbarui.
        </div>
        ";
        echo "<meta http-equiv='refresh'content='0;url=index.php?p=kategori' />";
      } else {
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=kategori' aria-hidden='true' class='close'>×</a>
          <strong>Gagal !</strong> kategori gagal diperbarui.
        </div>
        ";
      }
    }
    ?>

    <?php
    if(isset($_GET['kategori_id'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    }
    ?>

    <!-- konten kategori -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="<?php echo $tab_list_class; ?>">
            <a data-toggle="tab" href="#daftar">
              <i class="fa fa-bars fa-fw"></i>
              Daftar Kategori
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#tambah">
              <i class="fa fa-plus fa-fw"></i>
              Tambah Kategori
            </a>
          </li>
          <?php
          if(isset($_GET['kategori_id'])){
            echo "
            <li class='active'>
              <a href='#perbarui' data-toggle='tab'>
                <i class='fa fa-edit fa-fw'></i>
                Perbarui Kategori
              </a>
            </li>";
          }
          ?>
        </ul>
      </header>

      <div class="panel-body">
        <!-- tab konten -->
        <div class="tab-content">
          <!-- data kategori -->
          <div id="daftar" class="<?php echo $tab_pane_class; ?>">
            <div class="panel">
              <div class="panel-body pan table-responsive">               
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Kategori</th>
                      <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $ambil_kategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori ORDER BY kategori_id DESC");
                    $no = 1;
                    while($kategori=mysqli_fetch_array($ambil_kategori)){
                      ?>
                      <tr>
                        <td><?php echo $no . "."; ?></td>
                        <td>
                          <p><?=$kategori['kategori_nama'];?> &nbsp; 
                            <?php
                            if ($kategori['kategori_tentang'] == 'artikel') {
                              echo "<small class='label label-info'> $kategori[kategori_tentang]</small>";
                            } else if ($kategori['kategori_tentang'] == 'galeri') {
                              echo "<i class='text-success'>[ $kategori[kategori_tentang] ]</i></small>";
                            }
                            ?>
                          </p>
                        </td>
                        <td>
                          <a class="tooltips" data-toggle="tooltip" data-original-title="Edit Kategori" data-placement="top" href="index.php?p=kategori&kategori_id=<?php echo $kategori['kategori_id'];?>"><i class='fa fa-edit'></i>
                          </a>&nbsp;
                          <a class='tooltips' data-toggle='tooltip' data-placement='top' title='Hapus Kategori' href="halaman/hapus_kategori.php?id=<?php echo $kategori['kategori_id']; ?>" onclick="return confirm('Anda yakin akan menghapus kategori ini ?')"><i class='fa fa-trash-o'></i>
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
          </div> <!-- data kategori end -->

          <!-- tambah-kategori -->
          <div id="tambah" class="tab-pane fade">
            <section class="panel" style="margin-bottom:0px;">
              <header class="panel-heading tab-bg-primary text-center">
                <span>Form Tambah Kategori</span>
              </header>
              <div class="panel-body pan">
                <form class="form-horizontal" id="form_kategori" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Nama Kategori<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="kategori_nama" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Tentang Kategori<span class="required"></span></label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" name="kategori_tentang" value="artikel" required disabled>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="tambah-kategori" class="btn btn-primary">Simpan</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div> <!-- tambah kategori end -->

          <!-- edit kategori -->
          <?php
          if(isset($_GET['kategori_id'])){
            $kategori_id    = $_GET['kategori_id'];
            $ambil_kategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori WHERE kategori_id='$kategori_id'");
            $ganti_kategori = mysqli_fetch_array($ambil_kategori);
            ?>
            <div id="perbarui" class="tab-pane fade in active">
              <section class="panel">
                <header class="panel-heading tab-bg-primary text-center">
                  <span>Form Ubah Kategori</span>
                </header>
                <div class="panel-body pan">
                  <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Nama Kategori</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="nama" value="<?php echo $ganti_kategori['kategori_nama'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Kategori Tentang</label>
                      <div class="col-lg-10">
                        <input type="text" class="form-control" name="tentang" value="<?php echo $ganti_kategori['kategori_tentang'];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" name="perbarui-kategori" class="btn btn-success">Perbarui</button>
                        <a href="index.php?p=kategori" type="button" class="btn btn-danger">Batal</a>
                      </div>
                    </div>
                  </form>
                </div>
              </section>
            </div>

            <?php
          } 
          ?><!-- edit kategori end -->
        </div><!-- tab konten end -->
      </div><!-- panel body end -->
    </section>
  </section>


<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_artikel').addClass('active');
  $('#m_artikel_kategori').addClass('active');
</script>