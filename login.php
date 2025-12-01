<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

<<<<<<< Updated upstream
<<<<<<< HEAD
    // ambil user berdasarkan username
=======
    // INI UDA PAS YAH, JANGAN DIGANTI
>>>>>>> c93ba09ea274471e04578cbff9dd707ae9763e81
    $query = "SELECT * FROM user WHERE nama='$username'";
=======
    $query = "SELECT * FROM user WHERE username='$username'";
>>>>>>> Stashed changes
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

<<<<<<< HEAD
    // cek password
    if ($row && password_verify($password, $row['password'])) {

        // simpan session
        $_SESSION['id'] = $row['id'];
<<<<<<< Updated upstream
        $_SESSION['level'] = $row['level']; // ← PENTING!
        $_SESSION['nama'] = $row['nama'];
=======
    // Cek password
    if ($row && password_verify($password, $row['password'])) {

        // Simpan session
        $_SESSION['id'] = $row['id'];
        $_SESSION['level'] = $row['level']; 
        $_SESSION['nama'] = $row['nama'];

        // Redirect sesuai level
        if ($row['level'] === 'admin') {
            header("Location: da.php");      // halaman admin
        } else {
            header("Location: dahsboard.php"); // halaman user
        }
        exit;
>>>>>>> c93ba09ea274471e04578cbff9dd707ae9763e81

        // redirect sesuai level
        if ($row['level'] === 'admin') {
            header("Location: da.php");
        } else {
            header("Location: dashboard.php");
        }
=======
        header("Location: dahsboard.php");
>>>>>>> Stashed changes
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
} 
?>

<<<<<<< Updated upstream


<<<<<<< HEAD
=======

>>>>>>> c93ba09ea274471e04578cbff9dd707ae9763e81
=======
 
>>>>>>> Stashed changes
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEstingg</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <video autoplay loop muted playsinline id="bg-video">
        <source src="fish.mp4" type="video/mp4">
        <img src="fish.png">

    </video>

</head>

<body>
    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .spinning {
            animation: spin 2s linear infinite;
        }
    </style>

    <body>

        <div class="wrapper">
            <form action="login.php" method="POST">
                <h1>
<<<<<<< Updated upstream
                    <𝗟𝗢𝗚𝗜𝗡>
=======
                    <TE>
>>>>>>> Stashed changes
                </h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <!-- Popup Reset Password -->
                <div id="popup" class="popup">
                    <div class="popup-content">
                        <span id="closePopup" class="close">&times;</span>
                        <h3>Reset Password</h3>
                        <p>Masukkan email Anda untuk menerima link reset password:</p>
                        <br>
                        <input type="email" id="emailInput" placeholder="Masukkan email">
                        <button type="button" id="sendEmail" class="btn">Kirim</button>
                        <p id="successMsg"></p>
                    </div>
                </div>

                <div class="remember-forgot">
                    <label>
                        <input type="checkbox"> Remember me </label>
                    <span id="forgotPassword">Forgot Password?</span>
                    </label>
                </div>

                <button type="submit" name="login" class="btn">Login</button>

                <div class="register-link">
                    <p>Don't have an account?
                        <a href="http://localhost/notion%20github/notion/register.php">Register</a>
                    </p>
                </div>
            </form>
        </div>
        <footer>
            <div id="player-container">

                <img id="cassette-animation" src="music.png" alt="Putar Musik">

                <audio id="audio-player" loop>
                    <source src="Dream lantern.mp3" type="audio/mpeg">
                    Browser kamu tidak mendukung audio.
                </audio>
            </div>
        </footer>

        <script>
            const forgotPassword = document.getElementById("forgotPassword");
            const popup = document.getElementById("popup");
            const closePopup = document.getElementById("closePopup");

            // Klik forgot → buka popup
            forgotPassword.onclick = function() {
                popup.style.display = "flex";
                document.getElementById("successMsg").innerHTML = "";
                document.getElementById("emailInput").value = "";
            };

            // Klik X → tutup popup
            closePopup.onclick = function() {
                popup.style.display = "none";
            };

            // Klik luar popup → tutup
            window.onclick = function(event) {
                if (event.target == popup) {
                    popup.style.display = "none";
                }
            };

            document.getElementById("sendEmail").onclick = function() {
                let email = document.getElementById("emailInput").value;

                if (email.trim() === "") {
                    alert("Email tidak boleh kosong!");
                    return;
                }

                if (!email.includes("@") || !email.includes(".")) {
                    alert("Format email tidak valid!");
                    return;
                }

                document.getElementById("successMsg").innerHTML =
                    "📩 Link reset password telah dikirim ke " + email;
            };


            //buat audio musik
            document.addEventListener("DOMContentLoaded", function() {
                const audioPlayer = document.getElementById('audio-player');
                const cassetteImg = document.getElementById('cassette-animation');

                cassetteImg.addEventListener('click', () => {

                    if (audioPlayer.paused) {
                        audioPlayer.play();
                    } else {
                        audioPlayer.pause();
                    }
                });

                audioPlayer.addEventListener('play', () => {
                    cassetteImg.classList.add('spinning');
                });


                audioPlayer.addEventListener('pause', () => {
                    cassetteImg.classList.remove('spinning');
                });


                audioPlayer.addEventListener('ended', () => {
                    cassetteImg.classList.remove('spinning');
                });
            });
        </script>
    </body>

</html>