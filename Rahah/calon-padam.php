<?php
session_start();
include('kawalan-admin.php');

if(!empty($_GET['id_calon'])) {
    include('connection.php');

    $id_calon = mysqli_real_escape_string($condb, $_GET['id_calon']);

    mysqli_begin_transaction($condb);

    try {
        $delete_undian = "DELETE FROM undian WHERE id_calon = '$id_calon'";
        if(!mysqli_query($condb, $delete_undian)) {
            throw new Exception("Gagal memadam undian: " . mysqli_error($condb));
        }

        $delete_calon = "DELETE FROM calon WHERE id_calon = '$id_calon'";
        if(!mysqli_query($condb, $delete_calon)) {
            throw new Exception("Gagal memadam calon: " . mysqli_error($condb));
        }

        mysqli_commit($condb);
        echo "<script>alert('Padam calon berjaya');
        window.location.href = 'calon-senarai.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($condb);
        echo "<script>alert('Padam calon gagal: " . addslashes($e->getMessage()) . "');
        window.location.href = 'calon-senarai.php';</script>";
    }
} else {
    die("<script>alert('Ralat! Akses secara langsung');
    window.location.href = 'calon-senarai.php';</script>");
}
?>