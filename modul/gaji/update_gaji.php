<?php

    ob_start();
    include "../../config/koneksi.php";

    if(!isset($_SESSION['username'])) {
        header("location: ".$root."login.php");
    }

    include "../../pages/header.php";
    include "../../pages/navbar.php";
    include "../../pages/sidebar.php";

    if(isset($_POST['id_karyawan']) || isset($_POST['gaji'])) {

      $sql = "update gaji set gaji='".$_POST['gaji']."' where id='".$_POST['id']."'";
    
      mysqli_query($conn, $sql);

      header("location: ".$root."modul/gaji/table_gaji.php");
    
    }

    $sql = "select * from gaji where id=" . $_GET['id'];
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $id_karyawan = $row['id_karyawan'];
        $gaji = $row['gaji'];
    }

    $sql = "select * from karyawan where id=".$id_karyawan;
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $nama = $row['nama'];
    }

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Table Gaji</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Gaji</a></li>
              <li class="breadcrumb-item active">Tambah Gaji</li>
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
                        <label for="nama">Karyawan</label>
                        <input type="hidden" name="id" value="<?=$_GET['id']?>">
                        <input type="hidden" name="id_karyawan" value="<?=$id_karyawan?>">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?=$nama?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="gaji">Gaji</label>
                        <input type="number" class="form-control" id="gaji" name="gaji" value="<?=$gaji?>" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </form>
            </div>
        </div>
      </div>
    </section>
</div>

<?php include "../../pages/footer.php" ?>