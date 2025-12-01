<?php
// include 'db.php'; // Aktifkan ini nanti jika database sudah siap

// --- SIMULASI DATA USER DARI DATABASE ---
// Nanti ganti bagian ini dengan: $result = mysqli_query($conn, "SELECT * FROM users");
include "koneksi.php";
$users = mysqli_query($koneksi, "SELECT id, username FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Workspace (PHP)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
         body {
    
            background-image: url('bg2.gif');
            background-size: cover;
            background-attachment: fixed;
        }
        .admin-card { max-width: 600px; margin: 60px auto; border: none; box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-radius: 12px; }
        .card-header { background: #212529; color: white; text-align: center; border-radius: 12px 12px 0 0 !important; padding: 20px; letter-spacing: 2px; font-weight: bold; }
        .list-group-item { border-left: none; border-right: none; padding: 15px 20px; transition: 0.3s; }
        .list-group-item:hover { background-color: #f1f3f5; transform: translateX(5px); }
        .btn-open { border-radius: 20px; padding: 5px 15px; }

        
    </style>
</head>
<body>

    <div class="container">
        <div class="card admin-card">
            <div class="card-header">
                <i class="bi bi-grid-1x2-fill me-2"></i> MANAGE CONTENT
            </div>
            <div class="card-body p-4">
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-muted small text-uppercase">Select User</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-person-circle"></i></span>
                        
                        <select class="form-select" id="userSelect">
                            <option value="" disabled selected>-- Pilih User --</option>
                            <?php while ($u = mysqli_fetch_assoc($users)) : ?>
    <option value="<?php echo $u['id']; ?>">
        User <?php echo $u['id']; ?> - <?php echo $u['username']; ?>
    </option>
<?php endwhile; ?>

                        </select>
                        
                    </div>
                </div}
                <hr class="my-4 opacity-25">

                <h6 class="fw-bold mb-3 text-secondary small text-uppercase">User Pages Access</h6>
                
                <div class="list-group list-group-flush">
                    <?php 
                    // Array menu agar kodenya lebih rapi
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
        function openPage(pageSlug, pageName) {
            const userSelect = document.getElementById('userSelect');
            const userName = userSelect.value;

            if (!userName) {
                alert("Harap pilih user terlebih dahulu!");
                return;
            }
            
            // Redirect ke halaman view_admin.php dengan membawa parameter PHP
            // page: jenis halaman (todo, calendar, dll)
            // user: nama user
            window.location.href = `view_admin.php?page=${pageSlug}&title=${encodeURIComponent(pageName)}&user=${encodeURIComponent(userName)}`;
        }
    </script>
</body>
</html>