<?php
session_start();
include "koneksi.php";

$user_id = $_SESSION['id'];
$note = $_POST['note'];

mysqli_query($koneksi, "INSERT INTO notes (id, note) VALUES ('$user_id', '$note')");

header("Location: dashboard.php");
exit;
