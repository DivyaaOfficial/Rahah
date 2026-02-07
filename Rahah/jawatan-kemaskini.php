<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

$id = $_GET['id'] ?? '';

// Dapatkan data jawatan
$result = mysqli_query($condb, "SELECT * FROM jawatan WHERE idjawatan = '$id'");
$jawatan = mysqli_fetch_assoc($result);

// Proses form jika data dihantar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_jawatan = mysqli_real_escape_string($condb, $_POST['id_jawatan']);
    $nama_jawatan = mysqli_real_escape_string($condb, $_POST['nama_jawatan']);

    // Semak jika ID baru sudah wujud (kecuali jika sama dengan ID asal)
    if ($id_jawatan != $id) {
        $check_sql = "SELECT idjawatan FROM jawatan WHERE idjawatan = '$id_jawatan'";
        $check_result = mysqli_query($condb, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Ralat: ID Jawatan \"$id_jawatan\" sudah wujud dalam sistem!');</script>";
        } else {
            // Kemaskini kedua-dua ID dan nama jika ID baru unik
            $sql = "UPDATE jawatan SET idjawatan = '$id_jawatan', nama_jawatan = '$nama_jawatan'
                    WHERE idjawatan = '$id'";

            if (mysqli_query($condb, $sql)) {
                echo "<script>alert('Jawatan berjaya dikemaskini!');
                window.location.href='jawatan-daftar.php';</script>";
            } else {
                echo "<script>alert('Ralat: " . mysqli_error($condb) . "');</script>";
            }
        }
    } else {
        // Jika ID tidak berubah, hanya kemaskini nama jawatan
        $sql = "UPDATE jawatan SET nama_jawatan = '$nama_jawatan' WHERE idjawatan = '$id'";

        if (mysqli_query($condb, $sql)) {
            echo "<script>alert('Jawatan berjaya dikemaskini!');
            window.location.href='jawatan-daftar.php';</script>";
        } else {
            echo "<script>alert('Ralat: " . mysqli_error($condb) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kemaskini Jawatan</title>
</head>
<body>
    <h2>KEMASKINI JAWATAN</h2>

    <form method="POST" action="">
        <table border="1">
            <tr>
                <td>ID Jawatan:</td>
                <td><input type="text" name="id_jawatan"
                        value="<?php echo $jawatan['idjawatan']; ?>" required></td>
            </tr>
            <tr>
                <td>Nama Jawatan:</td>
                <td><input type="text" name=""nama_jawatan"
                        value="<?php echo $jawatan['nama_jawatan']; ?>" required><td>
            </tr>                
            <tr>
                <td colspan="2" align="center">
                    <button type="submit">Kemaskini</button>
                    <a href="jawatan-daftar.php">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>    
</html>