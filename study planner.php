<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

/* ============================================================
   STUDY PLANNER CRUD
============================================================ */

/* ---- ADD ---- */
if (isset($_POST['add_study'])) {
    $time_range = mysqli_real_escape_string($koneksi, $_POST['time_range']);
    $activity   = mysqli_real_escape_string($koneksi, $_POST['activity']);

    mysqli_query($koneksi,
        "INSERT INTO studyplanner (time_range, activity, id_user)
         VALUES ('$time_range', '$activity', '$id_user')"
    ) or die("INSERT ERROR: " . mysqli_error($koneksi));

    header("Location: study_planner.php");
    exit;
}

/* ---- DELETE ---- */
if (isset($_GET['delete_study'])) {
    $id = intval($_GET['delete_study']);

    mysqli_query($koneksi,
        "DELETE FROM studyplanner 
         WHERE id_studyplanner = $id AND id_user = $id_user"
    ) or die("DELETE ERROR: " . mysqli_error($koneksi));

    header("Location: study_planner.php");
    exit;
}

/* ---- UPDATE ---- */
if (isset($_POST['edit_study'])) {
    $id        = intval($_POST['id']);
    $time_range = mysqli_real_escape_string($koneksi, $_POST['time_range']);
    $activity   = mysqli_real_escape_string($koneksi, $_POST['activity']);

    mysqli_query($koneksi,
        "UPDATE studyplanner SET
            time_range = '$time_range',
            activity   = '$activity'
         WHERE id_studyplanner = $id AND id_user = $id_user"
    ) or die("UPDATE ERROR: " . mysqli_error($koneksi));

    header("Location: study_planner.php");
    exit;
}

/* ---- READ ---- */
$study_data = mysqli_query($koneksi,
    "SELECT * FROM studyplanner
     WHERE id_user = '$id_user'
     ORDER BY id_studyplanner DESC"
);


/* ============================================================
   CLASS SCHEDULE CRUD
============================================================ */

