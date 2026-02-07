<?php
session_start();

# Menyemak kemasukan data yang diisi dalam login-borang.php
if(!empty($_POST['nokp']) and !empty($_POST['katalaluan'])) {  // BETULKAN DI SINI
    include('connection.php');

    # Mengambil data yang di-post dari fail borang
    $nokp = $_POST['nokp'];
    $katalaluan = $_POST['katalaluan'];  // BETULKAN DI SINI

    # Arahan SQL (query) untuk menyemak data yang dimasukkan
    # wujud dalam pangkalan data atau tidak
    $query_login = "SELECT * FROM pengguna 
    WHERE 
        nokp = '$nokp' 
    AND katalaluan = '$katalaluan' LIMIT 1";  // BETULKAN DI SINI

    # Melaksanakan arahan menyemak data
    $laksana_query = mysqli_query($condb, $query_login);

    # Jika terdapat 1 data yang sepadan, login berjaya
    if(mysqli_num_rows($laksana_query) == 1) {
        # Mengambil data yang ditemui
        $m = mysqli_fetch_array($laksana_query);

        # Mengumpul kepada pembolehubah session
        $_SESSION['nokp'] = $m['nokp'];
        $_SESSION['tahap'] = $m['tahap'];
        $_SESSION['nama'] = $m['nama'];

        # Membuka laman index.php
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        # Login gagal, kembali ke laman login-borang.php
        die("<script> alert('Login gagal');
        window.location.href = 'login-borang.php';</script>");
    }
} else {
    # Data yang dihantar dari laman login-borang.php kosong
    die("<script> alert('Sila masukkan nokp dan katalaluan');
    window.location.href = 'login-borang.php';</script>");
}
?>