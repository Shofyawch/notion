<?php
include 'koneksi.php';

$filename = "data_progress_user_" . date('Ymd') . ".csv";

header("Content-Description: File Transfer"); 
header("Content-Disposition: attachment; filename=$filename"); 
header("Content-Type: application/csv; ");

$file = fopen('php://output', 'w');

$header = array("ID User", "Nama User", "Email", "Note (Catatan)", "Tanggal Note", "Project Status", "Deadline Project", "File Media Upload"); 
fputcsv($file, $header);

$query = "SELECT 
            u.id, 
            u.nama, 
            u.email, 
            n.note, 
            n.created_at as note_date,
            p.status as project_status,
            p.deadline,
            m.filename as media_file
          FROM user u
          LEFT JOIN notes n ON u.id = n.id
          LEFT JOIN project_manager p ON u.id = p.id
          LEFT JOIN media_upload m ON u.id = m.id_user
          ORDER BY u.id ASC";

$result = mysqli_query($koneksi, $query);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($file, array(
        $row['id'],
        $row['nama'],
        $row['email'],
        $row['note'] ? $row['note'] : '-',
        $row['note_date'] ? $row['note_date'] : '-',
        $row['project_status'] ? $row['project_status'] : '-',
        $row['deadline'] ? $row['deadline'] : '-',
        $row['media_file'] ? $row['media_file'] : '-'
    ));
}

fclose($file);
exit;
?>