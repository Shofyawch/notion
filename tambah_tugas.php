<?php
include 'koneksi.php';

$mapel = $_POST['mapel'];
$detail = $_POST['detail'];
$deadline = $_POST['deadline'];
$status = $_POST['status'];

$query = "INSERT INTO tugas (mapel, detail, deadline, status) VALUES ('$mapel', '$detail', '$deadline', '$status')";

if(mysqli_query($koneksi, $query)){
    // Mengembalikan ID data yang baru saja dibuat agar bisa dipakai tombol hapus di JS
    echo mysqli_insert_id($koneksi); 
} else {
    echo "Error";
}
?>