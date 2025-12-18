<?php
session_start();
include "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Gunakan id_note sesuai struktur tabel SQL kamu
    mysqli_query($koneksi, "DELETE FROM notes WHERE id_note='$id'");
}

header("Location: dashboard.php");
exit;
?>