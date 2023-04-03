<?php

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
            <h1 class="m-0">Table Karyawan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Karyawan</a></li>
              <li class="breadcrumb-item active">Table Karyawan</li>
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
            <div class="card-header">
                <a href="<?=$root?>modul/karyawan/tambah_karyawan.php" class="btn btn-primary">Tambah</a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Tahun Masuk</th>
                            <th>Fungsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $sql = "select * from karyawan";
                        $result = mysqli_query($conn, $sql);

                        $i = 1;
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) :
                        
                        ?>
                        <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $row['nama'] ?></td>
                        <td><img src="<?=$root?>dist/img/foto/<?php echo ($row['foto']=="" ? "avatar.png" : $row['foto']) ?>" alt="" height="100"></td>
                        <td><?php echo $row['jabatan'] ?></td>
                        <td><?php echo $row['tahun_masuk'] ?></td>
                        <td><?php echo $row['status'] ?></td>
                            <td>
                                <a href="<?=$root?>modul/karyawan/update_karyawan.php?id=<?=$row['id']?>" class="btn btn-warning">Ubah</a>
                                <a href="<?=$root?>modul/karyawan/delete_karyawan.php?id=<?=$row['id']?>" class="btn btn-danger" onclick="return confirm('Anda yakin?')">Hapus</a>
                            </td>
                        </tr>

                        <?php
                            endwhile; 
                        } else {
                        ?>
                
                        <tr>
                            <td colspan="5">Data tidak ada</td>
                        </tr>
                
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </section>
</div>

<?php include "../../pages/footer.php" ?>