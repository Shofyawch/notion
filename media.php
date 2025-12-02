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

      /* --- SIDEBAR --- */
      .menu-btn {
        position: fixed;
        top: 20px;
        left: 20px;
        background-color: rgba(255, 255, 255, 0.8);
        color: #ff0062;
        border: 2px dashed #ff0062;
        padding: 10px 15px;
        font-size: 1.2rem;
        border-radius: 12px;
        cursor: pointer;
        z-index: 2000;
        transition: 0.3s;
        font-family: "Fredoka", sans-serif;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      }

      .menu-btn:hover {
        background-color: #ff0062;
        color: white;
        border-style: solid;
      }

      .sidebar {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 2001;
        top: 0;
        left: 0;
        background-color: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(15px);
        border-right: 1px solid rgba(255, 255, 255, 0.6);
        overflow-x: hidden;
        transition: 0.4s;
        padding-top: 80px;
        white-space: nowrap;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
      }

      .sidebar a {
        padding: 15px 25px;
        text-decoration: none;
        font-size: 1.2rem;
        color: #444;
        display: block;
        transition: 0.3s;
        font-weight: 600;
        border-bottom: 1px dashed rgba(255, 0, 98, 0.1);
      }

      .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.6);
        color: #ff0062;
        padding-left: 35px;
      }

      .close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 2rem;
        color: #ff0062;
        background: none;
        border: none;
        cursor: pointer;
      }

      .sidebar-title {
        position: absolute;
        top: 25px;
        left: 25px;
        font-size: 1.5rem;
        font-weight: bold;
        color: #ff0062;
      }

      #overlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(0,0,0,0.2);
        z-index: 1999;
        backdrop-filter: blur(2px);
      }

      /* MAIN */
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

<button class="menu-btn" onclick="openNav()">☰ Menu</button>

<div id="overlay" onclick="closeNav()"></div>

<div id="mySidebar" class="sidebar">
  <div class="sidebar-title">Navigasi</div>
  <button class="close-btn" onclick="closeNav()">&times;</button>
  
  <a href="dashboard.php">Dashboard</a>
  <a href="tabletugas.php">Table Tugas</a>
  <a href="study_planner.php">Study planner</a>
  <a href="projectmanager.php">Project Manager</a>
  <a href="calender.php">Calender</a>
  <a href="todo.php">To Do List</a>
  <a href="media.php">Media Upload</a>
  <a href="logout.php">Logout</a>
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
  function openNav() {
    document.getElementById("mySidebar").style.width = "260px";
    document.getElementById("overlay").style.display = "block";
  }
  function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("overlay").style.display = "none";
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
