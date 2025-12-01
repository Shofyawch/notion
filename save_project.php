<?php
session_start();
include "koneksi.php";

$user_id = $_SESSION['id'];  // ambil id user yang login

$nama = $_POST['nama_project'];
$status = $_POST['status'];
$deadline = $_POST['deadline'];

$query = "INSERT INTO project_manager (name, status, deadline, id)
          VALUES ('$nama', '$status', '$deadline', '$user_id')";

mysqli_query($koneksi, $query);

header('Location: projectmanager.php');
exit;
?>
