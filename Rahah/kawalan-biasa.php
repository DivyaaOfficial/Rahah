<?php
if(!empty($_SESSION['tahap'])) {
    if($_SESSION['tahap'] != 'PENGGUNA')
    {
        die("<script>alert('Sila login');
        window.location.href='logout.php';</script>");
    }    
} else {
    die("<script>alert('Sila login');
    window.location.href='logout.php';</script>");
}
?>