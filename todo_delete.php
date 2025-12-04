<?php
include "koneksi.php";

$id = $_GET["id"];

$cek = mysqli_query($conn, "SELECT status FROM todo WHERE id_todo=$id");
$data = mysqli_fetch_assoc($cek);
$newStatus = $data['status'] ? 0 : 1;

mysqli_query($koneksi, "UPDATE todo SET status=$newStatus WHERE id_todo=$id");

header("Location: todo.php");
exit;
