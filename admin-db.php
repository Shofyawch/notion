<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Database Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url('bg2.gif'); /* Pastikan file ini ada */
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font default body */
        }

        /* --- STYLE SIDEBAR GLASSMORPHISM --- */
        
        /* Tombol Menu */
        .menu-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #0d6efd; /* Bootstrap Primary Color */
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
            z-index: 2050; /* Di atas segalanya (Bootstrap modal biasanya 1055) */
            top: 0;
            left: 0;
            background-color: rgba(255, 255, 255, 0.6); /* Transparan */
            backdrop-filter: blur(15px); /* Blur effect */
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
            color: #dc3545; /* Bootstrap Danger Color */
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

        .admin-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.95); /* Sedikit transparan agar menyatu dengan BG */
        }
        .table-icon {
            font-size: 1.2rem;
            margin-right: 10px;
            color: #6c757d;
        }
        
        /* Padding container agar tidak ketutup tombol menu di mobile */
        .container {
            padding-top: 60px;
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
        
        <a href="admin.php"><i class="bi bi-speedometer2 me-2"></i> Admin Manage Content</a>
       
        <div class="border-top my-2"></div>
        <a href="#" class="text-danger"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <h2 class="mb-4 text-center text-dark fw-bold" style="text-shadow: 2px 2px 4px rgba(255,255,255,0.8);">
                    <i class="bi bi-shield-lock-fill text-primary"></i> Admin Dashboard
                </h2>

                <div class="card admin-card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-database-fill-gear me-2"></i> DATABASE MANAGEMENT</h5>
                        <span class="badge bg-success bg-opacity-75">Status: Connected</span>
                    </div>
                    
                    <div class="card-body">
                        
                        <div class="row g-2 mb-4">
                            <div class="col-md-4">
                                <button class="btn btn-primary w-100" onclick="alert('Memulai Backup Database...')">
                                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Backup Database
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-warning w-100 text-dark" data-bs-toggle="modal" data-bs-target="#restoreModal">
                                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Restore Database
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success w-100">
                                    <i class="bi bi-filetype-csv me-1"></i> Export CSV
                                </button>
                            </div>
                        </div>

                        <hr>

                        <h6 class="text-muted text-uppercase mb-3 fw-bold small">Daftar Tabel Database</h6>
                        
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-people-fill table-icon"></i>
                                    <span class="fw-medium">users</span>
                                    <span class="text-muted small ms-2">(Data Pengguna)</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    Open <i class="bi bi-box-arrow-up-right ms-1"></i>
                                </a>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-journal-text table-icon"></i>
                                    <span class="fw-medium">notes</span>
                                    <span class="text-muted small ms-2">(Catatan)</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    Open <i class="bi bi-box-arrow-up-right ms-1"></i>
                                </a>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-briefcase-fill table-icon"></i>
                                    <span class="fw-medium">projects</span>
                                    <span class="text-muted small ms-2">(Proyek)</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    Open <i class="bi bi-box-arrow-up-right ms-1"></i>
                                </a>
                            </div>

                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-images table-icon"></i>
                                    <span class="fw-medium">media</span>
                                    <span class="text-muted small ms-2">(File & Gambar)</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    Open <i class="bi bi-box-arrow-up-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="restoreModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restore Database</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Pilih file SQL atau Backup untuk dikembalikan.</p>
                    <input type="file" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Proses Restore</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
    </script>
</body>
</html>