<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

if (!empty($_FILES['images']['name'][0])) {

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    foreach ($_FILES['images']['name'] as $key => $name) {

        $tmp = $_FILES['images']['tmp_name'][$key];

        $filename = $name;

        $newName = time() . "_" . rand(1000, 9999) . "_" . $name;
        $path = "uploads/" . $newName;

        if (move_uploaded_file($tmp, $path)) {

            $query = "
                INSERT INTO media_upload (id_user, filename, filepath)
                VALUES ('$id_user', '$filename', '$path')
            ";

            if (!mysqli_query($koneksi, $query)) {
                echo "SQL ERROR: " . mysqli_error($koneksi);
                exit;
            }

        }
    }

    header("Location: media.php?uploaded=1");
    exit;
} else {
    echo "Tidak ada file yang diupload!";
}
