<?php
include "koneksi.php";

$nama = $_POST['nama_project'];
$status = $_POST['status'];
$deadline = $_POST['deadline'];

mysqli_query($koneksi, "INSERT INTO project_manager VALUES (NULL, '$nama', '$status', '$deadline')");

header("Location: projectmanager.php");
?>
