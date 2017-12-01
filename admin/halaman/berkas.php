<section class="content-header">
  <h1>
  Manjemen Berkas
  <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-folder"></i> Berkas</li>
  </ol>
</section>

<section class="content">
		<?php
		if (isset($_POST['tambah-berkas'])) {
			$allowed_ext    = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip');
			$berkas_name    = $_FILES['file']['name'];

			//$berkas_ext     = strtolower(end(explode('.', $berkas_name)));
			$arr            = explode(".", $berkas_name);
			$berkas_ext     = strtolower(end($arr));

			$berkas_size    = $_FILES['file']['size'];
			$berkas_tmp     = $_FILES['file']['tmp_name'];
			$id_user        = $_SESSION['id_user'];
			$nama           = $_POST['berkas_nama'];
			$berkas_lokasi  = $nama.".".$berkas_ext;

			if(in_array($berkas_ext, $allowed_ext) === true) {
				if($berkas_size < 1044070){
					if ($_SESSION['status'] == 'admin') {
						$lokasi = '../file/'.$nama.'.'.$berkas_ext;
					} else if ($_SESSION['status'] == 'guru') {
						$lokasi = '../../file/'.$nama.'.'.$berkas_ext;
					}
					move_uploaded_file($berkas_tmp, $lokasi);

					if ($_SESSION['status'] == 'admin') {
						$simpan_data = mysqli_query($koneksi, "INSERT INTO tbl_berkas(berkas_tgl,berkas_nama,berkas_type,berkas_size,berkas_lokasi,id_user,berkas_status) VALUES(NOW(), '$nama', '$berkas_ext', '$berkas_size', '$berkas_lokasi', '$id_user', 'publish')");
					} else if ($_SESSION['status'] == 'guru') {
						$simpan_data = mysqli_query($koneksi, "INSERT INTO tbl_berkas(berkas_tgl,berkas_nama,berkas_type,berkas_size,berkas_lokasi,id_user,berkas_status) VALUES(NOW(), '$nama', '$berkas_ext', '$berkas_size', '$berkas_lokasi', '$id_user', 'publish')");
					}
					if($simpan_data){
						echo "
						<div class='alert alert-success alert-dismissable'>
							<button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
							<strong>Berhasil</strong> : Berkas telah disimpan
						</div>
						";
					} else {
						echo "
						<div class='alert alert-danger alert-dismissable'>
							<button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
							<strong>Gagal</strong> : Berkas gagal disimpan
						</div>
						";
					}
				} else {
					echo "
					<div class='alert alert-warning alert-dismissable'>
						<button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
						<strong>Peringatan</strong> : Ukuran file (file size) maksimal 1 Mb!
					</div>
					";
				}
			} else {
				echo "
				<div class='alert alert-warning alert-dismissable'>
					<button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
					<strong>Peringatan</strong> : Ekstensi file tidak di izinkan !
				</div>
				";
			}
		}
		?>

		<!-- konten kategori -->
		<section class="panel">
			<header class="panel-heading tab-bg-primary">
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#daftar">
							<i class="fa fa-bars fa-fw"></i>
							Daftar Berkas
						</a>
					</li>
					<li>
						<a data-toggle="tab" href="#tambah">
							<i class="fa fa-plus fa-fw"></i>
							Tambah Berkas
						</a>
					</li>
				</ul>
			</header>

			<div class="panel-body">
				<!-- tab konten -->
				<div class="tab-content">
					<!-- data kategori -->
					<div id="daftar" class="tab-pane fade in active">
						<div class="panel">
							<div class="panel-body pan table-responsive">
								<table id="example1" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Tipe</th>
											<th>Berkas</th>
											<th><i class="fa fa-wrench faa-wrench animated"></i> Aksi</th>
										</tr>
									</thead>

									<tbody>
										<?php
										function formatBytes($bytes, $precision = 2) { 
											$units = array('B', 'KB', 'MB', 'GB', 'TB'); 
											$bytes = max($bytes, 0); 
											$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
											$pow = min($pow, count($units) - 1); 
											$bytes /= pow(1024, $pow); 
											return round($bytes, $precision) . ' ' . $units[$pow]; 
										}
										if ($user['status'] == 'admin') {
											include "../konfigurasi/enkripsi.php";
											$ambil_berkas = mysqli_query($koneksi, "SELECT tbl_user.*, tbl_berkas.* FROM tbl_user, tbl_berkas WHERE tbl_user.id_user=tbl_berkas.id_user ORDER BY berkas_id DESC");
										} else if ($user['status'] == 'guru') {
											include "../../konfigurasi/enkripsi.php";
											$ambil_berkas = mysqli_query($koneksi, "SELECT tbl_berkas.* FROM tbl_berkas WHERE tbl_berkas.id_user='$_SESSION[id_user]' ORDER BY berkas_id DESC");
										}
										if (mysqli_num_rows($ambil_berkas) > 0) {
											$no = 1;
											while ($berkas = mysqli_fetch_array($ambil_berkas)) {
												$ubah_tanggal = mysqli_query($koneksi, "SELECT DATE_FORMAT('$berkas[berkas_tgl]', '%d %b %Y - %r') AS tanggal");
												$tanggal      = mysqli_fetch_array($ubah_tanggal);
												$berkas_tgl   = $tanggal['tanggal'];
							                    $berkas_bsd   = base64_encode($berkas['berkas_id']);
							                    $token = encrypt($berkas_bsd);
												if ($berkas['berkas_type']=='doc' || $berkas['berkas_type']=='docx') {
													$berkas_img = "word.png";
												} else if ($berkas['berkas_type']=='xls' || $berkas['berkas_type']=='xlsx') {
													$berkas_img = "excel.png";
												} else if ($berkas['berkas_type']=='rar' || $berkas['berkas_type']=='zip') {
													$berkas_img = "rar.png";
												} else if ($berkas['berkas_type']=='ppt' || $berkas['berkas_type']=='pptx') {
													$berkas_img = "ppt.png";
												} else if ($berkas['berkas_type']=='pdf') {
													$berkas_img = "pdf.png";
												}
												?>
												<tr>
													<td><?php echo $no . "."; ?></td>
													<td>
														<?php
														if ($_SESSION['status'] == 'admin') {
															echo "<img src='../img/file/$berkas_img'>";
														} elseif ($_SESSION['status'] == 'guru') {
															echo "<img src='../../img/file/$berkas_img'>";
														}
														?>
													</td>
													<td>
														<p><?=$berkas['berkas_nama'];?>.<?=$berkas['berkas_type'];?>&nbsp; 
															<?php
															if ($berkas['berkas_status'] == 'baru') {
																echo "<small class='label label-primary'><i class='fa fa-thumbs-o-up'></i> $berkas[berkas_status]</small></small>";
															} else if ($berkas['berkas_status'] == 'publish') {
																echo "<small class='label label-primary'><i class='fa fa-eye'></i> $berkas[berkas_status]</small></small>";
															} else if ($berkas['berkas_status'] == 'unpublish') {
																echo "<small class='label label-primary'><i class='fa fa-eye-slash'></i> $berkas[berkas_status]</small>";
															}
															?>
														</p>
														<hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
														<p>
															<small>
																<?php if ($user['status'] == 'admin') {
																	echo "<i class='fa fa-user fa-fw'></i> $berkas[nm_tampilan]";
																} 
																?> &nbsp;
																<i class='fa fa-calendar-o fa-fw'></i> <?php echo $berkas_tgl;?> &nbsp; 
																<i class='fa fa-file-text-o fa-fw'></i> <?php echo formatBytes($berkas['berkas_size']); ?> &nbsp; 
																<span id="buka"><a href="#link_<?php echo $berkas['berkas_id']; ?>">
																	<i class='fa fa-caret-down fa-fw'></i></i>Buka Tautan</a>
																</span>
																<br/>
																<div  style="display: none;" id="link_<?php echo $berkas['berkas_id']; ?>">
																	<hr style="margin: 10px 0; border-top: 1px dashed #dddddd;" />
																	<form name="copy">
																		<div class="input-group input-group-sm">
																			<div class="input-group-btn">
																				<button type="button" class="btn btn-success" onclick="javascript:this.form.txt.focus(); this.form.txt.select();"">Seleksi</button>
																			</div>
																			<input type="text" name="txt" class="form-control" readonly value="file/<?php echo $berkas['berkas_nama'].'.'.$berkas['berkas_type']; ?>">
																		</div><p>* klik tombol seleksi --> tekan CTRL + C </p>
																	</form>
																</div>
															</small>
														</p>
													</td>
													<td align="center">
														<?php
														if ($user['status'] == 'admin') {
															$link = "halaman";
														} else if ($user['status'] == 'guru') {
															$link = "../halaman";
														}
														?>
														<a class='tooltips' data-toggle='tooltip' data-placement='top' data-original-title='Hapus' href="<?php echo $link;?>/hapus_berkas.php?id=<?php echo $berkas_bsd?>&token=<?php echo $token?>" onclick="return confirm('Anda yakin akan menghapus berkas ini ?')"><i class="fa fa-trash-o fa-fw"></i>
														</a>
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
					</div> <!-- data kategori end -->

					<!-- tambah-kategori -->
					<div id="tambah" class="tab-pane fade">
						<section class="panel" style="margin-bottom:0px;">
							<h4 class="text-center"><b>Form Tambah Berkas</b></h4>
							<div class="panel-body pan">
								<form class="form-horizontal" id="register_form" role="form" method="post" enctype="multipart/form-data">  
									<div class="form-group">
										<label for="berkas" class="col-lg-2 control-label">Nama Berkas<span class="required"></span></label>
										<div class="col-lg-10">
											<input type="text" class="form-control" name="berkas_nama" id="berkas" required>
										</div>
									</div>
									<div class="form-group">
										<label for="berkas" class="col-lg-2 control-label">Berkas<span class="required"></span></label>
										<div class="col-lg-10">
											<input type="file" class="form-control" name="file" id="berkas" required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-10">
											<button type="submit" name="tambah-berkas" class="btn btn-primary">Simpan</button>
											<button type="reset" class="btn btn-default">Kosongkan</button>
										</div>
									</div>
								</form>
							</div>
						</section>
					</div> <!-- tambah kategori end -->
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
  $('#m_berkas').addClass('active');
</script>
	<?php  
} else if ($user['status'] == 'guru') {
	?>
<!-- Js Menu -->
<script type="text/javascript" src="../../assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_berkas').addClass('active');
</script>
	<?php
}
?>