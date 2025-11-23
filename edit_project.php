<?php
include "koneksi.php";

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM project_manager WHERE id_project=$id"));
?>

<h2>Edit Proyek</h2>

<form action="update_project.php" method="POST">

    <input type="hidden" name="id" value="<?= $data['id_project'] ?>">

    Nama Proyek: <br>
    <input type="text" name="nama_project" value="<?= $data['nama_project'] ?>" required><br><br>

    Status: <br>
    <select name="status">
        <option <?= $data['status']=='In Progress'?'selected':'' ?>>In Progress</option>
        <option <?= $data['status']=='Completed'?'selected':'' ?>>Completed</option>
    </select><br><br>

    Deadline: <br>
    <input type="date" name="deadline" value="<?= $data['deadline'] ?>" required><br><br>

    <button type="submit">Update</button>
</form>
