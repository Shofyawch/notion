<?php
$conn = new mysqli("localhost", "root", "", "multi_user");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        echo "<script>alert('Password tidak sama!'); window.location='register.php';</script>";
        exit();
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$hash')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Register berhasil!'); window.location='login.php';</script>";
        exit();
    } 
    else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="login.css">

</head>
<body>
    <div class="wrapper">
        <form action="register.php" method="post">
            <h1><𝐑𝐄𝐆𝐈𝐒𝐓𝐄𝐑></h1>

            <div class="input-group">
                <label>Username</label>
                <div class="input-box">
                    <input type="text" name="nama" placeholder="Enter username" required>
                </div>
            </div>

            <div class="input-group">
                <label>Email</label>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Enter email" required>
                </div>
            </div>

            <div class="input-group">
                <label>Password</label>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>
            </div>

            <div class="input-group">
                <label>Confirm Password</label>
                <div class="input-box">
                    <input type="password" name="confirm_password" placeholder="Re-enter password" required>
                </div>
            </div>

            <div class="remember-forgot">
                <label>
                    <input type="checkbox"> I agree to the Terms & Conditions
                </label>
            </div>

            <button type="submit" class="btn">Register</button>

            <div class="register-link">
                <p>Already have an account?
                    <a href="http://localhost/notion%20github/notion/login.php">Login</a>
                </p>
            </div>

        </form>
    </div>
    <footer>
    <div id="player-container">
        
        <img id="cassette-animation" src="music.png" alt="Putar Musik">
        
        <audio id="audio-player" loop>
            <source src="Nandemonaiya - movie ver..mp3" type="audio/mpeg">
            Browser kamu tidak mendukung audio.
        </audio>
    </div>
    
    </footer>
    <script>
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

