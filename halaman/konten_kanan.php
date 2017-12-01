<div class="col-md-4">
  <!-- Kategori Artikel -->
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Kategori Artikel</h3>
    </div>
    <div class="box-body">
      <ul class="products-list product-list-in-box">
        <?php
        $query_kategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori WHERE kategori_tentang='artikel' ORDER BY kategori_nama");
        while ($kategori = mysqli_fetch_array($query_kategori)) {
        $hitung_artikel  = mysqli_query($koneksi, "SELECT COUNT(*) As Jmlartikel FROM tbl_artikel WHERE kategori_id='$kategori[kategori_id]' AND artikel_status='publish'");
        $hasil_hitung = mysqli_fetch_array($hitung_artikel);
        $kategori_bse = str_replace(" ", "+", $kategori['kategori_nama']);
        if (isset($_GET['kategori']) && $_GET['kategori']==$kategori['kategori_nama']) {
        $icon = "fa fa-folder-open-o fa-fw";
        } else {
        $icon = "fa fa-folder-o fa-ban fa-fw";
        }
        echo "        
        <li class='item'>       
          <div>
            <i class='$icon pr-10'></i>
            <a href='index.php?p=Artikel&kategori=$kategori_bse' class='product-title'>$kategori[kategori_nama]
            <span class='label label-primary pull-right'>$hasil_hitung[Jmlartikel]</span>
            </a>
          </div>
        </li>
        ";
        }
        ?> 
      </ul>
    </div>
  </div>
  <!-- Artikel Terpopuler -->
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Artikel Terpopuler</h3>
    </div>
    <div class="box-body">
      <ul class="products-list product-list-in-box">
        <?php
        $ambil_artikel = mysqli_query($koneksi, "SELECT * FROM tbl_kategori, tbl_artikel WHERE tbl_kategori.kategori_id=tbl_artikel.kategori_id AND artikel_status='publish' ORDER BY artikel_hitung DESC LIMIT 5");
        while ($artikel= mysqli_fetch_array($ambil_artikel)) {
        $change_date   = mysqli_query($koneksi, "SELECT DATE_FORMAT('$artikel[artikel_tgl]', '%d %b %Y') AS date");
        $date          = mysqli_fetch_array($change_date);
        $date          = $date['date'];
        $detail_bse    = str_replace(" ", "+", $artikel['artikel_judul']);
        $desc          = substr($artikel['artikel_konten'], 0, 90);
        $desc          = substr($artikel['artikel_konten'], 0, strrpos($desc," "));
        ?>        
        <li class="item">
          <div class="product-img">
            <img src="img/artikel/thumb/thumb_<?=$artikel['artikel_img'];?>"/>
          </div>
          <div class="product-info">
            <a href="index.php?p=Artikel&detail=<?=$detail_bse;?>" class="product-title"><?=$artikel['artikel_judul'];?></a>
            <span class="product-description">
              <i class="fa fa-calendar fa-fw"></i><?=$date;?>
            </span>
          </div>
        </li>
        <?php
        }
        ?>        
      </ul>
    </div>
    <div class="box-footer text-center">
      <a href="index.php?p=Artikel" class="uppercase">Lihat Semua</a>
    </div>
  </div>
  <!-- Label Artikel -->
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Label Artikel</h3>
    </div>
    <div class="box-body">
    <?php
    $query_label = mysqli_query($koneksi, "SELECT artikel_label FROM tbl_artikel WHERE artikel_status='publish' ORDER BY artikel_hitung DESC");
    $array_label = array();
    while($label = mysqli_fetch_array($query_label)){
    $pecah_label = explode(", ", $label['artikel_label']);
    $jml_label   = count($pecah_label);
    for ($i=0; $i < $jml_label; $i++) { 
      $array_label[] = $pecah_label[$i];
    }
    }
    $label_unique = array_unique($array_label);
    foreach ($label_unique as $hasil_label => $idx) {
    $label_bse = str_replace(" ", "+", $idx);
    ?>
    <div class="box-body">
      <div class='tag'>
        <a href='index.php?p=Artikel&label=<?=$label_bse;?>'><button class="btn btn-flat btn-default"><?=$idx;?></button></a>
      </div>
    </div>
    <?php
    }
    ?>
    </div>
  </div>         
</div>