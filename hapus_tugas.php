<?php
include 'koneksi.php';

$id = $_POST['id'];
$query = "DELETE FROM tugas WHERE id = $id";

if(mysqli_query($koneksi, $query)){
    echo "Sukses";
} else {
    echo "Gagal";
}
?>