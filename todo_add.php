<?php
include "koneksi.php";
session_start();

$id_user = $_SESSION["id"];
$isi = $_POST["isi_todo"];

mysqli_query($koneksi, "INSERT INTO todo (`id`, `isi_todo`, `status`) VALUES ('$id_user', '$isi', 0)");

header("Location: todo.php");
exit;
