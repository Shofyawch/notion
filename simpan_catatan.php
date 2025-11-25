<?php
// Pastikan file koneksi.php Anda sudah menggunakan $koneksi
include 'koneksi.php'; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $tanggal = $_POST['tanggal'] ?? ''; // Format: YYYY-MM-DD
    $catatan = $_POST['catatan'] ?? '';

    if (empty($tanggal) || empty($catatan)) {
        echo json_encode(["status" => "error", "message" => "Tanggal dan catatan tidak boleh kosong."]);
        exit;
    }

    // Query menggunakan ON DUPLICATE KEY UPDATE
    // Jika tanggal sudah ada (UNIQUE), catatan akan di-UPDATE. Jika belum ada, di-INSERT.
    $query = "INSERT INTO catatan_kalender (tanggal, catatan) 
              VALUES (?, ?)
              ON DUPLICATE KEY UPDATE catatan = VALUES(catatan)";

    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ss", $tanggal, $catatan);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "tanggal" => $tanggal]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan catatan: " . mysqli_error($koneksi)]);
    }
    
    mysqli_stmt_close($stmt);

} else {
    echo json_encode(["status" => "error", "message" => "Metode request tidak diizinkan."]);
}
?>