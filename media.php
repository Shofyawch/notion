<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id'])) {
    die("User belum login.");
}

$id_user = $_SESSION['id'];
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Media Page</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
      body {
        font-family: "Fredoka", sans-serif;
        background: #00ffff42;
        margin: 0;
        padding: 25px;
        padding-top: 80px;
      }

      h1 {
        font-size: 32px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
      }

      .subtitle {
        background: #fff3fc;
        padding: 8px 15px;
        display: inline-block;
        border-radius: 20px;
        font-size: 14px;
        border: 1px solid #f6ff0062;
        color: #555;
      }

      
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
    background-color: rgba(143, 168, 115, 0.15); 
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

      
      .media-container {
        margin-top: 25px;
        background: #fff20036;
        padding: 20px;
        border-radius: 14px;
        border: 1px solid #f1b7d8;
        box-shadow: 0 0 10px rgba(255, 163, 204, 0.25);
      }

      .upload-box {
        border: 2px dashed #ff8dbd;
        padding: 30px;
        text-align: center;
        border-radius: 14px;
        background: #ff006286;
        cursor: pointer;
        margin-bottom: 25px;
        transition: 0.3s;
        color: white;
      }

      .upload-box:hover {
        background: #fffb006c;
        border-color: #ff74b0;
        color: #ff0062;
      }

      .upload-box input { display: none; }

      #upload {
    display: none;
}


      .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
      }

      .preview-item {
        background: rgba(255, 255, 0, 0.486);
        padding: 8px;
        border-radius: 12px;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.12);
      }

      .preview-item img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 10px;
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

<h1>Media Upload 𓇼</h1>

<div class="media-container">

<form action="media_upload.php" method="POST" enctype="multipart/form-data">
  
  <input type="hidden" name="id_user" value="<?= $id_user ?>">

  <label class="upload-box" for="upload">
    <p style="font-size:16px;margin:0;">📁 Click here to upload images</p>
  </label>

  <input id="upload" type="file" name="images[]" accept="image/*" multiple required>


  <button type="submit" style="
      background:#ff0062; 
      color:white; 
      padding:12px 20px; 
      border:none; 
      border-radius:10px;
      cursor:pointer;
      font-size:16px;
      margin-top:15px;">
      Upload
  </button>
</form>

<div class="preview-grid" id="preview"></div>

<?php
$images = mysqli_query($koneksi,
  "SELECT * FROM media_upload WHERE id_user='$id_user' ORDER BY uploaded_at DESC"
);

while ($img = mysqli_fetch_assoc($images)): ?>
  <div class="preview-item">
    <img src="<?= $img['filepath'] ?>">
  </div>
<?php endwhile; ?>

</div>

<br /> <img src="swipe-up-swipe-ezgif.com-gif-maker.gif" width="200" style="border-radius: 10px;" />

<script>
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

  const upload = document.getElementById("upload");
  const preview = document.getElementById("preview");

  upload.addEventListener("change", function () {
    [...this.files].forEach((file) => {
      const reader = new FileReader();
      reader.onload = function (e) {
        const item = document.createElement("div");
        item.classList.add("preview-item");
        item.innerHTML = `<img src="${e.target.result}">`;
        preview.appendChild(item);
      };
      reader.readAsDataURL(file);
    });
  });
</script>

</body>
</html>
