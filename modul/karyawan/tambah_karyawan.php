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
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
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
                        <label>Jabatan</label>
                        <select class="form-control" name="jabatan" required>
                            <option value="">Pilih Jabatan...</option>
                            <option value="staf">Staff</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="manager">Manager</option>
                            <option value="direktur">Direktur</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun_masuk">Tahun Masuk</label>
                        <input type="number" class="form-control" id="tahun_masuk" name="tahun_masuk" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" required>
                            <option value="">Pilih Status...</option>
                            <option value="tk">Tidak Kawin</option>
                            <option value="k0">Kawin</option>
                            <option value="k1">Kawin Anak 1</option>
                            <option value="k2">Kawin Anak 2</option>
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

    // size maksimal
    $size_max = 5000000;

    // pembatasan tipe file
    $tipe_boleh = array("image/jpeg","image/png");

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

    $sql = "insert into karyawan 
            values(null,'" . $_POST['nama'] . "',
            '" . $_POST['jabatan'] . "',
            '" . $_POST['tahun_masuk'] . "',
            '" . $_POST['status'] . "',
            '" . $new_nama_foto . "')";

    mysqli_query($conn, $sql);

    header("location: ".$root."modul/karyawan/table_karyawan.php");

}

?>