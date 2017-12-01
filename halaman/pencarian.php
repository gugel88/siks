<section class="content-header">
  <h1>
    Hasil Pencarian
    <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-home"></i><a href="index.php"> Beranda</a></li>
    <li class="active">Hasil Pencarian</li>
  </ol>
</section>
<br>

<div class="col-md-8">
    <div class="box box-default">
    	<div class="box-body">
    		<section class='content'>
    			<div class='row'>	
				<?php
				sleep(1);
				include "konfigurasi/konfigurasi.php";
				$artikel_judul = $_POST["artikel_judul"];
				$query_pencarian = mysqli_query($koneksi, "SELECT * FROM tbl_artikel WHERE artikel_judul LIKE '%$artikel_judul%'");
				$pencarian=mysqli_num_rows($query_pencarian);

				if($pencarian > 0){
					while($cari = mysqli_fetch_array($query_pencarian)){
						$dp_bse = str_replace(" ", "+", $cari['artikel_judul']);
						echo "
			            <div class='box-footer no-padding'>
			              <ul class='nav nav-stacked'>
			                <li><a href='index.php?p=Artikel&detail=$dp_bse'>$cari[artikel_judul]</a></li>
			              </ul>
			            </div>						
						";
					}   
				} else {
					echo "
					<div class='alert alert-danger alert-dismissable'>
						<button type='button' data-dismiss='alert' aria-hidden='true' class='close'>×</button>
						<i class='fa fa-warning fa-fw'></i> <strong>Tidak ada artikel yang ditemukan</strong>
					</div>";
				}
				?>
				</div>
			</section>
		</div>
	</div>
</div>
<?php include "konten_kanan.php"; ?>