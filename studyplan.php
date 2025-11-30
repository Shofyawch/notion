<?php 
include "koneksi.php"; 
session_start();

// ====== CRUD ACTIONS ======

// CREATE
if (isset($_POST['add'])) {
    $time = $_POST['time_range'];
    $activity = $_POST['activity'];
    $uid = $_SESSION['user_id'] ?? null;

    mysqli_query($koneksi, "INSERT INTO study_plan (time_range, activity, user_id) 
                        VALUES ('$time', '$activity', '$uid')");
    header("Location: studyplan.php");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM study_plan WHERE id=$id");
    header("Location: studyplan.php");
    exit;
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $time = $_POST['time_range'];
    $activity = $_POST['activity'];

    mysqli_query($koneksi, 
        "UPDATE study_plan SET time_range='$time', activity='$activity' WHERE id=$id"
    );
    header("Location: studyplan.php");
    exit;
}

// GET DATA
$uid = $_SESSION['user_id'] ?? null;
$data = mysqli_query($koneksi, "SELECT * FROM study_plan WHERE user_id='$uid'");
?>
