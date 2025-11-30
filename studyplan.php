<?php 
include "koneksi.php"; 
session_start();

// Ambil ID user yg sedang login
$id_user = $_SESSION['user_id'] ?? null;

// ========== CREATE ==========
if (isset($_POST['add'])) {
    $time = $_POST['time_range'];
    $activity = $_POST['activity'];

    mysqli_query($koneksi, 
        "INSERT INTO studyplanner (time_range, activity, id) 
         VALUES ('$time', '$activity', '$id_user')"
    );

    header("Location: studyplan.php");
    exit;
}

// ========== DELETE ==========
if (isset($_GET['delete']) && $_GET['delete'] !== "") {

    $id_del = intval($_GET['delete']); 

    mysqli_query($koneksi, 
        "DELETE FROM studyplanner WHERE id_studyplanner = $id_del AND id = '$id_user'"
    );

    header("Location: studyplan.php");
    exit;
}

// ========== UPDATE ==========
if (isset($_POST['update'])) {

    $id_edit = $_POST['id'];
    $time = $_POST['time_range'];
    $activity = $_POST['activity'];

    mysqli_query($koneksi, 
        "UPDATE studyplanner 
         SET time_range = '$time', activity = '$activity'
         WHERE id_studyplanner = $id_edit AND id = '$id_user'"
    );

    header("Location: studyplan.php");
    exit;
}

// ========== GET DATA STUDY PLAN USER ==========
$data = mysqli_query($koneksi, 
    "SELECT * FROM studyplanner 
     WHERE id = '$id_user' 
     ORDER BY id_studyplanner DESC"
);
?>
