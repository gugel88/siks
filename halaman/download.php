<section class="content-header">
  <h1>
    Unduh Berkas
    <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li class="active"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-user"></i> Unduh Berkas</a></li>
  </ol>   
</section>
<hr>
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Daftar Berkas</h4>
					</div>
					<div class="box-body">
						<table id="example1" class="table table-bordered table-hover">
							<thead>
								<th></th>
							</thead>
							<tbody>
								<?php
								$ambil_berkas = mysqli_query($koneksi, "SELECT tbl_user.*, tbl_berkas.* FROM tbl_user, tbl_berkas WHERE tbl_user.id_user=tbl_berkas.id_user ORDER BY berkas_tgl DESC");
								if (mysqli_num_rows($ambil_berkas) > 0) {
									function formatBytes($bytes, $precision = 2) { 
										$units = array('B', 'KB', 'MB', 'GB', 'TB'); 
										$bytes = max($bytes, 0); 
										$pow   = floor(($bytes ? log($bytes) : 0) / log(1024)); 
										$pow   = min($pow, count($units) - 1); 
										$bytes /= pow(1024, $pow); 
										return round($bytes, $precision) . ' ' . $units[$pow]; 
									}
									while ($berkas = mysqli_fetch_array($ambil_berkas)) {
										$date_change = mysqli_query($koneksi, "SELECT DATE_FORMAT('$berkas[berkas_tgl]', '%d %b %Y') AS tanggal");
										$tgl      = mysqli_fetch_array($date_change);
										$tgl      = $tgl['tanggal'];
										echo "
										<tr>
											<td>
												<p><b>$berkas[berkas_nama].$berkas[berkas_type]</b></p>
												<small>
													<p>
													Oleh : $berkas[nm_tampilan], &nbsp;pada $tgl &nbsp; 
													<a type='button' class='btn btn-default btn-xs' href='file/$berkas[berkas_lokasi]'> Unduh Berkas</a>
													</p>

												</small>
											</td>
										</tr>
										";
									}
								} 
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div><!--col md 8 end -->	

<!-- Js Menu -->
<script type="text/javascript" src="assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_unduh').addClass('active');
</script>		