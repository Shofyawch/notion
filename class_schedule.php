<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
$id_user = $_SESSION['id'];

// ====== ADD (CREATE) ======
if (isset($_POST['add'])) {
    $time_slot = mysqli_real_escape_string($koneksi, $_POST['time_slot']);
    $monday    = mysqli_real_escape_string($koneksi, $_POST['monday']);
    $tuesday   = mysqli_real_escape_string($koneksi, $_POST['tuesday']);
    $wednesday = mysqli_real_escape_string($koneksi, $_POST['wednesday']);
    $thursday  = mysqli_real_escape_string($koneksi, $_POST['thursday']);
    $friday    = mysqli_real_escape_string($koneksi, $_POST['friday']);

    mysqli_query($koneksi, "INSERT INTO class_schedule (user_id, time_slot, monday, tuesday, wednesday, thursday, friday)
                            VALUES ('$id_user','$time_slot','$monday','$tuesday','$wednesday','$thursday','$friday')")
        or die("INSERT ERROR: " . mysqli_error($koneksi));

    header("Location: class_schedule.php");
    exit;
}

// ====== DELETE ======
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($koneksi, "DELETE FROM class_schedule WHERE id = $id AND user_id = $id_user")
        or die("DELETE ERROR: " . mysqli_error($koneksi));

    header("Location: class_schedule.php");
    exit;
}

// ====== UPDATE ======
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $time_slot = mysqli_real_escape_string($koneksi, $_POST['time_slot']);
    $monday    = mysqli_real_escape_string($koneksi, $_POST['monday']);
    $tuesday   = mysqli_real_escape_string($koneksi, $_POST['tuesday']);
    $wednesday = mysqli_real_escape_string($koneksi, $_POST['wednesday']);
    $thursday  = mysqli_real_escape_string($koneksi, $_POST['thursday']);
    $friday    = mysqli_real_escape_string($koneksi, $_POST['friday']);

    mysqli_query($koneksi, "UPDATE class_schedule
                            SET time_slot='$time_slot', monday='$monday', tuesday='$tuesday', wednesday='$wednesday', thursday='$thursday', friday='$friday'
                            WHERE id=$id AND user_id=$id_user")
        or die("UPDATE ERROR: " . mysqli_error($koneksi));

    header("Location: class_schedule.php");
    exit;
}

// ====== SELECT (READ) ======
$data = mysqli_query($koneksi, "SELECT * FROM class_schedule WHERE user_id = '$id_user' ORDER BY time_slot ASC")
    or die("SELECT ERROR: " . mysqli_error($koneksi));
?>
