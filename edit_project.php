<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];          
$user_id = $_SESSION['id']; 

$data = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT * FROM project_manager WHERE id_project=$id AND id=$user_id"
));

if(!$data){
    die("Akses ditolak!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek</title>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            background-image: url('bg3.gif');
            background-size: cover;
            background-attachment: fixed;
        }
        .container {
            width: 40%;
            margin: 80px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 10px 20px rgba(255,105,180,0.3);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        label {
            font-size: 18px;
            font-weight: 600;
        }
        input, select {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 18px;
            border: 2px solid #85d7ff;
            border-radius: 10px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            background: #55c0ea;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            transition: 0.2s;
        }
        button:hover {
            background: #3ca8d6;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #005c82;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Proyek</h2>

    <form action="update_project.php" method="POST">

        <input type="hidden" name="id" value="<?= $data['id_project'] ?>">

        <label>Nama Proyek:</label>
        <input type="text" name="nama_project" value="<?= $data['name'] ?>" required>

        <label>Status:</label>
        <select name="status">
            <option value="In Progress" <?= $data['status']=='In Progress'?'selected':'' ?>>In Progress</option>
            <option value="Completed" <?= $data['status']=='Completed'?'selected':'' ?>>Completed</option>
        </select>

        <label>Deadline:</label>
        <input type="date" name="deadline" value="<?= $data['deadline'] ?>" required>

        <button type="submit">Update</button>
    </form>

    <a class="back-link" href="projectmanager.php">← Kembali</a>
</div>

</body>
</html>
