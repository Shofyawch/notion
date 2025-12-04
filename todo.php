<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["id"])) {
    echo "Kamu belum login!";
    exit;
}

$id_user = $_SESSION["id"];

// READ DATA TO-DO USER
$todo = mysqli_query($koneksi, "SELECT * FROM todo WHERE id='$id_user' ORDER BY id_todo DESC");

// AMBIL DATA EDIT
$editData = null;

if (isset($_GET["edit"])) {
    $id_edit = $_GET["edit"];
    $editQuery = mysqli_query($koneksi, "SELECT * FROM todo WHERE id_todo='$id_edit'");
    $editData = mysqli_fetch_assoc($editQuery);
}

// UPDATE
if (isset($_POST["update"])) {
    $id_edit = $_POST["id_edit"];
    $isi_baru = $_POST["isi_baru"];

    // Menggunakan prepared statement (lebih aman)
    $stmt = $koneksi->prepare("UPDATE todo SET isi_todo=? WHERE id_todo=?");
    $stmt->bind_param("si", $isi_baru, $id_edit);
    $stmt->execute();
    
    header("Location: todo.php");
    exit;
}

// DELETE
if (isset($_GET["hapus"])) {
    $hapus_id = $_GET["hapus"];
    // Menggunakan prepared statement
    $stmt = $koneksi->prepare("DELETE FROM todo WHERE id_todo=?");
    $stmt->bind_param("i", $hapus_id);
    $stmt->execute();
    
    header("Location: todo.php");
    exit;
}

