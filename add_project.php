<!DOCTYPE html>
<html>
<head>
    <title>Tambah Proyek</title>
</head>
<body>

<h2>Tambah Proyek Baru</h2>

<form action="save_project.php" method="POST">
    Nama Proyek: <br>
    <input type="text" name="nama_project" required><br><br>

    Status: <br>
    <select name="status">
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
    </select><br><br>

    Deadline: <br>
    <input type="date" name="deadline" required><br><br>

    <button type="submit">Simpan</button>
</form>

</body>
</html>
