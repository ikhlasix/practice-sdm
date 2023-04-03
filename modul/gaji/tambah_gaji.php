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
                        <label>Karyawan</label>
                        <select class="form-control" name="id_karyawan" required>
                            <option value="">Pilih Karyawan...</option>
                            <?php

                                $sql = "select * from gaji right join karyawan on gaji.id_karyawan=karyawan.id where gaji.id_karyawan is null";
                                $result = mysqli_query($conn,$sql);
                                while($row = mysqli_fetch_assoc($result)){

                            ?>
                                <option value="<?=$row['id']?>"><?=$row['nama']?></option>
                            <?php

                                }

                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gaji">Gaji</label>
                        <input type="number" class="form-control" id="gaji" name="gaji" required>
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

if(isset($_POST['id_karyawan']) || isset($_POST['gaji'])) {

    $sql = "insert into gaji 
            values(null,'" . $_POST['id_karyawan'] . "','" . $_POST['gaji'] . "')";

    mysqli_query($conn, $sql);

    header("location: ".$root."modul/gaji/table_gaji.php");

}

?>