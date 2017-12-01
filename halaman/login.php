<section class="content-header">
  <h1>
    Masuk
    <small>Sistem Informasi Akademik Sekolah</small>
  </h1>
  <ol class="breadcrumb">
    <li class="active"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-user"></i> Masuk</a></li>
  </ol>   
</section>

<div class="col-md-12">
<div class="login-box">
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <form method="post">
      <div class="form-group has-feedback">
        <input type="text" name="nm_pengguna" class="form-control" placeholder="Username" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="kata_sandi" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <?php
      if(isset($_POST['masuk'])){
        $nm_pengguna = $_POST['nm_pengguna'];
        $kata_sandi  = $_POST['kata_sandi'];
        $sandi_md5    = md5($kata_sandi);
        $cek_user = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE nm_pengguna='$nm_pengguna'");
        if (mysqli_num_rows($cek_user) == 1) {
          $user = mysqli_fetch_array($cek_user);
          if ($kata_sandi == $user['kata_sandi']) {
            if ($user['status'] == 'admin') {
              $_SESSION['nm_pengguna'] = $nm_pengguna;
              $_SESSION['nm_tampilan'] = $user['nm_tampilan'];
              $_SESSION['gambar']      = $user['gambar'];
              $_SESSION['status']      = $user['status'];
              $_SESSION['email']       = $user['email'];
              $_SESSION['id_user']     = $user['id_user'];
              //header('location:admin/');
              echo "
              <div class='form-group'>
                <label class='col-md-12 text-success'>
                  <center>
                    <i class='fa fa-check'></i> Berhasil, silahkan tunggu..
                  </center>
                </label>
              </div>
              <meta http-equiv='refresh' content='0;url=admin' />";
            } else if ($user['status'] == 'guru') {
              $_SESSION['nm_pengguna'] = $nm_pengguna;
              $_SESSION['nm_tampilan'] = $user['nm_tampilan'];
              $_SESSION['gambar']      = $user['gambar'];
              $_SESSION['status']      = $user['status'];
              $_SESSION['email']       = $user['email'];
              $_SESSION['id_user']     = $user['id_user'];
              $_SESSION['guru_id']     = $user['guru_id'];
              //header('location:admin/user/');
              echo "
              <div class='form-group'>
                <label class='col-md-12 text-success'>
                  <center>
                    <i class='fa fa-check'></i> Berhasil, silahkan tunggu..
                  </center>
                </label>
              </div>
              <meta http-equiv='refresh' content='0;url=admin/user' />";
            } else {
              echo "<script>alert('Anda tidak memiliki hak akses ke halaman ini !')</script>";
              echo "<meta http-equiv='refresh' content='0;url=index.php' />";
            }
            } else {
              echo "    
              <div class='form-group'>
                <label class='col-md-12 text-danger'>
                  <center>
                   <i class='fa fa-warning'></i> Kata sandi salah
                 </center>
               </label>
             </div>
             ";
           }
         } else {
        echo "
        <div class='form-group'>
          <label class='col-md-12 text-danger'>
            <center>
              <i class='fa fa-warning'></i> Nama pengguna salah
            </center>
          </label>
        </div>
        ";
      }
      }
      ?>      
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" name="masuk" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
      </div>
    </form>
  </div>
</div>
</div>

<!-- Js Menu -->
<script type="text/javascript" src="assets/js/jquery-min.js"></script> 
<script type="text/javascript">
  $('#m_kontak').addClass('active');
</script>