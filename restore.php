<?php
session_start();
include 'koneksi.php';

if (isset($_POST['restore'])) {
    
    if ($_FILES['file_sql']['error'] == 0) {
        $filename = $_FILES['file_sql']['tmp_name'];
        $handle = fopen($filename, "r+");
        $contents = fread($handle, filesize($filename));
        
        $sql = explode(';', $contents);
        
        mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS = 0");

        $sukses = 0;
        $gagal = 0;

        foreach ($sql as $query) {
            $query = trim($query);
            if (!empty($query)) {
                if (mysqli_query($koneksi, $query)) {
                    $sukses++;
                } else {
                    $gagal++;
                }
            }
        }

        mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS = 1");
        fclose($handle);

        $_SESSION['pesan'] = "Restore Berhasil! Query sukses: $sukses, Gagal: $gagal";
    } else {
        $_SESSION['pesan'] = "Gagal mengupload file.";
    }
}

header("Location: admin.php");
?>