<?php
// 1. HUBUNGKAN KE DATABASE
include 'koneksi.php';

// 2. AMBIL DATA USER UNTUK DROPDOWN
// Mengambil semua user (bisa ditambahkan WHERE level='user' jika perlu)
$query_users = mysqli_query($koneksi, "SELECT * FROM user ORDER BY nama ASC");

// 3. AMBIL STATISTIK PROJECT (Global)
// Menghitung total project
$total_project = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM project_manager"))['total'];
// Menghitung project selesai
$completed = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM project_manager WHERE status='Completed'"))['total'];
// Menghitung project berjalan
$in_progress = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM project_manager WHERE status='In Progress'"))['total'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Workspace (PHP)</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url('bg2.gif'); /* Pastikan file ini ada */
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            font-family: 'Fredoka', sans-serif;
        }

        /* --- STYLE SIDEBAR GLASSMORPHISM --- */
        .menu-btn {
            position: fixed; top: 20px; left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #212529; border: 2px dashed #212529;
            padding: 8px 15px; font-size: 1.1rem; border-radius: 10px;
            cursor: pointer; z-index: 2000; transition: 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .menu-btn:hover { background-color: #212529; color: white; border-style: solid; }

        .sidebar {
            height: 100%; width: 0; position: fixed; z-index: 2050; top: 0; left: 0;
            background-color: rgba(255, 255, 255, 0.6); backdrop-filter: blur(15px);
            border-right: 1px solid rgba(255, 255, 255, 0.8); overflow-x: hidden;
            transition: 0.4s; padding-top: 80px; white-space: nowrap;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            padding: 15px 25px; text-decoration: none; font-size: 1.1rem; color: #333;
            display: block; transition: 0.3s; font-weight: 600;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .sidebar a:hover { background-color: rgba(33, 37, 41, 0.1); padding-left: 35px; }
        .sidebar .close-btn {
            position: absolute; top: 15px; right: 20px; font-size: 2rem;
            color: #dc3545; background: none; border: none; cursor: pointer;
        }
        .sidebar-title {
            position: absolute; top: 25px; left: 25px; font-size: 1.5rem;
            font-weight: bold; color: #212529;
        }
        #overlay {
            position: fixed; display: none; width: 100%; height: 100%; top: 0; left: 0;
            background-color: rgba(0,0,0,0.4); z-index: 2040; backdrop-filter: blur(2px);
        }

        /* --- DASHBOARD CONTENT STYLE --- */
        .admin-card { 
            border: none; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.1); 
            border-radius: 12px; 
            background-color: rgba(255, 255, 255, 0.95);
        }
        .card-header { 
            background: #212529; color: white; text-align: center; 
            border-radius: 12px 12px 0 0 !important; padding: 20px; 
            letter-spacing: 2px; font-weight: bold; 
        }
        
        /* Style untuk Kartu Statistik Project */
        .stat-card {
            border: none; border-radius: 15px; transition: 0.3s; color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .bg-gradient-blue { background: linear-gradient(45deg, #4099ff, #73b4ff); }
        .bg-gradient-green { background: linear-gradient(45deg, #2ed8b6, #59e0c5); }
        .bg-gradient-orange { background: linear-gradient(45deg, #FFB64D, #ffcb80); }

        .list-group-item { border-left: none; border-right: none; padding: 15px 20px; transition: 0.3s; background: transparent; }
        .list-group-item:hover { background-color: rgba(0,0,0,0.05); transform: translateX(5px); }
        .btn-open { border-radius: 20px; padding: 5px 15px; }
        .container { padding-top: 80px; padding-bottom: 50px; }
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
        
        <a href="admin-db.php"><i class="bi bi-speedometer2 me-2"></i> Admin Dashboard</a>
        <div class="border-top my-2"></div>
        <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
    </div>

    <div class="container">
        
        <div class="row mb-4 justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="card stat-card bg-gradient-blue">
                    <div class="card-body">
                        <h5 class="card-title">Total Projects</h5>
                        <h2 class="mb-0 fw-bold"><i class="bi bi-folder2-open"></i> <?php echo $total_project; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card bg-gradient-green">
                    <div class="card-body">
                        <h5 class="card-title">Completed</h5>
                        <h2 class="mb-0 fw-bold"><i class="bi bi-check-circle"></i> <?php echo $completed; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card bg-gradient-orange">
                    <div class="card-body">
                        <h5 class="card-title">In Progress</h5>
                        <h2 class="mb-0 fw-bold"><i class="bi bi-hourglass-split"></i> <?php echo $in_progress; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card admin-card mx-auto" style="max-width: 600px;">
            <div class="card-header">
                <i class="bi bi-grid-1x2-fill me-2"></i> MANAGE CONTENT
            </div>
            <div class="card-body p-4">
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-muted small text-uppercase">Select User Account</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-person-circle"></i></span>
                        
                        <select class="form-select" id="userSelect">
                            <option value="" disabled selected>-- Pilih User dari Database --</option>
                            <?php 
                            // Loop data user dari database
                            while ($user = mysqli_fetch_array($query_users)) { 
                            ?>
                                <option value="<?php echo $user['id']; ?>" data-name="<?php echo $user['nama']; ?>">
                                    ID: <?php echo $user['id']; ?> - <?php echo $user['nama']; ?> (<?php echo $user['email']; ?>)
                                </option>
                            <?php } ?>
                        </select>
                        
                    </div>
                </div>

                <hr class="my-4 opacity-25">

                <h6 class="fw-bold mb-3 text-secondary small text-uppercase">User Pages Access</h6>
                
                <div class="list-group list-group-flush">
                    <?php 
                    $menus = [
                        ["name" => "To Do List", "icon" => "bi-check-circle-fill text-primary", "slug" => "todo"],
                        ["name" => "Calendar", "icon" => "bi-calendar-week-fill text-success", "slug" => "calendar"],
                        ["name" => "Study Planner", "icon" => "bi-journal-text text-info", "slug" => "study"],
                        ["name" => "Project Manager", "icon" => "bi-kanban-fill text-warning", "slug" => "project"],
                        ["name" => "Notes", "icon" => "bi-sticky-fill text-danger", "slug" => "notes"]
                    ];

                    foreach ($menus as $menu) : ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div><i class="bi <?php echo $menu['icon']; ?> me-2"></i> <?php echo $menu['name']; ?></div>
                            <button onclick="openPage('<?php echo $menu['slug']; ?>', '<?php echo $menu['name']; ?>')" class="btn btn-sm btn-outline-primary btn-open">Open</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-footer text-center text-muted small py-3">
                Admin Panel PHP v1.0
            </div>
        </div>
    </div>

    <script>
        // --- LOGIKA SIDEBAR ---
        function openNav() {
            document.getElementById("mySidebar").style.width = "280px";
            document.getElementById("overlay").style.display = "block";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("overlay").style.display = "none";
        }

        // --- LOGIKA HALAMAN ADMIN ---
        function openPage(pageSlug, pageName) {
            const userSelect = document.getElementById('userSelect');
            const userId = userSelect.value;
            
            // Mengambil Nama User dari attribute data-name agar URL lebih cantik (opsional)
            const selectedOption = userSelect.options[userSelect.selectedIndex];
            const userName = selectedOption.getAttribute('data-name');

            if (!userId) {
                alert("Harap pilih user dari dropdown terlebih dahulu!");
                return;
            }
            
            // Redirect dengan membawa ID USER (penting untuk query database selanjutnya)
            // Pastikan kamu punya file view_admin.php yang menangani $_GET['user_id']
            window.location.href = `view_admin.php?page=${pageSlug}&user_id=${userId}&user_name=${encodeURIComponent(userName)}`;
        }
    </script>
</body>
</html>