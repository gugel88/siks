<section class="content-header">
  <h1>
  Manjemen Buku Tamu
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-envelope"></i> Buku Tamu</li>
  </ol>
</section>

<section class="content">
    <!-- data bukutamu -->
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <header class="panel-heading tab-bg-primary">
            Daftar Buku Tamu
          </header>
          <div class="panel-body pan table-responsive">
            <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th> Buku Tamu</th>
                  <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $ambil_bukutamu = mysqli_query($koneksi, "SELECT * FROM tbl_bukutamu ORDER BY buku_id DESC");
                $no = 1;
                while($bukutamu=mysqli_fetch_array($ambil_bukutamu)){
                  ?>

                  <tr>
                    <td><?php echo $no . "."; ?></td>
                    <td>
                      <p><b>Pengirim : <?=$bukutamu['buku_nama'];?></b>&nbsp;<small>( <?=$bukutamu['buku_email'];?> / <?=$bukutamu['buku_tlp'];?> )</small></p>
                      <p><i>"<?=$bukutamu['buku_pesan'];?>"</i> &nbsp;
                        <?php 
                        if ($bukutamu['buku_status'] == 'baru') {
                          echo "<small class='label label-primary'><i class='fa fa-thumbs-o-up'></i> baru </small>";
                        } elseif ($bukutamu['buku_status'] == 'sudah dibaca') {
                          echo "<small class='label label-primary'><i class='fa fa-eye'></i> sudah dibaca </small>";
                        }
                        ?>
                      </p>
                    </td>
                    <td>
                      <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Pesan' href="halaman/hapus_bukutamu.php?id=<?php echo $bukutamu['buku_id']; ?>" onclick="return confirm('Anda yakin akan menghapus bukutamu ini ?')"><i class='fa fa-trash-o'></i>
                      </a>&nbsp;
                      <?php
                      if ($bukutamu['buku_status'] == 'baru') {
                        echo "

                        <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Baca Pesan' href='halaman/bukutamu_buka.php?id=$bukutamu[buku_id]'><i class='fa fa-eye'></i>
                        </a>
                        ";
                      }
                      ?>
                    </td>
                  </tr>

                  <?php
                  $no++;
                }
                ?>
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </div>

  </section>

<!-- javascripts -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/form-validation-script.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="assets/datatable/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/datatable/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>

<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_bukutamu').addClass('active');
</script>