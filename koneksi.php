<?php
$koneksi = mysqli_connect("localhost", "root", "", "multi_user");

<<<<<<< Updated upstream
//Check Connection
if(mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
=======
// check connection
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}   

?>
>>>>>>> Stashed changes
