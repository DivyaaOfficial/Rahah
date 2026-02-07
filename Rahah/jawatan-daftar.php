<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_jawatan = mysqli_real_escape_string($condb, $_POST['nama_jawatan']);

    $result = mysqli_query($condb, "SELECT MAX(idjawatan) as max_id FROM jawatan");
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'];
    $next_id = 'K1'; 

    if ($max_id) {
        $num = (int)substr($max_id, 1) + 1;
        $next_id = 'K1' . $num;
    }

    $sql = "INSERT INTO jawatan(idjawatan, nama_jawatan)
            VALUES ('$next_id', '$nama_jawatan')";

    if (mysqli_query($condb, $sql)) {
        echo "<script>alert('Jawatan berjaya didaftarkan!');</script>";
    } else {
        echo "<script>alert('Ralat: " . mysqli_error($condb) . "');</script>";
    }
}

$jawatan = mysqli_query($condb, "SELECT * FROM jawatan ORDER BY idjawatan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jawatan</title>
</head>
<body>

    <h2>BORANG DAFTAR JAWATAN</h2>

    <form method="POST" action="">
        <table border="1">
            <tr>
                <td>Nama jawatan:</td>
                <td><input type="text" name="nama_jawatan" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><button 
                    type="submit">Daftar Jawatan</button></td>
            </tr>
        </table>
    </form>

    <h3>Senarai Jawatan Sedia Ada</h3>
    <table border="1" width="100%">
        <tr>
            <th>ID Jawatan</th>
            <th>Nama Jawatan</th>
            <th>Tindakan</th>
        </tr>
        <?php
        if (mysqli_num_rows($jawatan) > 0) {
            while ($row = mysqli_fetch_assoc($jawatan)) {
                echo "<tr>";
                echo "<td>" . $row['idjawatan'] . "</td>";
                echo "<td>" . $row['nama_jawatan'] . "</td>";
                echo "<td>";
                echo "<a href='jawatan-kemaskini.php?id=" . $row['idjawatan'] . "'>Kemaskini</a> | ";
                echo "<a href='jawatan-padam.php?id=" . $row['idjawatan'] . "' onclick='return confirm(\"Anda pasti?\")'>Padam</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Tiada jawatan didaftarkan</td></tr>";
        }
         ?>
     </table>

</body>
</html>