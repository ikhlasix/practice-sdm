<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sumber_daya_manusia";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Database tidak terkoneksi!");
} 

$server = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
$root = $server . "sdm/";

?>