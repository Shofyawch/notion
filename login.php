<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) > 0){
    $_SESSION['username'] = $username;
    header("Location: dashboard.html");
    exit();
} else {
    echo "<script>alert('Username atau password salah'); window.location='login.html';</script>";
}
?>
