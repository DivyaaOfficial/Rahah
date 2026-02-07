<?php
session_start();
include('kawalan-admin.php');

if(!empty($_GET)){
    include('connection.php');

    $arahan = "delete from pengguna where nokp ='".$_GET['nokp']."'";

    if(mysqli_query($condb,$arahan)){
        echo "<script> alert('Padam data berjaya');
        window.location.href = 'pengguna-senarai.php';</script>";
    }else{
        echo"<script> alert('Padam data gagal');
        window.location.href = 'pengguna-senarai.php';</script>";
    }
}else{
    die("<script> alert('Ralat! Akses secara terus');
    window.location.href = 'pengguna-senarai.php';</script>");
}
?>