/* ---- ADD ---- */
// ===== ADD CLASS SCHEDULE =====
if (isset($_POST['add_class'])) {

    $time_slot = mysqli_real_escape_string($koneksi, $_POST['time_slot']);
    $monday    = mysqli_real_escape_string($koneksi, $_POST['monday']);
    $tuesday   = mysqli_real_escape_string($koneksi, $_POST['tuesday']);
    $wednesday = mysqli_real_escape_string($koneksi, $_POST['wednesday']);
    $thursday  = mysqli_real_escape_string($koneksi, $_POST['thursday']);
    $friday    = mysqli_real_escape_string($koneksi, $_POST['friday']);

    mysqli_query($koneksi, "
        INSERT INTO class_schedule (id_user, time_slot, monday, tuesday, wednesday, thursday, friday)
        VALUES ('$id_user', '$time_slot', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday')
    ") or die('ADD CLASS ERROR: ' . mysqli_error($koneksi));

    header("Location: study planner.php");
    exit;
}

/* ---- DELETE ---- */
if (isset($_GET['delete_class'])) {
    $id = intval($_GET['delete_class']);

    mysqli_query($koneksi,
        "DELETE FROM class_schedule WHERE id=$id AND id_user=$id_user"
    ) or die("DELETE ERROR: " . mysqli_error($koneksi));

    header("Location: study planner.php");
    exit;
}

/* ---- UPDATE ---- */
if (isset($_POST['edit_class'])) {
    $id        = intval($_POST['id']);
    $time_slot = mysqli_real_escape_string($koneksi, $_POST['time_slot']);
    $monday    = mysqli_real_escape_string($koneksi, $_POST['monday']);
    $tuesday   = mysqli_real_escape_string($koneksi, $_POST['tuesday']);
    $wednesday = mysqli_real_escape_string($koneksi, $_POST['wednesday']);
    $thursday  = mysqli_real_escape_string($koneksi, $_POST['thursday']);
    $friday    = mysqli_real_escape_string($koneksi, $_POST['friday']);

    mysqli_query($koneksi,
        "UPDATE class_schedule SET
            time_slot='$time_slot',
            monday='$monday',
            tuesday='$tuesday',
            wednesday='$wednesday',
            thursday='$thursday',
            friday='$friday'
        WHERE id=$id AND id_user=$id_user"
    ) or die("UPDATE ERROR: " . mysqli_error($koneksi));

    header("Location: study planner.php");
    exit;
}

/* ---- READ ---- */
$class_data = mysqli_query($koneksi,
    "SELECT * FROM class_schedule
     WHERE user_id='$id_user'
     ORDER BY time_slot ASC"
);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Planner 2025</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* --- GLOBAL STYLE --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Fredoka', sans-serif;
            background-image: url('bg1.gif'); /* Pastikan file ini ada */
            background-size: cover;     
            background-position: center;  
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            color: #333;
            min-height: 100vh;
        }

        /* --- STYLE SIDEBAR TRANSPARAN (GLASSMORPHISM) --- */
        .menu-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            color: #61e1ce;
            border: 2px dashed #61e1ce;
            padding: 10px 15px;
            font-size: 1.5rem;
            border-radius: 10px;
            cursor: pointer;
            z-index: 2000;
            transition: 0.3s;
            box-shadow: 0px 5px 10px rgba(0,0,0,0.1);
        }

        .menu-btn:hover {
            background-color: #61e1ce;
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
            background-color: rgba(255, 255, 255, 0.25); /* Transparan */
            backdrop-filter: blur(10px); /* Efek Blur */
            -webkit-backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
            overflow-x: hidden;
            transition: 0.4s;
            padding-top: 60px;
            white-space: nowrap;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 1.2rem;
            color: #333;
            font-weight: 700;
            display: block;
            transition: 0.3s;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.5);
            text-shadow: 0px 0px 2px rgba(255,255,255,0.8);
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.4);
            color: #3ec8ff;
            padding-left: 35px;
        }

        .sidebar .close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 2rem;
            color: #ff6b6b;
            background: none;
            border: none;
            cursor: pointer;
        }

        .sidebar-title {
            padding: 0 25px 20px;
            font-size: 1.5rem;
            color: #3ec8ff;
            font-weight: bold;
            text-align: center;
            text-shadow: 2px 2px 0px #fff;
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

        /* --- PLANNER LAYOUT --- */
        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px 100px 20px; /* Padding atas besar agar tidak ketutup tombol menu */
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #61e1ce;
            text-shadow: 3px 3px 0px #acfad1;
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .header p {
            color: #fff;
            background-color: #3ec8ff;
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        /* Grid Layout Utama */
        .main {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .studyplanner {
            flex: 1;
            min-width: 300px;
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .right-column {
            flex: 2;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Styles untuk Tabel */
        h3 {
            color: #3ec8ff;
            margin-bottom: 15px;
            border-bottom: 2px dashed #eee;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #61e1ce;
            color: white;
            padding: 10px;
            text-align: left;
            border-radius: 5px;
        }

        td {
            padding: 10px;
            border-bottom: 1px dashed #ddd;
        }

        input[type="text"] {
            width: 100%;
            border: none;
            background: #f9f9f9;
            padding: 5px;
            border-radius: 5px;
            font-family: 'Fredoka', sans-serif;
            color: #555;
        }

        input[type="text"]:focus {
            outline: 2px solid #3ec8ff;
            background: #fff;
        }

        /* Widgets Bawah (Notif & ToDo) */
        .bottom-widgets {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .notification, .todo {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            min-width: 250px;
        }

        .todo ul, .notification ul {
            list-style: none;
            padding: 0;
        }

        .todo li, .notification li {
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .todo-input {
            width: 70%;
            padding: 10px;
            margin-top: 15px;
            border: 2px dashed #3ec8ff;
            border-radius: 10px;
        }

        .todo-btn {
            padding: 10px 20px;
            background: #61e1ce;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .todo-btn:hover {
            transform: scale(1.05);
        }

        /* --- MUSIC PLAYER --- */
        #cassette-animation {
            width: 100px;
            cursor: pointer;
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .spinning {
            animation: spin 2s linear infinite;
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .main, .bottom-widgets {
                flex-direction: column;
            }
            .right-column {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <button class="menu-btn" onclick="openNav()">☰ Menu</button>

    <div id="overlay" onclick="closeNav()"></div>

    <div id="mySidebar" class="sidebar">
        <button class="close-btn" onclick="closeNav()">&times;</button>
        <div class="sidebar-title">Student Planner</div>
        
        <a href="dahsboard.php">Dashboard</a>
        <a href="tabletugas.php">Table Tugas</a>
        <a href="calender.php">Calender</a>
        <a href="projectmanager.php">Project Manager</a>
        <a href="media.html">Media</a>
        <a href="login.php">Logout</a>
    </div>

    <div class="wrapper">

        <div class="header">
            <h1>2025 Student Planner</h1>
            <p>The Future Depends on What You Do Today</p>
        </div>

        <div class="main">

            <div class="studyplanner">
    <h3>Study Plan</h3>

    <!-- FORM TAMBAH -->
    <form method="POST" style="margin-bottom:15px;">
        <input type="text" name="time_range" placeholder="06:00 - 07:00" required>
        <input type="text" name="activity" placeholder="Activity..." required>
        <button name="add_study" class="todo-btn">Add</button>
    </form>

    <!-- TABEL DATA -->
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>Activity</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = mysqli_fetch_assoc($study_data)) { ?>

                <tr>
                    <td><?= $row['time_range'] ?></td>
                    <td><?= $row['activity'] ?></td>
                    <td>

                        <!-- Tombol Edit -->
                        <button onclick="openEdit(
    '<?= $row['id_studyplanner'] ?>',
    '<?= $row['time_range'] ?>',
    '<?= $row['activity'] ?>'
)"

                        class="todo-btn"
                        style="background:#3ec8ff; padding:5px 10px;">
                            Edit
                        </button>

                        <!-- Tombol Delete -->
                        <a href="study planner.php?delete=<?= $row['id_studyplanner'] ?>" 
    onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>


                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


            <div class="right-column">
                <div class="class-schedule" style="background: white; padding: 20px; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); overflow-x: auto;">


                <h3>Class Schedule</h3>

                <button class="todo-btn" style="margin-bottom:15px;" onclick="openAddClass()">
    + Add Class
</button>


<table class="schedule-table">
    <thead>
        <tr>
            <th>Time</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th style="width:90px;">Action</th>
        </tr>
    </thead>

    <tbody>
    <?php while ($cs = mysqli_fetch_assoc($class_data)) { ?>
        <tr>
            <td><?= $cs['time_slot'] ?></td>
            <td><?= $cs['monday'] ?></td>
            <td><?= $cs['tuesday'] ?></td>
            <td><?= $cs['wednesday'] ?></td>
            <td><?= $cs['thursday'] ?></td>
            <td><?= $cs['friday'] ?></td>

            <td>
                <button class="btn-edit"
                    onclick="openEditClass(
                        '<?= $cs['id'] ?>',
                        '<?= $cs['time_slot'] ?>',
                        '<?= $cs['monday'] ?>',
                        '<?= $cs['tuesday'] ?>',
                        '<?= $cs['wednesday'] ?>',
                        '<?= $cs['thursday'] ?>',
                        '<?= $cs['friday'] ?>'
                    )">Edit</button>

                <a href="?delete_class=<?= $cs['id'] ?>" 
                   onclick="return confirm('Delete?')" 
                   class="btn-delete">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

                </div>

                <div class="bottom-widgets">

                    <div class="notification">
                        <h3>Notifications</h3>
                        <ul>
                            <li>Don't forget to review notes!</li>
                            <li>Exam on Friday: Math.</li>
                            <li>Group study Wed at 4 PM.</li>
                        </ul>
                    </div>

                    <div class="todo">
                        <h3>To-Do List</h3>
                        <ul>
                            <li><input type="checkbox"> Finish homework</li>
                            <li><input type="checkbox"> Review notes</li>
                            <li><input type="checkbox"> Prepare tomorrow</li>
                        </ul>
                        <input class="todo-input" placeholder="New task...">
                        <button class="todo-btn">Add</button>
                    </div>

                </div>
            </div>
        </div>
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
        
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("overlay").style.display = "block";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("overlay").style.display = "none";
        }

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

        <!-- ===== MODAL EDIT ===== -->
<div id="editModalClass"
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">

    <div style="background:white; padding:20px; width:320px; border-radius:12px;">
        <h3>Edit Class Schedule</h3>

        <table> 
            <thead> 
                <tr> 
                    <th>Time</th> 
                    <th>Mon</th> 
                    <th>Tue</th> 
                    <th>Wed</th> 
                    <th>Thu</th> <th>Fri</th> </tr> </thead> <tbody> <tr> <td><input type="text" placeholder="08:00"></td> <td><input type="text" placeholder="Math"></td> <td><input type="text" placeholder="Eng"></td> <td><input type="text" placeholder="Hist"></td> <td><input type="text" placeholder="Sci"></td> <td><input type="text" placeholder="Art"></td> </tr> <tr> <td><input type="text" placeholder="09:00"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> </tr> <tr> <td><input type="text" placeholder="10:00"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> </tr> <tr> <td><input type="text" placeholder="11:00"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td> <td><input type="text" placeholder="Subject"></td>
        <form method="POST">
            <input type="hidden" name="id" id="class_id">

            <label>Time Slot</label>
            <input type="text" name="time_slot" id="class_time" required>

            <label>Monday</label>
            <input type="text" name="monday" id="class_mon">

            <label>Tuesday</label>
            <input type="text" name="tuesday" id="class_tue">

            <label>Wednesday</label>
            <input type="text" name="wednesday" id="class_wed">

            <label>Thursday</label>
            <input type="text" name="thursday" id="class_thu">

            <label>Friday</label>
            <input type="text" name="friday" id="class_fri">

            <button type="submit" name="edit_class" class="btn">Save</button>
            <button type="button" onclick="closeEditClass()" class="btn" style="background:#ff6b6b;">Cancel</button>
        </form>
    </div>
</div>

<div id="addModalClass"
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">

    <div style="background:white; padding:20px; width:320px; border-radius:12px;">
        <h3>Add Class</h3>

        <form method="POST">
            <label>Time Slot</label>
            <input type="text" name="time_slot" required>

            <label>Monday</label>
            <input type="text" name="monday">

            <label>Tuesday</label>
            <input type="text" name="tuesday">

            <label>Wednesday</label>
            <input type="text" name="wednesday">

            <label>Thursday</label>
            <input type="text" name="thursday">

            <label>Friday</label>
            <input type="text" name="friday">

            <button type="submit" name="add_class" class="btn">Add</button>
            <button type="button" onclick="closeAddClass()" class="btn" style="background:#ff6b6b;">Cancel</button>
        </form>
    </div>
</div>


<script>
function openEditClass(id, time, mon, tue, wed, thu, fri) {
    document.getElementById('class_id').value = id;
    document.getElementById('class_time').value = time;
    document.getElementById('class_mon').value = mon;
    document.getElementById('class_tue').value = tue;
    document.getElementById('class_wed').value = wed;
    document.getElementById('class_thu').value = thu;
    document.getElementById('class_fri').value = fri;

    document.getElementById('editModalClass').style.display = "flex";
}

function closeEditClass() {
    document.getElementById('editModalClass').style.display = "none";
}

function openAddClass() {
    document.getElementById("addClassModal").style.display = "flex";
}

function closeAddClass() {
    document.getElementById("addClassModal").style.display = "none";
}

function openAddClass() {
    document.getElementById("addModalClass").style.display = "flex";
}

function closeAddClass() {
    document.getElementById("addModalClass").style.display = "none";
}

</script>

</body>
</html>
