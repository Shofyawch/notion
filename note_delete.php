<?php
session_start();
include "koneksi.php";

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM notes WHERE note_id='$id'");

header("Location: dashboard.php");
exit;
?>