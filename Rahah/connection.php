<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
$nama_host="localhost";
$nama_sql="root";
$pass_sql="";
$nama_db="undi_ajk";
$condb= mysqli_connect($nama_host, $nama_sql, $pass_sql, $nama_db);
if (!$condb)
{
    die("Sambungan ke pangkalan data gagal");
}    
else
{
    #echo "sambungan ke pangkalan data berjaya"
}