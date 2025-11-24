<?php
include "koneksi.php";
session_start();

$user_id = $_SESSION['id'];
$note = $_POST['note'];

mysqli_query($koneksi, "INSERT INTO notes (user_id, note) VALUES ('$user_id', '$note')");

header("Location: dashboard.php");
exit;
?>