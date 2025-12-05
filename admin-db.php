<?php
include 'koneksi.php';

$query = "SELECT * FROM user ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Daftar User</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            background-image: url('bg2.gif'); 
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        .menu-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #0d6efd; 
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
            background-color: rgba(13, 110, 253, 0.1); 
            color: #0d6efd;
            padding-left: 35px;
        }

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

        .sidebar-title {
            position: absolute;
            top: 25px;
            left: 25px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
            font-family: 'Fredoka', sans-serif;
        }

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

        .container-custom {
            padding-top: 80px; 
            padding-bottom: 50px;
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
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
        
        <a href="admin.php"><i class="bi bi-database-down me-2"></i> Database Management</a>
        <a href="login.php" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
    </div>

    <div class="container container-custom">
        <div class="card card-custom shadow">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="border-radius: 15px 15px 0 0;">
                <h4 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-person-lines-fill me-2"></i>Daftar Akun User
                </h4>
                <span class="badge bg-primary rounded-pill">Total: <?= mysqli_num_rows($result); ?> User</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-center"><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['nama']); ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($row['username']); ?></span></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td class="text-center">
                                    <a href="detail_user.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye-fill me-1"></i> Lihat Konten
                                    </a>
                                    </td>
                            </tr>
                            <?php endwhile; ?>
                            
                            <?php if(mysqli_num_rows($result) == 0): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada data user ditemukan.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
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