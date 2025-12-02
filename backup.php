<?php
include 'koneksi.php';

$tables = array("user", "notes", "project_manager", "media_upload");
$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\nSTART TRANSACTION;\nSET time_zone = \"+00:00\";\n\n";

foreach ($tables as $table) {
    // 1. Menggunakan $koneksi untuk query CREATE TABLE
    $result = mysqli_query($koneksi, "SHOW CREATE TABLE $table");
    $row = mysqli_fetch_row($result);
    $content .= "\n\n" . $row[1] . ";\n\n";

    // 2. Menggunakan $koneksi untuk query SELECT data
    $result = mysqli_query($koneksi, "SELECT * FROM $table");
    $num_fields = mysqli_num_fields($result);

    while ($row = mysqli_fetch_row($result)) {
        $content .= "INSERT INTO $table VALUES(";
        for ($j = 0; $j < $num_fields; $j++) {
            $row[$j] = addslashes($row[$j]);
            $row[$j] = str_replace("\n", "\\n", $row[$j]);
            if (isset($row[$j])) {
                $content .= '"' . $row[$j] . '"';
            } else {
                $content .= '""';
            }
            if ($j < ($num_fields - 1)) {
                $content .= ',';
            }
        }
        $content .= ");\n";
    }
}
$content .= "\nCOMMIT;";

$filename = 'db_backup_' . date("Y-m-d_H-i-s") . '.sql';
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . $filename . "\"");
echo $content;
exit;
?>