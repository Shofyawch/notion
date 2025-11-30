<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Database Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
          background-image: url('bg2.gif');
            background-size: cover;
            background-attachment: fixed;
        }
        .admin-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .table-icon {
            font-size: 1.2rem;
            margin-right: 10px;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <h2 class="mb-4 text-center text-dark fw-bold">
                    <i class="bi bi-shield-lock-fill text-primary"></i> Admin Dashboard
                </h2>

                <div class="card admin-card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-database-fill-gear me-2"></i> DATABASE MANAGEMENT</h5>
                        <span class="badge bg-secondary">Status: Connected</span>
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
</body>
</html>