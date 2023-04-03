<?php

    ob_start();
    include "../../config/koneksi.php";

    if(!isset($_SESSION['username'])) {
        header("location: ".$root."login.php");
    }

    include "../../pages/header.php";
    include "../../pages/navbar.php";
    include "../../pages/sidebar.php";

    $sql = "select * from user  where id=" . $_GET['id'];
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $username= $row['username'];
        $foto= $row['foto'];
    }

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
                    <input type="hidden" name="id" value="<?=$_GET['id']?>">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?=$username?>" required>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <?php if(isset($foto)) : ?>
                        <div class="d-flex mb-4">
                            <img src="../../dist/img/foto/<?=$foto?>" alt="" style="width: 300px;">
                        </div>
                        <?php endif; ?>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" id="foto" name="foto" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="">
                    </div>
                    <div class="form-group">
                        <label for="repassword">Ulangi Password</label>
                        <input type="password" class="form-control" id="repassword" name="repassword" value="">
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

if( isset($_POST['username']) || isset($_POST['password'])){

  $query_password = "";
  if(!empty($_POST['password']) || $_POST['password']!=''){
    if($_POST['password']!=$_POST['repassword']){
        echo "<script>if(!alert('Password tidak sama')) window.location.href; </script>";
        die();
    }
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $query_password = ",password='".$password_hash."'";
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

    $sql = "update user set username='".$_POST['username']."' ".$query_password." where id='".$_POST['id']."'";

    mysqli_query($conn, $sql);

  } else {

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

    $sql = "update user set username='".$_POST['username']."' ".$query_password." , foto='".$new_nama_foto."' where id='".$_POST['id']."'";

    mysqli_query($conn, $sql);

  }

  header("location: ".$root."modul/user/table_user.php");

}

?>