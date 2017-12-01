<section class="content-header">
  <?php
  if (isset($_GET['detail'])) {
  echo "
    <h1>
      Artikel
      <small>Sistem Informasi Akademik Sekolah</small>
    </h1>
    <ol class='breadcrumb'>
      <li><a href='index.php'><i class='fa fa-home'></i> Beranda</a></li>
      <li><a href='index.php?p=Artikel'><i class='fa fa-newspaper-o'></i> Artikel</a></li>
      <li class='active'>".($_GET['detail'])."</li>
    </ol>
  ";
  } else if (empty($_GET['detail'])) {
  if (isset($_GET['kategori']) && empty($_GET['label'])) {
  echo "
    <h1>
      Artikel
      <small>Sistem Informasi Akademik Sekolah</small>
    </h1>
    <ol class='breadcrumb'>
      <li><a href='index.php'><i class='fa fa-home'></i> Beranda</a></li>
      <li><a href='index.php?p=Artikel'><i class='fa fa-newspaper-o'></i> Artikel</a></li>
      <li class='active'><i class='fa fa-folder-open'></i> Kategori: ".($_GET['kategori'])."</li>
    </ol>
  ";
  } else if (empty($_GET['kategori']) && isset($_GET['label'])) {
  echo "
    <h1>
      Artikel
      <small>Sistem Informasi Akademik Sekolah</small>
    </h1>
    <ol class='breadcrumb'>
      <li><a href='index.php'><i class='fa fa-home'></i> Beranda</a></li>
      <li><a href='index.php?p=Artikel'><i class='fa fa-newspaper-o'></i> Artikel</a></li>
      <li class='active'><i class='fa fa-folder-open'></i> Lebel: ".($_GET['label'])."</li>
    </ol>
  ";
  } else if (isset($_GET['kategori']) && isset($_GET['label'])) {
  echo "
    <span class='crumbs-spacer'><a href='index.php?p=Artikel'><i class='ico-fast-forward'></i> Artikel</a></span>
    <span class='active'><i class='ico-fast-forward'></i> <span class='current'>404 &nbsp; <i class='fa fa-warning'></i></span>
  ";
  } else {
  echo "
    <h1>
      Artikel
      <small>Sistem Informasi Akademik Sekolah</small>
    </h1>
    <ol class='breadcrumb'>
      <li><a href='index.php'><i class='fa fa-home'></i> Beranda</a></li>
      <li class='active'><i class='fa fa-newspaper-o'></i> Artikel</li>
    </ol>      
  ";
  } 
  }
  ?>
