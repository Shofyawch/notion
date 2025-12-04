<?php
include "koneksi.php";
session_start();

$user_id = $_SESSION['id']; 

$total_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM project_manager WHERE id=$user_id");
$total = mysqli_fetch_assoc($total_query)['total'];

$completed_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM project_manager WHERE status='Completed' AND id=$user_id");
$completed = mysqli_fetch_assoc($completed_query)['total'];

$progress_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM project_manager WHERE status='In Progress' AND id=$user_id");
$progress = mysqli_fetch_assoc($progress_query)['total'];

$query = mysqli_query($koneksi, "SELECT * FROM project_manager WHERE id=$user_id ORDER BY id_project DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajer Proyek Belajar</title>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            background-image: url('bg3.gif'); /* Pastikan gambar ini ada */
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        /* --- STYLE SIDEBAR GLASSMORPHISM --- */
        
        /* Tombol Menu Hamburger */
        .menu-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            color: #55c0ea;
            border: 2px dashed #55c0ea;
            padding: 10px 15px;
            font-size: 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            z-index: 2000;
            transition: 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .menu-btn:hover {
            background-color: #55c0ea;
            color: white;
            border-style: solid;
        }

        /* Sidebar Container */
        .sidebar {
            height: 100%;
            width: 0; /* Awalnya tertutup */
            position: fixed;
            z-index: 2050;
            top: 0;
            left: 0;
            
            /* --- EFEK KACA (GLASSMORPHISM) --- */
            background-color: rgba(255, 255, 255, 0.45); /* Putih Transparan */
            backdrop-filter: blur(15px); /* Efek Blur */
            -webkit-backdrop-filter: blur(15px);
            border-right: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.1);
            /* -------------------------------- */

            overflow-x: hidden;
            transition: 0.4s;
            padding-top: 80px;
            white-space: nowrap;
        }

        .sidebar h2 {
            position: absolute;
            top: 25px;
            left: 30px;
            margin: 0;
            color: #007bff;
            font-weight: 600;
        }

        .sidebar a {
            padding: 15px 30px;
            text-decoration: none;
            font-size: 1.1rem;
            color: #333;
            display: block;
            transition: 0.3s;
            font-weight: 500;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.6);
            color: #55c0ea;
            padding-left: 40px; 
        }

        .sidebar .close-btn {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 2rem;
            color: #ff6b6b;
            background: none;
            border: none;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(0,0,0,0.3);
            z-index: 2040;
            backdrop-filter: blur(3px);
        }


        .main-content {
            padding: 40px 20px;
            padding-top: 80px; 
            max-width: 1000px;
            margin: 0 auto; 
        }

        .main-content h1 {
            color: #333;
            margin-bottom: 30px;
            text-shadow: 2px 2px 0px #fff;
        }

        /* Styles Cards */
        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 200px;
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(255, 105, 180, 0.15);
            border: 2px solid #fff;
        }

        .card h3 { 
            margin: 0 0 10px 0; 
            color: #55c0ea;
            font-size: 1.2rem;
        }

        .card p {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 600;
            color: #333;
        }

        /* Styles Table */
        .project-table {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 1);
        }

        .header-table {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        table th {
            background: #55c0ea;
            color: white;
            padding: 15px;
            text-align: left;
            border-radius: 10px 10px 0 0; /* Rounded atas */
        }
        
        table th:first-child { border-top-left-radius: 10px; }
        table th:last-child { border-top-right-radius: 10px; }

        table td {
            border-bottom: 1px dashed #ddd;
            padding: 15px;
            color: #555;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        /* Tombol Aksi */
        .btn-add {
            background: #55c0ea;
            color: white;
            padding: 12px 20px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(85, 192, 234, 0.3);
            transition: 0.3s;
        }
        .btn-add:hover { background: #4ab3dd; transform: translateY(-2px); }

        .btn-action {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: bold;
        }
        .btn-edit { background-color: #ffeaa7; color: #d35400; }
        .btn-del { background-color: #ff7675; color: white; margin-left: 5px; }

    </style>
</head>

<body>

    <button class="menu-btn" onclick="openNav()">
        <i class="bi bi-list"></i> Menu
    </button>

    <div id="overlay" onclick="closeNav()"></div>

    <div id="mySidebar" class="sidebar">
        <h2>Navigasi</h2>
        <button class="close-btn" onclick="closeNav()">&times;</button>
        
        <a href="dashboard.php"><i class="bi bi-kanban me-2"></i> Dashboard</a>
        <a href="tabletugas.php"><i class="bi bi-list-task me-2"></i> Tabel Tugas</a>
        <a href="calender.php"><i class="bi bi-calendar-event me-2"></i> Calendar</a>
        <a href="study_planner.php"><i class="bi bi-journal-text me-2"></i> Study Planner</a>
        <a href="todo.php"><i class="bi bi-check2-square me-2"></i> To Do List</a>
        <a href="media.php"><i class="bi bi-images me-2"></i> Media</a>

         
        <div style="border-top: 1px dashed rgba(0,0,0,0.1); margin: 10px 0;"></div>
        <a href="login.php" style="color:#ff6b6b;"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
    </div>
    
    </div>

    <div class="main-content">

        <h1>Manajer Proyek Belajar</h1>

        <div class="cards">
            <div class="card">
                <h3>Total Projects</h3>
                <p><?= $total ?></p>
            </div>

            <div class="card">
                <h3>Completed</h3>
                <p style="color: #00b894;"><?= $completed ?></p>
            </div>

            <div class="card">
                <h3>In Progress</h3>
                <p style="color: #fdcb6e;"><?= $progress ?></p>
            </div>
        </div>

        <div class="project-table">
            <div class="header-table">
                <h2 style="margin:0; color:#333;">Daftar Proyek</h2>
                <a class="btn-add" href="add_project.php"><i class="bi bi-plus-lg"></i> Tambah Proyek</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nama Proyek</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($query) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                            <td><?= htmlspecialchars($row['deadline']) ?></td>
                            <td>
                                <?php 
                                    $statusColor = ($row['status'] == 'Completed') ? '#00b894' : '#fdcb6e';
                                    $statusText = ($row['status'] == 'Completed') ? '#fff' : '#333';
                                ?>
                                <span style="background: <?= $statusColor ?>; color: <?= $statusText ?>; padding: 4px 10px; border-radius: 10px; font-size: 0.85rem;">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a class="btn-action btn-edit" href="edit_project.php?id=<?= $row['id_project'] ?>">Edit</a>
                                <a class="btn-action btn-del" href="delete_project.php?id=<?= $row['id_project'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center; color:gray; padding: 30px;">
                            <i class="bi bi-folder-x" style="font-size: 2rem; display:block; margin-bottom:10px;"></i>
                            Belum ada proyek. Yuk tambah baru!
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "280px";
            document.getElementById("overlay").style.display = "block";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("overlay").style.display = "none";
        }
    </script>

</body>
</html>