// CHECK / UNCHECK
if (isset($_GET["cek"])) {
    $cek_id = $_GET["cek"];

    // Update status menggunakan IF untuk toggle (MySQL function)
    $stmt = $koneksi->prepare("UPDATE todo SET status = IF(status=1, 0, 1) WHERE id_todo=?");
    $stmt->bind_param("i", $cek_id);
    $stmt->execute();
    
    header("Location: todo.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cute To-Do List</title>

<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
/* Reset dan Font Utama */
body {
    font-family: 'Fredoka', sans-serif; /* Mengganti Arial dengan Fredoka */
    background: url('lautb.gif') no-repeat center center;
    background-size: cover; 
    background-attachment: fixed;
    margin: 0;
    padding: 0;
    color: #5a5a4d;
}

.container {
    max-width: 750px;
    margin: 40px auto;
    background: #e0f0ff;
    border: 2px solid #e6e6d8;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

h2 {
    color: #8fa873;
    margin-bottom: 8px;
    font-weight: 600;
}

.section-box {
    border: 1.5px solid #dfdfcf;
    border-radius: 12px;
    padding: 20px;
    margin-top: 25px;
    background: #fcfcf7;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
}

.todo-item {
    display: flex;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px dashed #eee;
}

.todo-item:last-child {
    border-bottom: none;
}

.todo-item input[type="checkbox"] {
    width: 20px;
    height: 20px;
    margin-right: 15px;
    accent-color: #8fa873; /* Warna checklist */
    cursor: pointer;
}

.todo-item label {
    flex-grow: 1;
    transition: 0.3s;
}

.todo-item input[type="checkbox"]:checked + label {
    text-decoration: line-through;
    color: #a0a0a0;
}

.header-cute {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-cute img {
    width: 80px;
    height: 80px;
    border-radius: 50%; /* Membuat gambar bundar */
    object-fit: cover;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

button.add-btn, .add-btn[type="button"] {
    margin-top: 10px;
    padding: 8px 15px;
    border: none;
    border-radius: 10px;
    background: #8fa873;
    color: white;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

.add-btn:hover {
    background: #72875b;
}

input.add-input {
    width: calc(100% - 120px);
    padding: 8px 10px;
    border-radius: 8px;
    border: 1px solid #8fa873;
    margin-right: 5px;
    box-sizing: border-box;
}

/* --- SIDEBAR STYLE (GLASSMORPHISM) --- */

/* Tombol Menu Hamburger */
.menu-btn {
    position: fixed;
    top: 20px;
    left: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    color: #8fa873;
    border: 2px dashed #8fa873;
    padding: 10px 15px;
    font-size: 1.5rem;
    border-radius: 12px;
    cursor: pointer;
    z-index: 2000;
    transition: 0.3s;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.menu-btn:hover {
    background-color: #8fa873;
    color: white;
    border-style: solid;
}

.sidebar {
    height: 100%;
    width: 0; 
    position: fixed;
    z-index: 2050;
    top: 0;
    left: 0;
    
    background-color: rgba(255, 255, 255, 0.45); 
    backdrop-filter: blur(15px); 
    -webkit-backdrop-filter: blur(15px);
    border-right: 1px solid rgba(255, 255, 255, 0.6);
    box-shadow: 5px 0 25px rgba(0, 0, 0, 0.1);

    overflow-x: hidden;
    transition: 0.4s;
    padding-top: 80px;
    white-space: nowrap;
}

.sidebar h2 {
    position: absolute;
    top: 25px;
    left: 30px;
    margin: 0;
    color: #5a5a4d;
    font-weight: 600;
}

.sidebar a {
    padding: 15px 30px;
    text-decoration: none;
    font-size: 1.1rem;
    color: #333;
    display: block;
    transition: 0.3s;
    font-weight: 500;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
}

.sidebar a:hover {
    background-color: rgba(143, 168, 115, 0.15); /* Hijau muda transparan */
    color: #8fa873;
    padding-left: 40px; 
}

.sidebar .close-btn {
    position: absolute;
    top: 20px;
    right: 25px;
    font-size: 2rem;
    color: #ff6b6b;
    background: none;
    border: none;
    cursor: pointer;
}

#overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: rgba(0,0,0,0.3);
    z-index: 2040;
    backdrop-filter: blur(3px);
}
</style>
</head>

<body>

<button class="menu-btn" onclick="openNav()">
    <i class="bi bi-list"></i> Menu
</button>

<div id="overlay" onclick="closeNav()"></div>

<div id="mySidebar" class="sidebar">
    <h2>Navigasi</h2>
    <button class="close-btn" onclick="closeNav()">&times;</button>
    
    <a href="dashboard.php"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
    <a href="projectmanager.php"><i class="bi bi-kanban me-2"></i> Project Manager</a>
    <a href="tabletugas.php"><i class="bi bi-list-task me-2"></i> Tabel Tugas</a>
    <a href="calender.php"><i class="bi bi-calendar-event me-2"></i> Calendar</a>
    <a href="study_planner.php"><i class="bi bi-journal-text me-2"></i> Study Planner</a>
    <a href="todo.php"><i class="bi bi-check2-square me-2"></i> To Do List</a>
    <a href="media.php"><i class="bi bi-images me-2"></i> Media</a>
    <div style="border-top: 1px solid rgba(0,0,0,0.1); margin: 10px 0;"></div>
    <a href="logout.php" style="color:#ff6b6b;"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
</div>

<div class="container">

    <div class="header-cute">
        <img src="joget.gif">
        <div>
            <h2>My To-Do List 🌱</h2>
            <p class="cute-note">
                do the right thing! semangat kamu pasti bisa ♡
            </p>
        </div>
    </div>

    <div class="section-box">
        <h3>📋 Hari Ini Mau Ngapain</h3>

        <?php if (mysqli_num_rows($todo) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($todo)): ?>
                <div class="todo-item">
                    <input type="checkbox" <?= $row['status'] ? 'checked' : '' ?> 
                            onclick="window.location='todo.php?cek=<?= $row['id_todo'] ?>'">

                    <label><?= htmlspecialchars($row['isi_todo']) ?></label>

                    <a href="todo.php?edit=<?= $row['id_todo'] ?>" style="margin-left:10px; color:#5599ee; text-decoration: none; font-size:0.9rem;">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="todo.php?hapus=<?= $row['id_todo'] ?>" style="margin-left:10px; color:#ff6b6b; text-decoration: none; font-size:0.9rem;" onclick="return confirm('Yakin hapus tugas ini?')">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color:#999;">Yeay! Belum ada tugas nih. Waktunya istirahat atau tambah yang baru!</p>
        <?php endif; ?>

        <form action="" method="POST" style="margin-top: 20px; display:flex; align-items:flex-start;">
            <?php if ($editData): ?>
                <input type="hidden" name="id_edit" value="<?= $editData['id_todo'] ?>">
                <input class="add-input" type="text" name="isi_baru" value="<?= htmlspecialchars($editData['isi_todo']) ?>" required>
                <button class="add-btn" name="update" type="submit" style="width: 100px;">Simpan</button>
                <a href="todo.php" class="add-btn" style="background:gray; margin-left:5px; width: 100px; text-align:center;">Batal</a>

            <?php else: ?>
                <input class="add-input" type="text" name="isi_todo" placeholder="Tambah tugas baru..." required>
                <button class="add-btn" formaction="todo_add.php" type="submit" style="width: 100px;">Tambah</button>
            <?php endif; ?>
        </form>

    </div>

    <div class="section-box">
        <h3>🎁 Self-Reward</h3>
        <p style="color:#7a7a7a; font-size:0.95rem;">Kalau semua checklist kamu selesai, kamu boleh kasih diri sendiri hadiah kecil ♡</p>

        <div class="reward-box" style="margin-bottom:15px;">
            <div class="reward-item">✨ nonton 1 episode anime / drama</div>
            <div class="reward-item">✨ jajan es krim</div>
            <div class="reward-item">✨ main game 30 menit</div>
            <div class="reward-item">✨ scrolling aesthetic pinterest</div>
        </div>

        <div style="display:flex; align-items:center;">
            <input class="add-input" type="text" id="newReward" placeholder="Tambah reward baru...">
            <button class="add-btn" onclick="addReward()" type="button" style="width: 100px; margin-top:0;">Tambah</button>
        </div>
    </div>

</div>

<script>
function addReward() {
    const input = document.getElementById("newReward");
    const text = input.value.trim();
    if (!text) return;

    const div = document.createElement("div");
    div.className = "reward-item";
    div.textContent = "✨ " + text;
    document.querySelector(".reward-box").appendChild(div);

    input.value = "";
}

const sidebar = document.getElementById("mySidebar");
const overlay = document.getElementById("overlay");

function openNav() {
    sidebar.style.width = "280px";
    overlay.style.display = "block";
}

function closeNav() {
    sidebar.style.width = "0";
    overlay.style.display = "none";
}
</script>

</body>
</html>
