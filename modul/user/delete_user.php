<?php

    include "../../config/koneksi.php";

    if(!isset($_SESSION['username'])) {
        header("location: ".$root."login.php");
    }


    $sql = "delete from user where id='".$_GET['id']."'";
    mysqli_query($conn, $sql);

    header("location: ".$root."modul/user/table_user.php");

?>