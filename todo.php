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

    mysqli_query($koneksi, "UPDATE todo SET isi_todo='$isi_baru' WHERE id_todo='$id_edit'");
    header("Location: todo.php");
    exit;
}

// DELETE
if (isset($_GET["hapus"])) {
    $hapus_id = $_GET["hapus"];
    mysqli_query($koneksi, "DELETE FROM todo WHERE id_todo='$hapus_id'");
    header("Location: todo.php");
    exit;
}

// CHECK / UNCHECK
if (isset($_GET["cek"])) {
    $cek_id = $_GET["cek"];

    mysqli_query($koneksi, "UPDATE todo SET status = IF(status=1, 0, 1) WHERE id_todo='$cek_id'");
    header("Location: todo.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Cute To-Do List</title>

<style>
body {
    font-family: "Arial", sans-serif;
    background: url('lautb.gif') no-repeat center center;
    background-size: cover; 
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
}

h2 {
    color: #8fa873;
    margin-bottom: 8px;
}

.section-box {
    border: 1.5px solid #dfdfcf;
    border-radius: 8px;
    padding: 18px;
    margin-top: 20px;
    background: #fcfcf7;
}

.todo-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.todo-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 10px;
    cursor: pointer;
}

.header-cute {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-cute img {
    width: 80px;
    border-radius: 14px;
}

button.add-btn {
    margin-top: 10px;
    padding: 5px 12px;
    border: none;
    border-radius: 8px;
    background: #8fa873;
    color: white;
    cursor: pointer;
}

.add-btn:hover {
    background: #72875b;
}

input.add-input {
    width: calc(100% - 80px);
    padding: 5px;
    border-radius: 6px;
    border: 1px solid #8fa873;
    margin-right: 5px;
}
</style>
</head>

<body>
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

        <?php while($row = mysqli_fetch_assoc($todo)): ?>
            <div class="todo-item">
                <input type="checkbox" <?= $row['status'] ? 'checked' : '' ?> 
                       onclick="window.location='todo.php?cek=<?= $row['id_todo'] ?>'">

                <label><?= htmlspecialchars($row['isi_todo']) ?></label>

                <a href="todo.php?edit=<?= $row['id_todo'] ?>" style="margin-left:10px; color:blue;">Edit</a>
                <a href="todo.php?hapus=<?= $row['id_todo'] ?>" style="margin-left:10px; color:red;">Hapus</a>
            </div>
        <?php endwhile; ?>

        <!-- FORM INPUT & EDIT -->
        <form action="" method="POST" style="margin-top: 10px;">
            <?php if ($editData): ?>
                <input type="hidden" name="id_edit" value="<?= $editData['id_todo'] ?>">
                <input class="add-input" type="text" name="isi_baru" value="<?= htmlspecialchars($editData['isi_todo']) ?>" required>
                <button class="add-btn" name="update">Simpan</button>
                <a href="todo.php" class="add-btn" style="background:gray;">Batal</a>

            <?php else: ?>
                <input class="add-input" type="text" name="isi_todo" placeholder="Tambah tugas baru..." required>
                <button class="add-btn" formaction="todo_add.php">Tambah</button>
            <?php endif; ?>
        </form>

    </div>

    <!-- SELF REWARD SECTION -->
    <div class="section-box">
        <h3>🎁 Self-Reward</h3>
        <p>Kalau semua checklist kamu selesai, kamu boleh kasih diri sendiri hadiah kecil ♡</p>

        <div class="reward-box">
            <div class="reward-item">✨ nonton 1 episode anime / drama</div>
            <div class="reward-item">✨ jajan es krim</div>
            <div class="reward-item">✨ main game 30 menit</div>
            <div class="reward-item">✨ scrolling aesthetic pinterest</div>
        </div>

        <input class="add-input" type="text" id="newReward" placeholder="Tambah reward baru...">
        <button class="add-btn" onclick="addReward()">Tambah</button>
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
</script>

</body>
</html>
