<?php
include "koneksi.php";

// Ambil data dari form
$nama       = $_POST['nama'];
$username   = $_POST['username'];
$email      = $_POST['email'];
$password   = $_POST['password'];
$confirm    = $_POST['confirm_password'];

// Validasi field kosong
if(empty($nama) || empty($username) || empty($email) || empty($password) || empty($confirm)){
    echo "<script>alert('Semua field harus diisi!'); window.location='register.html';</script>";
    exit();
}

// Cek password & confirm password
if($password !== $confirm){
    echo "<script>alert('Password dan Confirm Password tidak sama!'); window.location='register.html';</script>";
    exit();
}

// Enkripsi password
$hashed = md5($password); // sederhananya

// Cek apakah email sudah ada
$checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
if(mysqli_num_rows($checkEmail) > 0){
    echo "<script>alert('Email sudah terdaftar!'); window.location='register.html';</script>";
    exit();
}

// Cek apakah username sudah digunakan
$checkUsername = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if(mysqli_num_rows($checkUsername) > 0){
    echo "<script>alert('Username sudah dipakai!'); window.location='register.html';</script>";
    exit();
}

// Set role default = user
$level = "user";

// Simpan ke database
$sql = "INSERT INTO users (nama, username, email, password, level)
        VALUES ('$nama', '$username', '$email', '$hashed', '$level')";

if(mysqli_query($conn, $sql)){
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.html';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
