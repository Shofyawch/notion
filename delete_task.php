<?php
session_start();
include "koneksi.php";

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM tasks WHERE id='$id'");
header("Location: dashboard.php");
?>
