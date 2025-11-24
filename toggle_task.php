<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$task_id = $_GET['id'];
$is_done = $_GET['done'];

mysqli_query($koneksi, "UPDATE tasks SET is_done='$is_done' WHERE id='$task_id'");
header("Location: dahsboard.php");
?>