</section>
<br>
  <div class="col-md-8">
    <div class="box box-default">
      <div class="box-body">
        <section class='content'>
          <div class='row'>
            
              <?php
              if (empty($_GET['detail'])) {
                $artikelPerPage = 10;
                if(isset($_GET['artikelPage'])) {
                  $noPageArtikel = $_GET['artikelPage'];
                } else {
                  $noPageArtikel = 1;
                }
                $offset_artikel = ($noPageArtikel - 1) * $artikelPerPage;
                if (isset($_GET['kategori']) && empty($_GET['label'])) {
                  $ambil_artikel = mysqli_query($koneksi, "SELECT tbl_artikel.*, tbl_user.id_user, tbl_user.gambar, tbl_user.nm_tampilan, tbl_kategori.* FROM tbl_artikel, tbl_user, tbl_kategori WHERE tbl_artikel.id_user=tbl_user.id_user AND tbl_artikel.kategori_id=tbl_kategori.kategori_id AND tbl_kategori.kategori_nama='$_GET[kategori]' AND tbl_artikel.artikel_status='publish' ORDER BY artikel_tgl DESC LIMIT $offset_artikel, $artikelPerPage");
                } else if(empty($_GET['kategori']) && isset($_GET['label'])) {
                  $ambil_artikel = mysqli_query($koneksi, "SELECT tbl_artikel.*, tbl_user.id_user, tbl_user.gambar, tbl_user.nm_tampilan, tbl_kategori.* FROM tbl_artikel, tbl_user, tbl_kategori WHERE tbl_artikel.id_user=tbl_user.id_user AND tbl_artikel.kategori_id=tbl_kategori.kategori_id AND tbl_artikel.artikel_label LIKE '%$_GET[label]%' AND tbl_artikel.artikel_status='publish' ORDER BY artikel_tgl DESC LIMIT $offset_artikel, $artikelPerPage");
                } else if (isset($_GET['kategori']) && isset($_GET['label'])) {
                  include 'halaman/404.php';
                  $ambil_artikel = mysqli_query($koneksi, "SELECT tbl_artikel.*, tbl_user.id_user, tbl_user.gambar, tbl_user.nm_tampilan, tbl_kategori.* FROM tbl_artikel, tbl_user, tbl_kategori WHERE tbl_artikel.id_user=tbl_user.id_user AND tbl_artikel.kategori_id=tbl_kategori.kategori_id AND tbl_artikel.artikel_id='0' AND tbl_artikel.artikel_status='publish' ORDER BY artikel_tgl DESC LIMIT $offset_artikel, $artikelPerPage");
                } else {
                  $ambil_artikel = mysqli_query($koneksi, "SELECT tbl_artikel.*, tbl_user.id_user, tbl_user.gambar, tbl_user.nm_tampilan, tbl_kategori.* FROM tbl_artikel, tbl_user, tbl_kategori WHERE tbl_artikel.id_user=tbl_user.id_user AND tbl_artikel.kategori_id=tbl_kategori.kategori_id AND tbl_artikel.artikel_status='publish' ORDER BY artikel_tgl DESC LIMIT $offset_artikel, $artikelPerPage");
                }
                if (mysqli_num_rows($ambil_artikel) > 0) {
                while ($artikel = mysqli_fetch_array($ambil_artikel))
                {
                  $detail_bse   = str_replace(" ", "+", $artikel['artikel_judul']);
                  $kategori_bse = str_replace(" ", "+", $artikel['kategori_nama']);
                  $change_date  = mysqli_query($koneksi, "SELECT DATE_FORMAT('$artikel[artikel_tgl]', '%d_%b_%Y_%r') AS date");
                  $date         = mysqli_fetch_array($change_date);
                  $date         = $date['date'];
                  $date         = explode("_", $date);
                  $isi          = substr($artikel['artikel_konten'],0,300);
                  $isi          = substr($artikel['artikel_konten'],0,strrpos($isi," "));
                  $isi          = strip_tags($isi, "<p>");
                  $pecah_label  = explode(", ", $artikel['artikel_label']);
                  echo "
                  <div class='user-block'>
                    <img class='img-circle' src='img/user/thumb_petugas.jpg' alt='Gambar'/>
                    <span class='username'><a href='index.php?p=Artikel&detail=$detail_bse'>$artikel[artikel_judul]</a></span>
                    <span class='description'>
                    <i class='fa fa-calendar-o fa-fw date'></i> $date[0] $date[1] $date[2] &nbsp;&nbsp;
                    <i class='fa fa-user fa-fw'></i> $artikel[nm_tampilan] &nbsp;&nbsp;
                    <i class='fa fa-folder-o fa-fw'></i> <a href='index.php?p=Artikel&kategori=$kategori_bse'>$artikel[kategori_nama] &nbsp;&nbsp; </a>
                    <i class='fa fa-bar-chart-o fa-fw'></i> $artikel[artikel_hitung]x dilihat &nbsp;&nbsp;
                    ";
                    $ambil_jml_komentar = mysqli_query($koneksi, "SELECT COUNT(*) AS jmlKomentar FROM tbl_komentar WHERE artikel_id='$artikel[artikel_id]'");
                    $komentar = mysqli_fetch_array($ambil_jml_komentar);
                    echo "
                    <i class='fa fa-comments-o fa-fw'></i> $komentar[jmlKomentar] Komentar
                    </span>
                  </div>
                  <div class='box-body'>
                    <img class='img-thumbnail' src='img/artikel/thumb_$artikel[artikel_img]' alt='Gambar'/>
                    <p>$isi [ ... ]</p>
                  </div>
                  <div class='box-footer'>
                    <div class='pull-right'>
                    <a class='btn btn-common' href='index.php?p=Artikel&detail=$detail_bse'>Baca Selengkapnya <i class='ico-arrow-right'></i></a>
                    </div>
                  </div>
                  ";
                }
                } else {
                  include 'halaman/kosong.php';
                  }
                    if (isset($_GET['kategori']) && empty($_GET['label'])) {
                      $link = "?p=Artikel&kategori=".str_replace(" ", "+", $_GET['kategori'])."&artikelPage=";
                      $ambil_artikel2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jmlArtikel FROM tbl_artikel, tbl_kategori WHERE tbl_artikel.kategori_id=tbl_kategori.kategori_id AND tbl_kategori.kategori_nama='$_GET[kategori]' AND tbl_artikel.artikel_status='publish'");
                    } else if (empty($_GET['kategori']) && isset($_GET['label'])) {
                      $link = "?p=Artikel&label=".str_replace(" ", "+", $_GET['label'])."&artikelPage=";
                      $ambil_artikel2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jmlArtikel FROM tbl_artikel WHERE artikel_label LIKE '%$_GET[label]%' AND artikel_status='publish'");
                    } else if (isset($_GET['kategori']) && isset($_GET['label'])) {
                      $ambil_artikel2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jmlArtikel FROM tbl_artikel WHERE artikel_id='0' AND artikel_status='publish'");
                    } else {
                      $link  = "?p=Artikel&artikelPage=";
                      $ambil_artikel2 = mysqli_query($koneksi, "SELECT COUNT(*) AS jmlArtikel FROM tbl_artikel WHERE artikel_status='publish'");
                    }
                    $hasilArtikel   = mysqli_fetch_array($ambil_artikel2);
                    $jmlArtikel     = $hasilArtikel['jmlArtikel'];
                    $jmlPageArtikel = ceil($jmlArtikel/$artikelPerPage);

                    echo "<div class='text-center'><ul class='pagination'>";
                    if($noPageArtikel > 1) echo "<li><a href='".$_SERVER['PHP_SELF'].$link.($noPageArtikel-1)."'>sebelumnya</a>";
                    for($pageArtikel = 1; $pageArtikel <= $jmlPageArtikel; $pageArtikel++)
                    {
                      if ((($pageArtikel >= $noPageArtikel - 3) && ($pageArtikel <= $noPageArtikel + 3)) || ($pageArtikel == 1) || ($pageArtikel == $jmlPageArtikel))
                      {
                        $showPageArtikel = "";
                        if ($pageArtikel == $noPageArtikel) {
                          echo "<li class='active'><a href='#'>".$pageArtikel."</a></li>";
                        } else {
                          echo "<li><a href='".$_SERVER['PHP_SELF'].$link.$pageArtikel."'>".$pageArtikel."</a> ";
                        }
                        $showPageArtikel = $pageArtikel;
                      }
                    }
                    if ($noPageArtikel < $jmlPageArtikel) echo "<li><a href='".$_SERVER['PHP_SELF'].$link.($noPageArtikel+1)."'>selanjutnya</a>";
                    echo "</ul></div>";

                  } else if (isset($_GET['detail']) && empty($_GET['kategori']) && empty($_GET['label'])) {
                    $detail_bsd  = str_replace("+", " ", $_GET['detail']);
                    if ((isset($_SESSION['status'])) && ($_SESSION['status']=='admin' || $_SESSION['status']=='guru')) {
                      $ambil_artikel = mysqli_query($koneksi, "SELECT tbl_artikel.*, tbl_user.id_user, tbl_user.gambar, tbl_user.nm_tampilan, tbl_kategori.* FROM tbl_artikel, tbl_user, tbl_kategori WHERE tbl_artikel.id_user=tbl_user.id_user AND tbl_artikel.kategori_id=tbl_kategori.kategori_id AND tbl_artikel.artikel_judul='$detail_bsd'");
                    } else {
                      $ambil_artikel = mysqli_query($koneksi, "SELECT tbl_artikel.*, tbl_user.id_user, tbl_user.gambar, tbl_user.nm_tampilan, tbl_kategori.* FROM tbl_artikel, tbl_user, tbl_kategori WHERE tbl_artikel.id_user=tbl_user.id_user AND tbl_artikel.kategori_id=tbl_kategori.kategori_id AND tbl_artikel.artikel_judul='$detail_bsd' AND tbl_artikel.artikel_status='publish'");
                    }
                    if ($artikel = mysqli_fetch_array($ambil_artikel)) {
                      $up_count     = mysqli_query($koneksi, "UPDATE tbl_artikel SET artikel_hitung=$artikel[artikel_hitung]+1 WHERE artikel_id='$artikel[artikel_id]'");
                      $kategori_bse       = str_replace(" ", "+", $artikel['kategori_nama']);
                      $detail_bse       = str_replace(" ", "+", $artikel['artikel_judul']);
                      $change_date  = mysqli_query($koneksi, "SELECT DATE_FORMAT('$artikel[artikel_tgl]', '%d_%b_%Y_%r') AS date");
                      $date         = mysqli_fetch_array($change_date);
                      $date         = $date['date'];
                      $date         = explode("_", $date);
                      $pecah_label  = explode(", ", $artikel['artikel_label']);

                      if(isset($_POST['simpan_komentar'])) {
                        if (isset($_SESSION['id_user'])) {
                          $id_user     = $_SESSION['id_user'];
                        } else {
                          $id_user     = NULL;
                          $gambar      = array("guest1.jpg", "guest2.jpg", "guest3.jpg", "guest4.jpg");
                          $gambar      = $gambar[array_rand($gambar)];
                        }
                        $artikel_id       = $artikel['artikel_id'];
                        $nm_tampilan     = trim($_POST['nm_tampilan']);
                        $email         = trim($_POST['email']);
                        $komentar_konten = trim($_POST['komentar_konten']);
                        $komentar_konten = nl2br($komentar_konten);

                        $query_user      = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE email='$email'");
                        $urut_user       = mysqli_num_rows($query_user);
                        if ($urut_user==0) {
                          $simpan_user   = mysqli_query($koneksi, "INSERT INTO tbl_user (id_user,nm_tampilan,email,gambar,status) VALUES('$id_user','$nm_tampilan','$email','$gambar','pengunjung')");
                          if ($simpan_user) {
                            $ambil_user  = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE email='$email'");
                            $user        = mysqli_fetch_array($ambil_user);
                            $id_user_n   = $user['id_user'];
                            $komentar_konten = mysqli_real_escape_string($koneksi, $komentar_konten);
                            mysqli_query($koneksi, "INSERT INTO tbl_komentar (artikel_id, id_user, komentar_tgl, komentar_konten, komentar_status) VALUES('$artikel_id', '$id_user_n', NOW(), '$komentar_konten', '2' )");
                            unset($_POST['nm_tampilan'],$_POST['email'],$_POST['komentar_konten']);
                          }
                        } else {
                          $user          = mysqli_fetch_array($query_user);
                          $id_user_n     = $user['id_user'];
                          $komentar_konten = mysqli_real_escape_string($koneksi, $komentar_konten);
                          mysqli_query($koneksi, "INSERT INTO tbl_komentar (artikel_id, id_user, komentar_tgl, komentar_konten, komentar_status) VALUES('$artikel_id', '$id_user_n', NOW(), '$komentar_konten', '2' )");
                          unset($_POST['nm_tampilan'],$_POST['email'],$_POST['komentar_konten']);
                        }
                      }
                      echo "
                      <div class='user-block'>
                      <img class='img-circle' src='img/user/thumb_petugas.jpg' alt='Gambar'/>
                      <span class='username'><a href='index.php?p=Artikel&detail=$detail_bse'>$artikel[artikel_judul]</a></span>
                      <span class='description'>
                      <i class='fa fa-calendar-o fa-fw date'></i> $date[0] $date[1] $date[2] &nbsp;&nbsp;
                      <i class='fa fa-user fa-fw'></i> $artikel[nm_tampilan] &nbsp;&nbsp;
                      <i class='fa fa-folder-o fa-fw'></i> <a href='index.php?p=Artikel&kategori=$kategori_bse'>$artikel[kategori_nama] &nbsp;&nbsp; </a>
                      <i class='fa fa-bar-chart-o fa-fw'></i> $artikel[artikel_hitung]x dilihat &nbsp;&nbsp;
                      ";
                      $ambil_jml_komentar = mysqli_query($koneksi, "SELECT COUNT(*) AS jmlKomentar FROM tbl_komentar WHERE artikel_id='$artikel[artikel_id]'");
                      $komentar = mysqli_fetch_array($ambil_jml_komentar);
                      echo "
                      <i class='fa fa-comments-o fa-fw'></i> $komentar[jmlKomentar] Komentar
                      </span>
                      </div>
                      <div class='box-body'>
                      <img class='img-thumbnail' src='img/artikel/thumb_$artikel[artikel_img]' alt='Gambar'/>
                      <p>$artikel[artikel_konten]</p>
                      <hr style='margin-top:10px; margin-bottom:10px; border-top: 1px dashed #F0F0F0;'' />
                      <div class='text-center'>
                      Bagikan:
                      <a class='btn btn-social-icon btn-facebook'><i class='fa fa-facebook'></i></a>
                      <a class='btn btn-social-icon btn-twitter'><i class='fa fa-twitter'></i></a>
                      <a class='btn btn-social-icon btn-instagram'><i class='fa fa-instagram'></i></a>
                      <a class='btn btn-social-icon btn-google'><i class='fa fa-google-plus'></i></a>
                      </div>
                      <hr style='margin-top:10px; margin-bottom:10px; border-top: 1px dashed #F0F0F0;'' />
                      <h4>Label</h4>
                      ";
                      for ($i=0; $i < count($pecah_label); $i++) {
                      $label_bse = str_replace(" ", "+", $pecah_label[$i]);
                      echo"
                      <div class='box-body'>
                      <div class='tag'>
                      <a href='index.php?p=Artikel&label=$label_bse'>
                      <button type='button' class='btn btn-default btn-flat'>$pecah_label[$i]</button></a> &nbsp;&nbsp;
                      </div>
                      </div>
                      ";
                      }
                      ?>
                      <div class='box-footer'>
                      <?php
                      echo "
                      <h4 id='komentar'>$komentar[jmlKomentar] Komentar</h4>
                      ";
                      $get_Artikel_komentar = mysqli_query($koneksi, "SELECT tbl_komentar.*, tbl_user.id_user, tbl_user.nm_tampilan, tbl_user.gambar, tbl_user.status FROM tbl_komentar, tbl_user WHERE tbl_komentar.id_user=tbl_user.id_user AND artikel_id='$artikel[artikel_id]' ORDER BY komentar_id");
                      $count = mysqli_num_rows($get_Artikel_komentar);
                      if ($count != 0) {
                        while ($artikel_komentar = mysqli_fetch_array($get_Artikel_komentar)) {
                          $change_date     = mysqli_query($koneksi, "SELECT DATE_FORMAT('$artikel_komentar[komentar_tgl]', '%d %b %Y - %r') AS date");
                          $date            = mysqli_fetch_array($change_date);
                          $comment_date    = $date['date'];
                          $komentar_konten = $artikel_komentar['komentar_konten'];
                          if ($artikel_komentar['id_user'] != $artikel['id_user']) {
                            if ($artikel_komentar['status']=='admin') {
                              $tag = "<span class='label label-primary' style='font-size:70%; font-weight:normal;'>Administrator</span>";
                            } else if ($artikel_komentar['status']=='guru') {
                              $tag = "<span class='label label-warning' style='font-size:70%; font-weight:normal;'>guru</span>";
                            } else {
                              $tag = "<span class='label label-success' style='font-size:70%; font-weight:normal;'>Pengunjung</span>";
                            }
                          } else {
                            $tag = "<span class='label label-info' style='font-size:70%; font-weight:normal;'>Penulis</span>";
                          }
                          echo "
                          <div class='media'>
                            <div class='media-body' style='padding:10px; background-color:#fff; border:1px solid #eee; border-radius:4px;'>
                              <h5 class='title'>
                                <b>Pengirim :</b> $artikel_komentar[nm_tampilan] &nbsp;$tag
                                <span class='pull-right'><small><i class='fa fa-calendar-o'></i>&nbsp; $comment_date</small></span>
                              </h5>
                              <hr style='margin-top:10px; margin-bottom:10px;'>
                              <p style='margin-bottom:0px;'>
                                <i class='fa fa-angle-right fa-fw'></i> $komentar_konten
                              </p>
                            </div>
                          </div>
                          ";
                        }
                      }
                      if (isset($_SESSION['id_user'])) {
                        $form_name  = "value='".$user['nm_tampilan']."'";
                        $form_email = "value='".$user['email']."'";
                        $mark       = "readonly";
                      } else {
                        $form_name  = "";
                        $form_email = "";
                        $mark       = "required";
                      }
                      ?>
                      <div class='media'>
                      <div class='media-body' style='padding:10px; background-color:#fff; border:1px solid #eee; border-radius:4px;'>
                      <h4>Kirim Komentar</h4>
                      <form method="post" role="form" class="form-horizontal">
                        <div class="row">
                          <div class="col-md-6">
                            <input class="form-control" name="nm_tampilan" placeholder="Nama" type="text" <?=$form_name;?> <?=$mark;?>>
                          </div>
                          <div class="col-md-6">
                            <input class="form-control" name="email" placeholder="E-mail" type="email" <?=$form_email;?> <?=$mark;?>>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-md-12">
                            <textarea class="form-control" rows="4" name="komentar_konten" placeholder="Pesan" style="resize:none;" required></textarea>
                            <br>
                            <button class="btn btn-flat btn-default pull-right" name="simpan_komentar" type="submit">
                              <i class="fa fa-paper-plane"></i> Kirim Komentar
                            </button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                    </div>
              <?php
              } else {
                include 'halaman/404.php';
              }
              }
              ?>
          </div>
        </section>
      </div>
    </div>
  </div>
<?php include "konten_kanan.php" ?>

<!-- Js Menu -->
<script type="text/javascript" src="assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_artikel').addClass('active');
</script>