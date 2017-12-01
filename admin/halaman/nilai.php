<section class="content-header">
  <h1>
  Manjemen Nilai Siswa
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-bar-chart"></i> Nilai Siswa</li>
  </ol>
</section>

<section class="content">
    <!-- proses tambah Nilai Siswa -->
    <?php 
    if (isset($_POST['tambah-nilai'])) {
    $kelas        =$_POST['kelas'];
    $semester     =$_POST['semester'];
    $tahun        =$_POST['tahun'];
    $siswa        =$_POST['siswa'];
    $mapel        =$_POST['mapel'];
    $afektif      =$_POST['afektif'];
    $komulatif    =$_POST['komulatif'];
    $psikomotorik =$_POST['psikomotorik'];
    $rata         = ($afektif+$komulatif+$psikomotorik)/3;
    $simpan_nilai = mysqli_query($koneksi, "INSERT INTO tbl_nilai VALUES ('$siswa','$mapel','$semester','$tahun','$afektif','$komulatif','$psikomotorik','$rata')");
      if(!$simpan_nilai){
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=nilai_siswa' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>: Nilai Siswa gagal disimpan.
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=nilai_siswa' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Nilai Siswa baru telah disimpan.
        </div>
        ";
      }
    }
    if (isset($_POST['perbarui-nilai'])) {
      $idmapel = ($_GET['idmapel']);
      $idkelas = ($_GET['idkelas']);
      $idkelas = ($_GET['idkelas']);
      //proses
      $kelas      = $_POST['kelas'];
      $mapel      = $_POST['mapel'];
      $hari       = $_POST['hari'];
      $jam        = "$_POST[jammulai]:$_POST[menitmulai] - $_POST[jamakhir]:$_POST[menitakhir]";
      $guru       = $_POST['guru'];
      //ambil id
      $kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT kelas_id FROM tbl_kelas WHERE kelas_nama = '$kelas'"));
      $plj = mysqli_fetch_array(mysqli_query($koneksi, "SELECT mapel_id FROM tbl_mapel WHERE mapel_nama = '$mapel'"));
      $gr = mysqli_fetch_array(mysqli_query($koneksi, "SELECT guru_id FROM tbl_guru WHERE guru_nama = '$guru'"));
      //simpan jadwal
      $simpan_jadwal = mysqli_query($koneksi, "UPDATE tbl_jadpel SET mapel_id='$plj[mapel_id]', kelas_id='$kls[kelas_id]', hari='$hari', jam='$jam' WHERE mapel_id='$idmapel' AND kelas_id='$idkelas' ");
      $simpan_jadwal2 = mysqli_query($koneksi, "UPDATE tbl_guru_mapel SET guru_id='$gr[guru_id]', mapel_id='$plj[mapel_id]', kelas_id='$kls[kelas_id]' WHERE mapel_id='$idmapel' AND kelas_id='$idkelas'");
      if(!$simpan_jadwal || !$simpan_jadwal2){
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=nilai_siswa' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>: Nilai Siswa gagal diperbarui. Karena: 
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=nilai_siswa' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Nilai Siswa baru berhasil diperbarui.
        </div>
        ";
      }
    }
    ?>

    <?php
    if(isset($_GET['id_mapel'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    } if(isset($_GET['id_siswa'])){
      $tab_list_class = '';
      $tab_pane_class = 'tab-pane fade';
    } else {
      $tab_list_class = 'active';
      $tab_pane_class = 'tab-pane fade in active';
    } if(isset($_GET['idmapel'])){
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
              Daftar Siswa
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#tambah">
              <i class="fa fa-plus fa-fw"></i>
              Tambah Nilai Siswa
            </a>
          </li>
          <?php
          if(isset($_GET['idmapel'])){
            echo "
            <li class='active'>
              <a href='#perbarui' data-toggle='tab'>
                <i class='fa fa-edit fa-fw'></i>
                Perbarui Nilai Siswa
              </a>
            </li>";
          }
          ?>
          <?php
          if(isset($_GET['id_siswa'])){
            echo "
            <li class='active'>
              <a href='#rincian' data-toggle='tab'>
                <i class='fa fa-search-plus fa-fw'></i>
                Rincian Nilai
              </a>
            </li>";
          }
          ?>          
        </ul>
      </header>
      <div class="panel-body">
        <div class="tab-content">
          <div id="daftar" class="<?php echo $tab_pane_class; ?>">
            <section class="panel">
              <div class="panel-body pan table-responsive">          
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Rincian Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ambil_kelas = mysqli_query($koneksi, "SELECT * FROM tbl_siswa");
                      $no = 1;
                      while($hasil=mysqli_fetch_array($ambil_kelas)){
                      ?>
                          <tr>
                            <td><?php echo $no . "."; ?></td>
                            <td><?php echo $hasil['siswa_nis'];?></td>
                            <td><?php echo $hasil['siswa_nama'];?></td>
                            <td><?php echo $hasil['siswa_kelas'];?></td>
                            <td><a class="tooltips" data-toggle="tooltip" data-original-title="Rincian Nilai" data-placement="top" href='index.php?p=nilai_siswa&id_siswa=<?php echo $hasil['siswa_id'];?>&nissiswa=<?php echo $hasil['siswa_nis'];?>&namasiswa=<?php echo $hasil['siswa_nama'];?>&kelassiswa=<?php echo $hasil['siswa_kelas'];?>'><i class='fa fa-search-plus'></i>
                              </a></td>
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
          <div id="tambah" class="tab-pane fade">
            <section class="panel" style="margin-bottom:0px;">
              <div class="panel-body pan">
                <form class="form-horizontal" id="form_kelas" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Kelas</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="kelas" required>
                        <option value="">-- Pilih Kelas --</option>
                          <?php
                          $ambil_kelas = mysqli_query($koneksi, "SELECT * FROM tbl_kelas ORDER BY kelas_id");
                          while ($kelas = mysqli_fetch_array($ambil_kelas)) {
                            echo "<option value='$kelas[kelas_id]'>$kelas[kelas_nama]</option>";
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Semester</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="semester" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>                        
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Tahun Pelajaran</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="tahun" required>
                        <option value="">-- Pilih Tahun Pelajaran --</option>
                        <?php for($i=2017;$i<=2100;$i++){$a = $i+1; echo "<option>$i-$a</option>";}?>                                             
                      </select>
                    </div>
                  </div>                  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Mata Pelajaran</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="mapel" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                          <?php
                          $ambil_mapel = mysqli_query($koneksi, "SELECT * FROM tbl_mapel ORDER BY mapel_id");
                          while ($mapel = mysqli_fetch_array($ambil_mapel)) {
                            echo "<option value='$mapel[mapel_id]'>$mapel[mapel_nama]</option>";
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Nama Siswa</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="siswa" required>
                        <option value="">-- Pilih Nama Siswa --</option>
                          <?php
                          $ambil_siswa = mysqli_query($koneksi, "SELECT * FROM tbl_siswa ORDER BY siswa_id");
                          while ($siswa = mysqli_fetch_array($ambil_siswa)) {
                            echo "<option value='$siswa[siswa_id]'>$siswa[siswa_nama]</option>";
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Nilai Siswa</label>
                    <div class="col-lg-5">
                      <table>
                        <tr>
                          <td>
                            <select name="afektif" required>
                              <option value="">Afektif</option>
                              <?php for($i=0;$i<=100;$i++){echo "<option>$i</option>";}?>
                            </select>
                          </td>
                          <td>&nbsp;</td>
                          <td>
                            <select name="komulatif" required>
                              <option value="">Komulatif</option>
                              <?php for($i=0;$i<=100;$i++){echo "<option>$i</option>";}?>
                            </select>                          
                          </td>
                          <td>&nbsp;</td>
                          <td>
                            <select name="psikomotorik" required>
                              <option value="">Psikomotorik</option>
                              <?php for($i=0;$i<=100;$i++){echo "<option>$i</option>";}?>
                            </select>                          
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>                                  
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="tambah-nilai" class="btn btn-primary">Simpan</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>
          <!-- end Tambah Nilai Siswa -->
          <!-- Rincian Nilai Siswa -->
          <?php          
          if(isset($_GET['id_siswa'])){
          $siswa = $_GET['id_siswa'];
          $nis = $_GET['nissiswa'];
          $nama = $_GET['namasiswa'];
          $kelas = $_GET['kelassiswa'];
          ?>         
          <div id="rincian" class="tab-pane fade in active">
              <section class="invoice">
                <!-- title row -->
              <?php
              $q = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_siswa WHERE siswa_id = '$siswa' ORDER BY siswa_nama DESC"));
              ?>                
                <div class="row">
                  <div class="col-xs-12">
                    <h2 class="page-header">
                      <i class="fa fa-bar-chart"></i> Rincian Nilai Siswa 
                      <small class="pull-right">Tanggal: <?php $tgl=date('d/m/Y'); echo $tgl;?></small>
                    </h2>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    <address>
                      <strong>IDENTITAS SISWA</strong><br>
                      Nama Siswa: <?php echo $q['siswa_nama'];?><br>
                      NIS: <?php echo $q['siswa_nis'];?><br>
                      Kelas: <?php echo $q['siswa_kelas'];?><br>
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6 invoice-col">
                    <?php
                    $ambil = mysqli_query($koneksi, "SELECT * FROM tbl_nilai WHERE siswa_id = '$siswa' ORDER BY thn_ajaran DESC");
                    $nilai= mysqli_fetch_array($ambil);
                    ?>
                    Semester: <?php echo $nilai['semester'];?><br>
                    Tahun Ajaran: <?php echo $nilai['thn_ajaran'];?><br>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                      <tr>
                        <th>No.</th>
                        <th>Mata Pelajaran</th>
                        <th>Nilai Afektif</th>
                        <th>Nilai Komulatif</th>
                        <th>Nilai Psikomotorik</th>
                        <th>Nilai Rata-rata</th>
                        <th>Keterangan</th>
                        <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php
                        $ambil = mysqli_query($koneksi, "SELECT * FROM tbl_nilai WHERE siswa_id = '$siswa' ORDER BY thn_ajaran DESC");
                        $no = 1;                    
                        while ($nilai= mysqli_fetch_array($ambil)){
                        $plj = mysqli_fetch_array(mysqli_query($koneksi, "SELECT mapel_nama FROM tbl_mapel WHERE mapel_id = '$nilai[mapel_id]'"));
                        $kls2 = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_kelas WHERE kelas_id"));
                        ?>                          
                        <tr>
                          <td><?php echo $no . "."; ?></td>
                          <td><?php echo $plj['mapel_nama'];?></td>
                          <td><?php echo $nilai['afektif'];?></td>
                          <td><?php echo $nilai['komulatif'];?></td>
                          <td><?php echo $nilai['psikomotorik'];?></td>
                          <td><?php echo $nilai['rata'];?></td>
                          <td>Belum di hitung</td>
                          <td>
                            <a class="tooltips" data-toggle="tooltip" data-original-title="Edit" data-placement="top" href="index.php?p=nilai_siswa&idmapel=<?php echo $nilai['mapel_id'];?>&idkelas=<?php echo $kls2['kelas_id'];?>&idsiswa=<?php echo $nilai['siswa_id'];?>"><i class='fa fa-edit'></i>
                            </a>&nbsp;
                            <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus' href="halaman/hapus_nilai.php?id=<?php echo $kelas_bsd; ?>" onclick="return confirm('Anda yakin akan menghapus kelas ini ?')"><i class='fa fa-trash-o'></i>
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
                <div class="row no-print">
                  <div class="col-xs-12">
                    <a href="index.php?p=nilai_siswa"> <button type="button" class="btn btn-default btn-flat">
                      <i class="fa fa-close"></i> Tutup
                    </button>
                    </a>                    
                    <button type="button" class="btn btn-default btn-flat pull-right" style="margin-right: 5px;">
                      <i class="fa fa-print"></i> Cetak
                    </button>
                  </div>
                </div>                
              </section>
          </div>
          <?php
          } 
          ?>
          <!-- end Rincian Nilai Siswa -->            
          <!-- Edit Nilai Siswa -->
          <?php
          if(isset($_GET['idmapel'])){
          $idmapel = $_GET['idmapel'];
          $idkelas = $_GET['idkelas'];
          $idsiswa = $_GET['idsiswa'];
          $id = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_guru_mapel NATURAL JOIN tbl_jadpel WHERE kelas_id = '$idkelas' AND mapel_id = $idmapel"));
          $jam = explode(" - ",$id['jam']);
          $kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT kelas_nama FROM tbl_kelas WHERE kelas_id = '$idkelas'"));
          $pljrn = mysqli_fetch_array(mysqli_query($koneksi, "SELECT mapel_nama FROM tbl_mapel WHERE mapel_id = '$idmapel'"));
          $ss = mysqli_fetch_array(mysqli_query($koneksi, "SELECT siswa_nama FROM tbl_siswa WHERE siswa_id = '$idsiswa'"));
          ?>          
          <div id="perbarui" class="tab-pane fade in active">
            <section class="panel" style="margin-bottom:0px;">
              <header class="panel-heading tab-bg-primary text-center">
              </header>
              <div class="panel-body pan">
                <form class="form-horizontal" id="form_kelas" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Kelas</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="kelas" required>
                        <option value="">-- Pilih Kelas --</option>
                          <?php
                          $ambil_kelas = mysqli_query($koneksi, "SELECT * FROM tbl_kelas ORDER BY kelas_id");
                          while ($kelas = mysqli_fetch_array($ambil_kelas)) {
                            echo "<option value='$kelas[kelas_id]'>$kelas[kelas_nama]</option>";
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Semester</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="semester" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>                        
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Tahun Pelajaran</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="tahun" required>
                        <option value="">-- Pilih Tahun Pelajaran --</option>
                        <?php for($i=2017;$i<=2100;$i++){$a = $i+1; echo "<option>$i-$a</option>";}?>                                             
                      </select>
                    </div>
                  </div>                  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Mata Pelajaran</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="mapel" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                          <?php
                          $ambil_mapel = mysqli_query($koneksi, "SELECT * FROM tbl_mapel ORDER BY mapel_id");
                          while ($mapel = mysqli_fetch_array($ambil_mapel)) {
                            echo "<option value='$mapel[mapel_id]'>$mapel[mapel_nama]</option>";
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Nama Siswa</label>
                    <div class="col-lg-5">
                      <select class="form-control" name="siswa" required>
                        <option value="">-- Pilih Nama Siswa --</option>
                          <?php
                          $ambil_siswa = mysqli_query($koneksi, "SELECT * FROM tbl_siswa ORDER BY siswa_id");
                          while ($siswa = mysqli_fetch_array($ambil_siswa)) {
                            echo "<option value='$siswa[siswa_id]'>$siswa[siswa_nama]</option>";
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Nilai Siswa</label>
                    <div class="col-lg-5">
                      <table>
                        <tr>
                          <td>
                            <select name="afektif" required>
                              <option value="">Afektif</option>
                              <?php for($i=0;$i<=100;$i++){echo "<option>$i</option>";}?>
                            </select>
                          </td>
                          <td>&nbsp;</td>
                          <td>
                            <select name="komulatif" required>
                              <option value="">Komulatif</option>
                              <?php for($i=0;$i<=100;$i++){echo "<option>$i</option>";}?>
                            </select>                          
                          </td>
                          <td>&nbsp;</td>
                          <td>
                            <select name="psikomotorik" required>
                              <option value="">Psikomotorik</option>
                              <?php for($i=0;$i<=100;$i++){echo "<option>$i</option>";}?>
                            </select>                          
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>                                  
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="tambah-nilai" class="btn btn-primary">Simpan</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>
          <?php
          } 
          ?>
          <!-- end Edit Nilai Siswa -->                
        </div>
      </div>
    </section>
</section>
<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_sekolah').addClass('active');
  $('#m_sekolah_akademik').addClass('active');
  $('#m_sekolah_akademik_nilsis').addClass('active');
</script>