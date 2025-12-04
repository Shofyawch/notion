<?php
include 'koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);

$date = $data['date'];
$note = $data['note'];

if (!empty($note)) {
    $stmt = $koneksi->prepare("INSERT INTO events (event_date, note) VALUES (?, ?) ON DUPLICATE KEY UPDATE note = ?");
    $stmt->bind_param("sss", $date, $note, $note);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    $stmt->close();
} else {
    $stmt = $koneksi->prepare("DELETE FROM events WHERE event_date = ?");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    echo json_encode(["status" => "deleted"]);
}

$koneksi->close();
?>