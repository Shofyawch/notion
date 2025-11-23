<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "multi_user");

// Cek error koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

// Cek confirm password
if ($password !== $confirm) {
    echo "<script>alert('Password tidak sama!'); window.location='register.html';</script>";
    exit();
}

// Enkripsi password (penting)
$hash = password_hash($password, PASSWORD_DEFAULT);

// Query insert
$sql = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$hash')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Register berhasil!'); window.location='login.html';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
