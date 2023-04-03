<?php

    ob_start();
    include "../../config/koneksi.php";

    if(!isset($_SESSION['username'])) {
        header("location: ".$root."login.php");
    }

    include "../../pages/header.php";
    include "../../pages/navbar.php";
    include "../../pages/sidebar.php";

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Table User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">User</a></li>
              <li class="breadcrumb-item active">Tambah User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" data-enable-remember="TRUE" data-no-transition-after-reload="TRUE">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" id="foto" name="foto" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </form>
            </div>
        </div>
      </div>
    </section>
</div>

<?php include "../../pages/footer.php" ?>

<?php

if(isset($_POST['username']) || isset($_POST['password'])){

    $sql = "select * from user where username='".$_POST['username']."'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
      echo "<script>alert('username sudah ada, silakan ganti username anda')</script>";
      die();
    }

    $lokasi_foto = $_FILES['foto']['tmp_name'];
    $nama_foto = $_FILES['foto']['name'];
    $ukuran_foto = $_FILES['foto']['size'];
    $tipe_foto = $_FILES['foto']['type'];
    

    $ext = explode('.', $nama_foto);
    $new_nama_foto = str_replace(" ",'_',$ext[0]) . date('Ymdhis') . "." . $ext[1];
    $folder_foto = "../../dist/img/foto/" . $new_nama_foto;

    //size maksimal
    $size_max = 5000000;

    //pembatasan tipe file

    $tipe_boleh = array("image/jpeg", "image/png");

    // cek apakah file ada / tidak

    if(strlen($nama_foto) < 1){
      echo "<script>alert('Foto belum dipilih')</script>";
      die();
    }

    //cek ukurannya

    if($ukuran_foto > $size_max){
      echo "<script>alert('Ukuran foto harus dibawah 5 MB')</script>";
      die();
    }

    // cek foto corrupt

    if($tipe_foto=="" || empty($tipe_foto)){
      echo "<script>alert('Foto yang anda upload rusak')</script>";
      die();
    }

    // cek tipe file

    if(!in_array($tipe_foto, $tipe_boleh)){
      echo "<script>alert('Tipe foto harus jpg atau png, tipe foto anda ".$tipe_foto."')</script>";
      die();
    }

    move_uploaded_file($lokasi_foto, $folder_foto);

    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "insert into user values (null , '" . $_POST['username'] . "' , '" . $password_hash .  "' , '" . $new_nama_foto . "')";

    mysqli_query($conn, $sql);

    header("location: ".$root."modul/user/table_user.php");

}
?>