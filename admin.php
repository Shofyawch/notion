<?php
session_start();
include 'koneksi.php';

// Cek sesi login admin (Opsional, aktifkan jika sudah ada sistem login)
// if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }

// Menggunakan $koneksi untuk mengambil data user
$query_users = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Database Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            background-image: url('bg2.gif'); /* Pastikan file ini ada, atau ganti warna */
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        /* --- STYLE SIDEBAR GLASSMORPHISM --- */
        
        /* Tombol Menu */
        .menu-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #0d6efd; /* Bootstrap Primary Blue */
            border: 2px dashed #0d6efd;
            padding: 8px 15px;
            font-size: 1.1rem;
            border-radius: 10px;
            cursor: pointer;
            z-index: 2000;
            transition: 0.3s;
            font-family: 'Fredoka', sans-serif;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-decoration: none;
            display: inline-block;
        }

        .menu-btn:hover {
            background-color: #0d6efd;
            color: white;
            border-style: solid;
        }

        /* Sidebar Container */
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 2050;
            top: 0;
            left: 0;
            background-color: rgba(255, 255, 255, 0.65); /* Transparan */
            backdrop-filter: blur(15px); /* Efek Blur */
            -webkit-backdrop-filter: blur(15px);
            border-right: 1px solid rgba(255, 255, 255, 0.8);
            overflow-x: hidden;
            transition: 0.4s;
            padding-top: 80px;
            white-space: nowrap;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        }

        /* Link Sidebar */
        .sidebar a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 1.1rem;
            color: #333;
            display: block;
            transition: 0.3s;
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .sidebar a:hover {
            background-color: rgba(13, 110, 253, 0.1); /* Biru muda transparan */
            color: #0d6efd;
            padding-left: 35px;
        }

        /* Close Button */
        .sidebar .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 2rem;
            color: #dc3545;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Judul Sidebar */
        .sidebar-title {
            position: absolute;
            top: 25px;
            left: 25px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
            font-family: 'Fredoka', sans-serif;
        }

        /* Overlay */
        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(0,0,0,0.4);
            z-index: 2040;
            backdrop-filter: blur(2px);
        }
        /* --- END SIDEBAR STYLE --- */

        .card-custom { 
            margin-bottom: 20px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            background-color: rgba(255, 255, 255, 0.95); /* Sedikit transparan */
        }
        
        /* Container padding agar tidak ketutup tombol menu */
        .container-custom {
            padding-top: 80px;
            padding-bottom: 50px;
        }
    </style>
</head>
<body>

    <button class="menu-btn" onclick="openNav()">
        <i class="bi bi-list"></i> Menu
    </button>

    <div id="overlay" onclick="closeNav()"></div>

    <div id="mySidebar" class="sidebar">
        <div class="sidebar-title">Admin Panel</div>
        <button class="close-btn" onclick="closeNav()">&times;</button>
        
        <a href="admin-db.php"><i class="bi bi-speedometer2 me-2"></i> Admin Panel Monitoring</a>
        <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
    </div>

    <div class="container container-custom">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold text-primary" style="text-shadow: 2px 2px 0px #fff;">Admin Database Management</h2>
                <p class="text-muted" style="background: rgba(255,255,255,0.8); display:inline-block; padding: 2px 10px; border-radius: 10px;">
                    Backup, Restore, dan Export Data User
                </p>
            </div>
        </div>

        <?php if(isset($_SESSION['pesan'])): ?>
            <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                <?php echo $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-custom border-primary">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-cloud-download me-2"></i> Backup Database
                    </div>
                    <div class="card-body">
                        <p class="card-text">Download seluruh data (User, Notes, Project, Media) dalam format SQL.</p>
                        <a href="backup.php" class="btn btn-primary w-100">Download Backup (.sql)</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom border-warning">
                    <div class="card-header bg-warning text-dark">
                        <i class="bi bi-cloud-upload me-2"></i> Restore Database
                    </div>
                    <div class="card-body">
                        <p class="card-text">Upload file SQL untuk mengembalikan data yang hilang.</p>
                        <form action="restore.php" method="post" enctype="multipart/form-data">
                            <div class="mb-2">
                                <input class="form-control" type="file" name="file_sql" required accept=".sql">
                            </div>
                            <button type="submit" name="restore" class="btn btn-warning w-100">Restore Data</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom border-success">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-filetype-csv me-2"></i> Export ke CSV
                    </div>
                    <div class="card-body">
                        <p class="card-text">Export laporan progress user (gabungan Notes, Project, Media).</p>
                        <a href="export_csv.php" class="btn btn-success w-100">Export Progress User (.csv)</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 shadow card-custom">
            <div class="card-header fw-bold">
                <i class="bi bi-people-fill me-2"></i> Data User Saat Ini
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query_users) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($query_users)): ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= htmlspecialchars($row['nama']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= $row['level']; ?></span>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data user.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js