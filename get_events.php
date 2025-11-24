<?php
include 'koneksi.php';

$sql = "SELECT event_date, note FROM events";
// Menggunakan $koneksi->query
$result = $koneksi->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[$row['event_date']] = $row['note'];
    }
}

echo json_encode($events);

// Tutup koneksi
$koneksi->close();
?>