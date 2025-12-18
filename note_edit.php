<?php
session_start();
include "koneksi.php";

$id_note = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM notes WHERE id_note='$id_note'");
$n = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $note_baru = $_POST['note'];
    mysqli_query($koneksi, "UPDATE notes SET note='$note_baru' WHERE id_note='$id_note'");
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Note</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fff8d6; padding: 50px; }
        .edit-box { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        textarea { width: 100%; height: 150px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
        button { background: #ffd447; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="edit-box">
        <h2>Edit Catatan</h2>
        <form method="POST">
            <textarea name="note"><?= $n['note'] ?></textarea>
            <button type="submit" name="update">Update Note</button>
            <a href="dashboard.php" style="margin-left: 10px; color: #888; text-decoration: none;">Batal</a>
        </form>
    </div>
</body>
</html>