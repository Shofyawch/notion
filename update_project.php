<?php
include "koneksi.php";

$id = $_POST['id'];
$nama = $_POST['nama_project'];  
$status = $_POST['status'];
$deadline = $_POST['deadline'];

mysqli_query($koneksi, "UPDATE project_manager SET 
    name='$nama',
    status='$status',
    deadline='$deadline'
    WHERE id_project=$id");

header("Location: projectmanager.php");
exit;
?>
