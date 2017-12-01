<section class="content-header">
  <h1>
  Manjemen Komentar
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-comment-o"></i> Komentar</li>
  </ol>
</section>

<section class="content">

    <!-- data bukutamu -->
    <div class="row">
      <div class="col-lg-12">
        <section class="panel">
          <header class="panel-heading tab-bg-primary">
            Daftar Komentar
          </header>
              <div class="panel-body pan table-responsive">
              <table id="example1" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Komentar</th>
                  <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($_SESSION['status']=='admin') {
                  include "../konfigurasi/enkripsi.php";
                  $ambil_komentar = mysqli_query($koneksi, "SELECT tbl_user.*, tbl_komentar.* FROM tbl_user, tbl_komentar WHERE tbl_user.id_user=tbl_komentar.id_user ORDER BY tbl_komentar.komentar_tgl DESC");
                } else if ($_SESSION['status']=='guru') {
                  include "../../konfigurasi/enkripsi.php";
                  $ambil_komentar = mysqli_query($koneksi, "SELECT tbl_user.*, tbl_artikel.*, tbl_komentar.* FROM tbl_user, tbl_artikel, tbl_komentar WHERE tbl_user.id_user=tbl_komentar.id_user AND tbl_artikel.artikel_id=tbl_komentar.artikel_id AND tbl_artikel.id_user='$user[id_user]' ORDER BY tbl_komentar.komentar_tgl DESC");
                }
                if (mysqli_num_rows($ambil_komentar) > 0) {
                  $no = 1;
                  while ($komentar = mysqli_fetch_array($ambil_komentar)) {
                    $ubah_tanggal = mysqli_query($koneksi, "SELECT DATE_FORMAT('$komentar[komentar_tgl]', '%d %b %Y - %r') AS tanggal");
                    $tanggal      = mysqli_fetch_array($ubah_tanggal);
                    $komentar_date = $tanggal['tanggal'];
                    $komentar_bsd     = base64_encode($komentar['komentar_id']);
                    $token = encrypt($komentar_bsd);
                    if ($_SESSION['status']=='admin') {
                      $img_link = "..";
                      $a_link   = "halaman";
                    } else if ($_SESSION['status']=='guru') {
                      $img_link = "../..";
                      $a_link   = "../halaman";
                    }

                    ?>
                    <tr>
                      <td><?php echo $no . "."; ?></td>
                      <td>
                        <p>Dari : <?=$komentar['nm_tampilan'];?> &nbsp;
                          <?php
                          if ($_SESSION['status']=='admin') {
                            if (($komentar['komentar_status']=='2') || ($komentar['komentar_status']=='3')) {
                              echo "<small class='label label-info'><i class='fa fa-thumbs-o-up'></i> baru </small>";
                            }
                          } else if ($_SESSION['status']=='guru') {
                            if (($komentar['komentar_status']=='2') || ($komentar['komentar_status']=='1')) {
                              echo "<small class='label label-info'><i class='fa fa-thumbs-o-up'></i> baru </small>";
                            }
                          }
                          ?> 
                        </p>
                        <p><i class="fa fa-angle-right fa-fw"></i><?=$komentar['komentar_konten'];?></p>
                      </td>
                      <td class="pull-center">
                        <p>
                          <i class="date tooltips" data-toggle="tooltip" data-original-title="$komentar_date" class="fa fa-calendar-o"></i> &nbsp;&nbsp;
                          <a class="tooltips" data-toggle="tooltip" data-original-title="Hapus" href="<?=$a_link;?>/hapus_komentar.php?id=<?php echo $komentar_bsd ?>&token=<?php echo $token ?>" onclick="return confirm('Anda yakin akan menghapus komentar ini ?')"><i class="fa fa-trash-o"></i></a> &nbsp;&nbsp;
                          <a class="tooltips" data-toggle="tooltip" data-original-title="Lihat" href="<?=$a_link;?>/komentar_buka.php?id=<?php echo $komentar_bsd ?>&token=<?php echo $token ?>" target="blank"><i class="fa fa-search-plus"></i></a>
                        </p>
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
        </section>
      </div>
    </div>

  </section>

<?php
if ($user['status'] == 'admin') {
  ?>
<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_artikel').addClass('active');
  $('#m_artikel_komentar').addClass('active');
</script>
  <?php  
} else if ($user['status'] == 'guru') {
  ?>
<!-- Js Menu -->
<script type="text/javascript" src="../../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_komentar').addClass('active');
</script>
  <?php
}
?>