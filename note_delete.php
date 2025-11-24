<?php
include "koneksi.php";
session_start();

$id = $_GET['id'];
$user_id = $_SESSION['id'];

mysqli_query($koneksi, "DELETE FROM notes WHERE id='$id' AND user_id='$user_id'");

header("Location: dashboard.php");
exit;
?>