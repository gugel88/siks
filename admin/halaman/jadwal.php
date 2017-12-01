<section class="content-header">
  <h1>
  Manjemen Jadwal Pelajaran
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-calendar-check-o"></i> Jadwal Pelajaran</li>
  </ol>
</section>

<section class="content">
    <!-- kelas -->
    <?php 
    if (isset($_POST['tambah-jadwal'])) {
      $kelas      = $_POST['kelas'];
      $mapel      = $_POST['mapel'];
      $hari       = $_POST['hari'];
      $jam        = "$_POST[jammulai]:$_POST[menitmulai] - $_POST[jamakhir]:$_POST[menitakhir]";
      $guru       = $_POST['guru'];
      //ambil id
      $kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_kelas WHERE kelas_id='$kelas'"));
      $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_mapel WHERE mapel_id='$mapel'"));
      $guru = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_guru WHERE guru_id='$guru'"));    
      //simpan
      $simpan_jadwal = mysqli_query($koneksi, "INSERT INTO tbl_jadpel VALUES ('$mapel[mapel_id]','$kelas[kelas_id]','$hari','$jam')");
      $simpan_jadwal2 = mysqli_query($koneksi, "INSERT INTO tbl_guru_mapel VALUES ('$guru[guru_id]','$mapel[mapel_id]','$kelas[kelas_id]')");
      if(!$simpan_jadwal || !$simpan_jadwal2){
        echo "
        <div class='alert alert-danger alert-dismissable'>
          <a type='button' href='index.php?p=jadwal_pelajaran' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>: Jadwal Pelajaran gagal disimpan.
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=jadwal_pelajaran' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Jadwal Pelajaran baru telah disimpan.
        </div>
        ";
      }
    }
    if (isset($_POST['perbarui-jadwal'])) {
      $idmapel = ($_GET['id_mapel']);
      $idkelas = ($_GET['id_kelas']);
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
          <a type='button' href='index.php?p=jadwal_pelajaran' aria-hidden='true' class='close'>×</a>
          <strong>Gagal </strong>: Jadwal Pelajaran gagal diperbarui. Karena: 
        </div>
        ";
      } else {
        echo "
        <div class='alert alert-success alert-dismissable'>
          <a type='button' href='index.php?p=jadwal_pelajaran' aria-hidden='true' class='close'>×</a>
          <strong>Berhasil </strong>: Jadwal Pelajaran baru berhasil diperbarui.
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
    }
    ?>

    <!-- konten kelas -->
    <section class="panel">
      <header class="panel-heading tab-bg-primary">
        <ul class="nav nav-tabs">
          <li class="<?php echo $tab_list_class; ?>">
            <a data-toggle="tab" href="#daftar">
              <i class="fa fa-bars fa-fw"></i>
              Daftar Jadwal Pelajaran
            </a>
          </li>
          <li>
            <a data-toggle="tab" href="#tambah">
              <i class="fa fa-plus fa-fw"></i>
              Tambah Jadwal Pelajaran
            </a>
          </li>
          <?php
          if(isset($_GET['id_mapel'])){
            echo "
            <li class='active'>
              <a href='#perbarui' data-toggle='tab'>
                <i class='fa fa-edit fa-fw'></i>
                Perbarui Jadwal Pelajaran
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
                      <th>Kelas</th>
                      <th>Hari</th>
                      <th>Mata Pelajaran</th>
                      <th>Keterangan</th>
                      <th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $q = mysqli_query($koneksi, "SELECT * FROM tbl_guru_mapel NATURAL JOIN tbl_jadpel WHERE kelas_id");
                    $no = 1;
                    while($hasil=mysqli_fetch_array($q)){
                    $kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT kelas_nama FROM tbl_kelas WHERE kelas_id = '$hasil[kelas_id]'"));
                    $mapel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT mapel_nama FROM tbl_mapel WHERE mapel_id ='$hasil[mapel_id]'"));
                    $guru = mysqli_fetch_array(mysqli_query($koneksi, "SELECT guru_nama FROM tbl_guru WHERE guru_id = '$hasil[guru_id]'"));
                    ?>
                        <tr>
                          <td><?php echo $no . "."; ?></td>
                          <td><?=$kelas['kelas_nama'];?></td>
                          <td><?=$hasil['hari'];?></td>
                          <td><?=$mapel['mapel_nama'];?></td>
                          <td>
                            <small>
                            <p><i class="fa fa-clock-o"></i> Jam Pelajaran: <?=$hasil['jam'];?></p>
                            <p><i class="fa fa-user"></i> Guru Pengajar: <?=$guru['guru_nama'];?> &nbsp;</p>
                            </small>
                          </td>
                          <td>
                            <a class="tooltips" data-toggle="tooltip" data-original-title="Edit Jadwal Pelajaran" data-placement="top" href='index.php?p=jadwal_pelajaran&id_mapel=<?php echo "$hasil[mapel_id]&id_kelas=$hasil[kelas_id]";?>'><i class='fa fa-edit'></i>
                            </a>&nbsp;
                            <a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus Jadwal Pelajaran' href='halaman/hapus_jadwal.php?id_mapel=<?php echo "$hasil[mapel_id]&id_kelas=$hasil[kelas_id]"; ?>' onclick="return confirm('Anda yakin akan menghapus data ini?')"><i class='fa fa-trash-o'></i>
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
          </div>

          <!-- tambah jadwal pelajaran -->
          <div id="tambah" class="tab-pane fade">
            <section class="panel" style="margin-bottom:0px;">
              <header class="panel-heading tab-bg-primary text-center">
                <span>Form Tambah Jadwal Pelajaran</span>
              </header>
              <div class="panel-body pan">
                <form class="form-horizontal" id="form_kelas" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Kelas<span class="required"></span></label>
                    <div class="col-lg-5">
                      <select class="form-control" name="kelas">
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
                    <label class="col-lg-2 control-label">Mata Pelajaran<span class="required"></span></label>
                    <div class="col-lg-5">
                      <select class="form-control" name="mapel">
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
                    <label class="col-lg-2 control-label">Hari<span class="required"></span></label>
                    <div class="col-lg-5">
                      <select class="form-control" name="hari">
                        <option value="">-- Pilih Hari --</option>
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Jam Pelajaran<span class="required"></span></label>
                    <div class="col-lg-1">
                      <table>
                        <tr>
                          <td>
                            <select name="jammulai" id="jammulai">
                              <?php for($i=7;$i<=17;$i++){
                              if($i<=9){$i="0$i";}
                              echo "<option>$i</option>";
                              }?>
                            </select>                            
                          </td>
                          <td>:</td>
                          <td>
                            <select name="menitmulai" id="menitmulai">
                              <?php for($i=0;$i<=59;$i++){
                              if($i<=9){
                              $i="0$i";
                              }
                              echo "<option>$i</option>";
                              }?>
                            </select>                              
                          </td>
                          <td>&nbsp;&nbsp;s/d&nbsp;&nbsp;</td>
                          <td>
                            <select name="jamakhir" id="jamakhir">
                              <?php for($i=7;$i<=17;$i++){
                              if($i<=9){$i="0$i";}
                              echo "<option>$i</option>";
                              }?>
                            </select>                             
                          </td>
                          <td>:</td>
                          <td>
                            <select name="menitakhir" id="menitakhir">
                              <?php for($i=0;$i<=59;$i++){
                              if($i<=9){
                              $i="0$i";
                              }
                              echo "<option>$i</option>";
                              }?>
                            </select>                            
                          </td>
                        </tr>
                      </table>
                    </div>            
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Guru<span class="required"></span></label>
                    <div class="col-lg-5">
                      <select class="form-control" name="guru">
                        <option value="">-- Pilih Guru --</option>
                          <?php
                          $ambil_guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru ORDER BY guru_id");
                          while ($guru = mysqli_fetch_array($ambil_guru)) {
                            echo "<option value='$guru[guru_id]'>$guru[guru_nama]</option>";
                          }
                          ?>
                      </select>
                    </div>
                  </div>               
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="tambah-jadwal" class="btn btn-primary">Simpan</button>
                      <button type="reset" class="btn btn-default">Kosongkan</button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div> <!-- tambah jadwal pelajaran end -->

          <!-- edit mata pelajaran -->
          <?php
          if(isset($_GET['id_mapel'])){
            $idmapel = $_GET['id_mapel'];
            $idkelas = $_GET['id_kelas'];
            $id = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tbl_guru_mapel NATURAL JOIN tbl_jadpel WHERE kelas_id = '$idkelas' AND mapel_id = $idmapel"));
            $jam = explode(" - ",$id['jam']);
            $kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT kelas_nama FROM tbl_kelas WHERE kelas_id = '$idkelas'"));
            $pljrn = mysqli_fetch_array(mysqli_query($koneksi, "SELECT mapel_nama FROM tbl_mapel WHERE mapel_id = '$idmapel'"));
          ?>          
          <div id="perbarui" class="tab-pane fade in active">
            <section class="panel" style="margin-bottom:0px;">
              <header class="panel-heading tab-bg-primary text-center">
                <span>Form Edit Jadwal Pelajaran</span>
              </header>
              <div class="panel-body pan">
                <form class="form-horizontal" id="form_kelas" role="form" method="post" enctype="multipart/form-data">  
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Kelas<span class="required"></span></label>
                    <div class="col-lg-5">
                      <select class="form-control" name="kelas">
                        <option value="" disabled>-- Pilih Kelas --</option>
                        <?php 
                        $ambil_kelas = mysqli_query($koneksi, "SELECT kelas_nama FROM tbl_kelas");
                        while($kelas = mysqli_fetch_array($ambil_kelas)){
                        if($kls['kelas_nama']==$kelas['kelas_nama']){
                        echo "<option selected=\"selected\">$kelas[kelas_nama]</option>";
                        }else{
                        echo "<option>$kelas[kelas_nama]</option>";
                        }
                        }
                        ?>                          
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Mata Pelajaran<span class="required"></span></label>
                    <div class="col-lg-5">
                      <select class="form-control" name="mapel">
                        <option value="" disabled>-- Pilih Mata Pelajaran --</option>
                        <?php 
                        $ambil_mapel = mysqli_query($koneksi, "SELECT mapel_nama FROM tbl_mapel");
                        while($mapel = mysqli_fetch_array($ambil_mapel)){
                        if($pljrn['mapel_nama']==$mapel['mapel_nama']){
                        echo "<option selected=\"selected\">$mapel[mapel_nama]</option>";
                        }else{
                        echo "<option>$mapel[mapel_nama]</option>";
                        }
                        }
                        ?>                        
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Hari<span class="required"></span></label>
                    <div class="col-lg-5">
                      <select class="form-control" name="hari">
                        <option selected="selected"><?php echo $id['hari']; ?></option>
                        <option value="" disabled>-- Pilih Hari --</option>
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Jam Pelajaran<span class="required"></span></label>
                    <div class="col-lg-1">
                      <table>
                        <tr>
                          <td>
                            <select name="jammulai" id="jammulai">
                              <?php
                              $f = explode(":",$jam[0]);
                              $e = explode(":",$jam[1]);
                              for($i=7;$i<=17;$i++){
                              if($i<=9){$i="0$i";}
                              if($i==$f[0]){
                              echo "<option selected=\"selected\">$i</option>";
                              }else{
                              echo "<option>$i</option>";
                              }}?>
                            </select>                            
                          </td>
                          <td>:</td>
                          <td>
                            <select name="menitmulai" id="menitmulai">
                              <?php for($i=0;$i<=59;$i++){
                              if($i<=9){
                              $i="0$i";
                              }
                              if($i==$f[1]){
                              echo "<option selected=\"selected\">$i</option>";
                              }else{
                              echo "<option>$i</option>";
                              }}?>
                            </select>                              
                          </td>
                          <td>&nbsp;&nbsp;s/d&nbsp;&nbsp;</td>
                          <td>
                            <select name="jamakhir" id="jamakhir">
                              <?php for($i=7;$i<=17;$i++){
                              if($i<=9){$i="0$i";}
                              if($i==$e[0]){
                              echo "<option selected=\"selected\">$i</option>";
                              }else{
                              echo "<option>$i</option>";
                              }}?>
                            </select>                             
                          </td>
                          <td>:</td>
                          <td>
                            <select name="menitakhir" id="menitakhir">
                              <?php for($i=0;$i<=59;$i++){
                              if($i<=9){
                              $i="0$i";
                              }
                              if($i==$e[1]){
                              echo "<option selected=\"selected\">$i</option>";
                              }else{
                              echo "<option>$i</option>";
                              }}?>
                            </select>                            
                          </td>
                        </tr>
                      </table>
                    </div>            
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Guru<span class="required"></span></label>
                    <div class="col-lg-5">
                      <select class="form-control" name="guru">
                        <option value="" disabled>-- Pilih Guru --</option>
                          <?php
                          $ambil_guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                          while ($guru = mysqli_fetch_array($ambil_guru)) {
                          if($guru['guru_id']==$id['guru_id']){
                          echo "<option selected=\"selected\">$guru[guru_nama]</option>";
                          }else{
                          echo "<option>$guru[guru_nama]</option>";
                          }}
                          ?>
                      </select>
                    </div>
                  </div>               
                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                      <button type="submit" name="perbarui-jadwal" class="btn btn-primary">Simpan</button>
                      <button class='btn btn-default'><a href="index.php?p=jadwal_pelajaran">Batal</a></button>
                    </div>
                  </div>
                </form>
              </div>
            </section>
          </div>
            <?php
          } 
          ?>          
        </div>
      </div>
    </section>
</section>
<!-- Js Menu -->
<script type="text/javascript" src="../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_sekolah').addClass('active');
  $('#m_sekolah_akademik').addClass('active');
  $('#m_sekolah_akademik_jadwal').addClass('active');
</script>