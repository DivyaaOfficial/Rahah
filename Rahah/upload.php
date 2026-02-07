<?php
session_start();

include('header.php');
include('kawalan-admin.php');
?>

<h3>Muat Naik Data Pengguna (*.txt)</h3>

<form action='' method='POST' enctype='multipart/form-data'>

    <h3><b>Sila Pilih Fail txt yang ingin diupload</b></h3>
    <input type='file' name='data_admin'>
    <button type='submit' name='btn-upload'>Muat Naik</button>

</form>
<?php include ('footer.php'); ?>

<?PHP
if (isset($_POST['btn-upload']))
{
    include ('connection.php');

    $namafailsementara=$_FILES["data_admin"]["tmp_name"];

    $namafail=$_FILES['data_admin']['name'];

    $jenisfail=pathinfo($namafail, PATHINFO_EXTENSION);

    if($_FILES["data_admin"]["size"]>0 AND $jenisfail=="txt")
    {
        $fail_data_admin=fopen($namafailsementara,"r");
        $success = true;
        $total_data = 0;
        $data_berjaya = 0;

        while (!feof($fail_data_admin))
        {
            $sambilbarisdata = trim(fgets($fail_data_admin));

            if(empty($sambilbarisdata)) continue;

            $total_data++;

            $pecahkanbaris = explode("|", $sambilbarisdata);

            if(count($pecahkanbaris) < 4) {
                $success = false;
                continue;
            }

            list($nama, $nokp, $katalaluan, $tahap) = $pecahkanbaris;

            $nama = trim($nama);
            $nokp = trim($nokp);
            $katalaluan = trim($katalaluan);
            $tahap = trim($tahap);

            $arahan_sql_simpan = "INSERT INTO pengguna
            (nama, nokp, katalaluan, tahap) VALUES
            ('$nama', '$nokp', '$katalaluan', '$tahap')";

            $laksana_arahan_simpan = mysqli_query($condb, $arahan_sql_simpan);

            if($laksana_arahan_simpan) {
                $data_berjaya++;
            } else {
                $success = false;
            }
        }
        fclose($fail_data_admin);

        if($success) {
            echo "<script>alert('$total_data rekod berjaya diimport.');
            window.location.href='pengguna-senarai.php';
            </script>";
        } else {
            echo "<script>alert('Import gagal. Sila semak format fail.');
            window.location.href='pengguna-senarai.php';
            </script>";
        }
    }
    else
    {
        echo "<script>alert('Hanya fail berformat txt sahaja dibenarkan');</script>";
    } 
}
?>           