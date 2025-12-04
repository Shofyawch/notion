<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'error';
$user = isset($_GET['user']) ? $_GET['user'] : 'Guest';
$title = isset($_GET['title']) ? $_GET['title'] : 'Content';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View - <?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-database-fill me-2"></i>Admin Mode (PHP)</a>
            <div class="d-flex">
                <a href="admin.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Back</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="alert alert-info d-flex align-items-center mb-4 shadow-sm">
            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
            <div>
                User: <strong><?php echo htmlspecialchars($user); ?></strong> | Page: <strong><?php echo htmlspecialchars($title); ?></strong>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"><?php echo htmlspecialchars($title); ?></h2>
            <button class="btn btn-primary"><i class="bi bi-pencil-square"></i> Edit Data</button>
        </div>

        <div class="card shadow-sm border-0">
            
            <?php switch ($page): 
                
                case 'todo': ?>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="table-light"><tr><th>Task</th><th>Deadline</th><th>Status</th></tr></thead>
                            <tbody>
                                <tr><td>Laporan PHP (<?php echo $user; ?>)</td><td>Besok</td><td><span class="badge bg-warning">Pending</span></td></tr>
                                <tr><td>Koneksi Database</td><td>Lusa</td><td><span class="badge bg-danger">Not Started</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                <?php break; ?>

                
                <?php 
                case 'calendar': ?>
                    <div class="card-body text-center py-5">
                        <i class="bi bi-calendar3 display-1 text-success mb-3"></i>
                        <h4>Kalender Milik <?php echo $user; ?></h4>
                        <p>Menampilkan jadwal dari database...</p>
                    </div>
                <?php break; ?>


                <?php 
                case 'study': ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card bg-primary text-white p-3">
                                    <h5>Backend Dev</h5>
                                    <p>Progress <?php echo $user; ?></p>
                                    <div class="progress mt-2" style="height: 5px;"><div class="progress-bar bg-white" style="width: 45%"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php break; ?>


                <?php 
                case 'project': ?>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4 border-end"><h5 class="text-secondary">To Do</h5><div class="card p-2 bg-light">Project A</div></div>
                            <div class="col-4 border-end"><h5 class="text-primary">In Progress</h5><div class="card p-2 border-primary">Project B</div></div>
                            <div class="col-4"><h5 class="text-success">Done</h5><div class="card p-2 border-success">Project C</div></div>
                        </div>
                    </div>
                <?php break; ?>


                <?php 
                case 'notes': ?>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">
                                <h5 class="mb-1">Catatan Penting</h5>
                                <p class="mb-1">Ini adalah catatan manual milik <?php echo $user; ?>.</p>
                            </a>
                        </div>
                    </div>
                <?php break; ?>


                <?php 
                default: ?>
                    <div class="card-body text-center text-danger py-5">
                        <h3><i class="bi bi-exclamation-triangle"></i></h3>
                        <p>Halaman tidak ditemukan atau parameter salah.</p>
                    </div>
                <?php break; ?>

            <?php endswitch; ?>

        </div>
    </div>

</body>
</html>