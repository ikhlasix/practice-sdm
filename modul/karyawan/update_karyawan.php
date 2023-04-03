<?php

    ob_start();
    include "../../config/koneksi.php";

    if(!isset($_SESSION['username'])) {
        header("location: ".$root."login.php");
    }

    include "../../pages/header.php";
    include "../../pages/navbar.php";
    include "../../pages/sidebar.php";

    $sql = "select * from karyawan where id=" . $_GET['id'];
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)){
        $nama = $row['nama'];
        $jabatan = $row['jabatan'];
        $tahun_masuk = $row['tahun_masuk'];
        $status = $row['status'];
        $foto = $row['foto'];
    }

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
              <li class="breadcrumb-item active">Tambah Karyawan</li>
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
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?=$nama?>" required>
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
                        <label>Jabatan</label>
                        <select class="form-control" name="jabatan" required>
                            <option value="">Pilih Jabatan...</option>
                            <option value="staf" <?=($jabatan=='staf' ? 'selected': '')?>>Staff</option>
                            <option value="supervisor" <?=($jabatan=='supervisor' ? 'selected': '')?>>Supervisor</option>
                            <option value="manager" <?=($jabatan=='manager' ? 'selected': '')?>>Manager</option>
                            <option value="direktur" <?=($jabatan=='direktur' ? 'selected': '')?>>Direktur</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun_masuk">Tahun Masuk</label>
                        <input type="number" class="form-control" id="tahun_masuk" name="tahun_masuk" value="<?=$tahun_masuk?>" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" required>
                            <option value="">Pilih Status...</option>
                            <option value="tk" <?=($status=='tk' ? 'selected' : '')?>>Tidak Kawin</option>
                            <option value="k0" <?=($status=='k0' ? 'selected' : '')?>>Kawin</option>
                            <option value="k1" <?=($status=='k1' ? 'selected' : '')?>>Kawin Anak 1</option>
                            <option value="k2" <?=($status=='k2' ? 'selected' : '')?>>Kawin Anak 2</option>
                        </select>
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

if(isset($_POST['nama']) || isset($_POST['jabatan']) || isset($_POST['tahun_masuk']) || isset($_POST['status'])) {

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

    $sql = "update karyawan set nama='".$_POST['nama']."', jabatan='".$_POST['jabatan']."', tahun_masuk='".$_POST['tahun_masuk']."', status='".$_POST['status']."' where id='".$_POST['id']."'";

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

    $sql = "update karyawan set nama='".$_POST['nama']."', jabatan='".$_POST['jabatan']."', tahun_masuk='".$_POST['tahun_masuk']."', status='".$_POST['status']."',foto='".$new_nama_foto."' where id='".$_POST['id']."'";

    mysqli_query($conn, $sql);

  }

  header("location: ".$root."modul/karyawan/table_karyawan.php");

}

?>