<?php

include "koneksi.php";

$reward = $_POST['reward'];

mysqli_query($koneksi, "INSERT INTO reward (`name`) VALUES ('$reward')");

header("Location: todo.php");
exit;
