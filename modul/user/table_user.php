<?php

    include "../../config/koneksi.php";

    if(!isset($_SESSION['username'])) {
        header("location: ".$root."login.php");
    }

    include "../../pages/header.php";
    include "../../pages/navbar.php";
    include "../../pages/sidebar.php";

    // if(!isset($_SESSION['username'])) {
    //     header("location: login.php");
    // }

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
              <li class="breadcrumb-item active">Table User</li>
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
                <a href="<?=$root?>modul/user/tambah_user.php" class="btn btn-primary">Tambah</a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>Username</th>
                          <th>Foto Profil</th>
                          <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $sql = "select * from user";
                        $result = mysqli_query($conn, $sql);

                        $i = 1;
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) :
                        
                        ?>
                        <tr>
                          <td><?php echo $row['id']?></td>
                          <td><?php echo $row['username']?></td>
                          <td><img src="<?=$root?>dist/img/foto/<?php echo ($row['foto']=="" ? "avatar.png" : $row['foto'])?>" height="100"></td>
                          <td>
                              <a href="<?=$root?>modul/user/update_user.php?id=<?=$row['id']?>" class="btn btn-warning">Ubah</a>
                              <a href="<?=$root?>modul/user/delete_user.php?id=<?=$row['id']?>" class="btn btn-danger" onclick="return confirm('Anda yakin?')">Hapus</a>
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