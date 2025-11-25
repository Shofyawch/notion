<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$task_text = $_POST['task_text'];

mysqli_query($koneksi, "INSERT INTO tasks (user_id, task_text) VALUES ('$user_id', '$task_text')");
header("Location: dahsboard.php");
?>
