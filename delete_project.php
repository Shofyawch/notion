<?php
include "koneksi.php";

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM project_manager WHERE id_project=$id");

header("Location: projectmanager.php");
?>
