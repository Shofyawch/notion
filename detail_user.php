<?php
include 'koneksi.php';

// Cek ID User
if (!isset($_GET['id'])) {
    header("Location: admin-db.php");
    exit;
}

$id_user = (int)$_GET['id']; // Casting ke int untuk keamanan dasar

// 1. Ambil Data User
$q_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id_user'");
$d_user = mysqli_fetch_assoc($q_user);

// Jika user tidak ditemukan
if (!$d_user) {
    echo "User tidak ditemukan.";
    exit;
}

// 2. Query ke 5 Tabel Konten
// Perhatikan nama kolom FK yang berbeda-beda sesuai database Anda:
// Todo -> kolom `id`
// ... kode atas tetap sama ...

// 2. Query ke 5 Tabel Konten
// Kita asumsikan nama kolom penghubung di semua tabel adalah 'id'
// (Sesuai dengan pola tabel todo, notes, dan project_manager kamu)

$q_todo    = mysqli_query($koneksi, "SELECT * FROM todo WHERE id = '$id_user'");
$q_notes   = mysqli_query($koneksi, "SELECT * FROM notes WHERE id = '$id_user'");
$q_project = mysqli_query($koneksi, "SELECT * FROM project_manager WHERE id = '$id_user'");

// PERBAIKAN DI SINI: Mengubah 'id_user' menjadi 'id' atau 'id_user' sesuai database asli
// Coba gunakan 'id' dulu, jika tabel studyplanner kamu pakai 'id'
$q_study   = mysqli_query($koneksi, "SELECT * FROM studyplanner WHERE id_user = '$id_user'"); 
// JIKA MASIH ERROR: Ganti 'id' menjadi 'id_user' pada baris di atas ^

// KHUSUS EVENT/CALENDAR
// Pastikan kamu sudah menjalankan SQL ALTER TABLE untuk menambah kolom id/id_user di tabel events
// Jika di database kolomnya 'id_user', pakai 'id_user'. Jika 'id', pakai 'id'.
$q_event = mysqli_query($koneksi, "SELECT * FROM events WHERE id_user = '$id_user' ORDER BY event_date ASC");

// Debugging: Cek jika query gagal
if (!$q_study) { echo "Error Study Planner: " . mysqli_error($koneksi); }
if (!$q_event) { echo "Error Events: " . mysqli_error($koneksi); }

// ... lanjut ke HTML ...
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail User: <?= $d_user['nama']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-content { height: 100%; }
        .scrollable-card { max-height: 300px; overflow-y: auto; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <a href="admin.php" class="btn btn-secondary mb-3">&larr; Kembali ke Dashboard</a>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-body">
                    <h2 class="text-primary">Monitoring User: <?= htmlspecialchars($d_user['nama']); ?></h2>
                    <p class="mb-0">Email: <?= htmlspecialchars($d_user['email']); ?> | ID: <?= $d_user['id']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card card-content shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="m-0">📝 To Do List</h5>
                </div>
                <div class="card-body scrollable-card">
                    <ul class="list-group">
                        <?php if(mysqli_num_rows($q_todo) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($q_todo)): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($row['isi_todo']); ?>
                                    <span class="badge bg-<?= $row['status'] == 1 ? 'success' : 'secondary'; ?>">
                                        <?= $row['status'] == 1 ? 'Selesai' : 'Pending'; ?>
                                    </span>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted">Belum ada to do list.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-content shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="m-0">📒 Notes</h5>
                </div>
                <div class="card-body scrollable-card">
                    <?php if(mysqli_num_rows($q_notes) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($q_notes)): ?>
                            <div class="alert alert-light border mb-2">
                                <small class="text-muted d-block"><?= $row['created_at']; ?></small>
                                <strong><?= nl2br(htmlspecialchars($row['note'])); ?></strong>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted">Belum ada catatan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-content shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="m-0">📅 Calendar Events</h5>
                </div>
                <div class="card-body scrollable-card">
                    <table class="table table-sm">
                        <thead><tr><th>Tanggal</th><th>Event</th></tr></thead>
                        <tbody>
                            <?php if(mysqli_num_rows($q_event) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($q_event)): ?>
                                    <tr>
                                        <td><?= $row['event_date']; ?></td>
                                        <td><?= htmlspecialchars($row['note']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="2" class="text-muted">Tidak ada event.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-content shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="m-0">🎓 Study Planner</h5>
                </div>
                <div class="card-body scrollable-card">
                    <table class="table table-striped">
                        <thead><tr><th>Waktu</th><th>Aktivitas</th></tr></thead>
                        <tbody>
                            <?php if(mysqli_num_rows($q_study) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($q_study)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['time_range']); ?></td>
                                        <td><?= htmlspecialchars($row['activity']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="2" class="text-muted">Jadwal belajar kosong.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-content shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="m-0">🚀 Project Manager</h5>
                </div>
                <div class="card-body scrollable-card">
                    <table class="table table-bordered">
                        <thead><tr><th>Nama Project</th><th>Status</th><th>Deadline</th></tr></thead>
                        <tbody>
                            <?php if(mysqli_num_rows($q_project) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($q_project)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['name']); ?></td>
                                        <td>
                                            <span class="badge bg-<?= ($row['status'] == 'Completed') ? 'success' : 'primary'; ?>">
                                                <?= $row['status']; ?>
                                            </span>
                                        </td>
                                        <td><?= $row['deadline']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="text-muted">Belum ada project.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>