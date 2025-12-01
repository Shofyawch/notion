<?php
include "koneksi.php";
session_start();
$user_id = $_SESSION['id']; // id dari tabel users

// AMBIL TOTAL PROJECT
$total = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT COUNT(*) AS total FROM project_manager WHERE id=$user_id"
))['total'];

$completed = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT COUNT(*) AS total FROM project_manager WHERE status='Completed' AND id=$user_id"
))['total'];

$progress = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT COUNT(*) AS total FROM project_manager WHERE status='In Progress' AND id=$user_id"
))['total'];

// AMBIL DATA PROJECT
$query = mysqli_query($koneksi, 
    "SELECT * FROM project_manager WHERE id=$user_id ORDER BY id_project DESC"
);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajer Proyek Belajar</title>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            background-image: url('bg3.gif');
            background-size: cover;
            background-attachment: fixed;
        }

        .sidebar {
            width: 25vw;
            min-width: 260px;
            height: 100vh;
            background-color: rgba(188, 228, 255, 0.7);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px;
            box-sizing: border-box;
        }

        .sidebar h2 { 
            margin-bottom: 25px; }

        .sidebar a {
            display: block;
            font-size: 20px;
            margin-bottom: 20px;
            color: #e0e0e0;
            text-decoration: none;
            transition: 0.2s;
        }
        .sidebar a:hover { color: #fff; font-weight: bold; }

        .main-content {
            margin-left: 25vw;
            padding: 25px;
        }

        .main-content h1 {
            color: #333;
            margin-bottom: 20px;

        }

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            width: 30%;
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(255,105,180,0.3);
        }

        .card h3 { margin-bottom: 10px; }

        .project-table {
            margin-top: 25px;
            padding: 25px;
            background: white;
            border-radius: 18px;
            box-shadow: 0 10px 20px rgba(255,105,180,0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            border: 2px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background: #68c8ed;
            color: white;
        }

        .btn-add {
            background: #55c0ea;
            color: white;
            padding: 10px 18px;
            border-radius: 12px;
            text-decoration: none;
        }

        .btn-edit { color: blue; }
        .btn-del { color: red; }

    </style>
</head>

<body>

<div class="sidebar">
    <h2>Menu</h2>
    <a href="dahsboard.php">Dashboard</a>
    <a href="projectmanager.php">Project Manager</a>
    <a href="tabletugas.php">Tabel tugas</a>
    <a href="calender.php">Calender</a>
    <a href="study planner.php">Study planner</a>
    <a href="todo.php">To Do List</a>
    <a href="media.php">Media</a>
</div>

<div class="main-content">

    <h1>Manajer Proyek Belajar</h1>

    <!-- CARDS -->
    <div class="cards">
        <div class="card">
            <h3>Total Projects</h3>
            <p><?= $total ?></p>
        </div>

        <div class="card">
            <h3>Completed</h3>
            <p><?= $completed ?></p>
        </div>

        <div class="card">
            <h3>In Progress</h3>
            <p><?= $progress ?></p>
        </div>
    </div>

    <div class="project-table">
        <h2>Daftar Proyek</h2>

        <a class="btn-add" href="add_project.php">+ Tambah Proyek</a>

        <table>
            <thead>
                <tr>
                    <th>Nama Proyek</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
    <?php if (mysqli_num_rows($query) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['deadline'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><a href="edit_project.php?id=<?= $row['id_project'] ?>">Edit</a>
            <a href="delete_project.php?id=<?= $row['id_project'] ?>">Delete</a>
            </td>
                
            </tr>
        <?php endwhile; ?>

    <?php else: ?>
        <tr>
            <td colspan="4" style="text-align:center; color:gray;">
                Belum ada proyek
            </td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
    </div>

</div>

</body>
</html>
