<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

$id = $_GET['id'] ?? '';

if (!empty($id)) {
    $sql = "DELETE FROM jawatan WHERE idjawatan = '$id'";

    if (mysqli_query($condb, $sql)) {
        echo "<script>alert('Jawatan berjaya dipadam!');
            window.location.href='jawtan-daftar.php';</sript>";
    } else {
        echo "<script>alert('Ralat: " . mysqli_error($condb) . "');
            window.location.href='jawatan-daftar.php';</script>";
    }
} else {
    header("Location: jawatn-daftar.php");
}    
?>