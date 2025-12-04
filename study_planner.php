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

if (isset($_POST['add_study'])) {
    $time_range = mysqli_real_escape_string($koneksi, $_POST['time_range']);
    $activity   = mysqli_real_escape_string($koneksi, $_POST['activity']);

    mysqli_query(
        $koneksi,
        "INSERT INTO studyplanner (time_range, activity, id_user)
         VALUES ('$time_range', '$activity', '$id_user')"
    ) or die("INSERT STUDY ERROR: " . mysqli_error($koneksi));

    header("Location: study_planner.php");
    exit;
}

if (isset($_GET['delete'])) { 
    $id = intval($_GET['delete']);

    mysqli_query(
        $koneksi,
        "DELETE FROM studyplanner 
        WHERE id_studyplanner = $id AND id_user = $id_user"
    ) or die("DELETE STUDY ERROR: " . mysqli_error($koneksi));

    header("Location: study_planner.php");
    exit;
}

if (isset($_POST['edit_study'])) {
    $id         = intval($_POST['id']);
    $time_range = mysqli_real_escape_string($koneksi, $_POST['time_range']);
    $activity   = mysqli_real_escape_string($koneksi, $_POST['activity']);

    mysqli_query(
        $koneksi,
        "UPDATE studyplanner SET
            time_range = '$time_range',
            activity   = '$activity'
        WHERE id_studyplanner = $id AND id_user = $id_user"
    ) or die("UPDATE STUDY ERROR: " . mysqli_error($koneksi));

    header("Location: study_planner.php");
    exit;
}

$study_data = mysqli_query(
    $koneksi,
    "SELECT * FROM studyplanner
    WHERE id_user = '$id_user'
    ORDER BY id_studyplanner DESC"
);


/* ============================================================
    CLASS SCHEDULE CRUD
============================================================ */

if (isset($_POST['add_class'])) {
    $time_slot = mysqli_real_escape_string($koneksi, $_POST['time_slot']);
    $monday    = mysqli_real_escape_string($koneksi, $_POST['monday']);
    $tuesday   = mysqli_real_escape_string($koneksi, $_POST['tuesday']);
    $wednesday = mysqli_real_escape_string($koneksi, $_POST['wednesday']);
    $thursday  = mysqli_real_escape_string($koneksi, $_POST['thursday']);
    $friday    = mysqli_real_escape_string($koneksi, $_POST['friday']);

    mysqli_query($koneksi, "
        INSERT INTO class_schedule (user_id, time_slot, monday, tuesday, wednesday, thursday, friday)
        VALUES ('$id_user', '$time_slot', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday')
    ") or die('ADD CLASS ERROR: ' . mysqli_error($koneksi));

    header("Location: study_planner.php");
    exit;
}

if (isset($_GET['delete_class'])) {
    $id = intval($_GET['delete_class']);

    mysqli_query(
        $koneksi,
        "DELETE FROM class_schedule WHERE id=$id AND id_user=$id_user"
    ) or die("DELETE CLASS ERROR: " . mysqli_error($koneksi));

    header("Location: study_planner.php");
    exit;
}

/* ---- UPDATE CLASS SCHEDULE ---- */
if (isset($_POST['edit_class'])) {
    $id         = intval($_POST['id']);
    $time_slot  = mysqli_real_escape_string($koneksi, $_POST['time_slot']);
    $monday     = mysqli_real_escape_string($koneksi, $_POST['monday']);
    $tuesday    = mysqli_real_escape_string($koneksi, $_POST['tuesday']);
    $wednesday  = mysqli_real_escape_string($koneksi, $_POST['wednesday']);
    $thursday   = mysqli_real_escape_string($koneksi, $_POST['thursday']);
    $friday     = mysqli_real_escape_string($koneksi, $_POST['friday']);

    mysqli_query(
        $koneksi,
        "UPDATE class_schedule SET
            time_slot='$time_slot',
            monday='$monday',
            tuesday='$tuesday',
            wednesday='$wednesday',
            thursday='$thursday',
            friday='$friday'
        WHERE id=$id AND id_user=$id_user"
    ) or die("UPDATE CLASS ERROR: " . mysqli_error($koneksi));

    header("Location: study_planner.php");
    exit;
}

/* ---- READ ---- */
$class_data = mysqli_query(
    $koneksi,
    "SELECT * FROM class_schedule
    WHERE id='$id_user' 
    ORDER BY time_slot ASC"

);

$todo = mysqli_query($koneksi,
    "SELECT * FROM todo WHERE id = '$id_user' ORDER BY id DESC"
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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Fredoka', sans-serif;
            background-image: url('bg1.gif');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #333;
            min-height: 100vh;
        }

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
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
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
            background-color: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
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
            text-shadow: 0px 0px 2px rgba(255, 255, 255, 0.8);
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
            background-color: rgba(0, 0, 0, 0.2);
            z-index: 1999;
            backdrop-filter: blur(2px);
        }

        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px 100px 20px;
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
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .right-column {
            flex: 2;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

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
            margin-bottom: 10px; 
        }
        
        .studyplanner form input[type="text"] {
            width: calc(50% - 5px); 
            display: inline-block;
        }
        
        .studyplanner form input[type="text"]:nth-child(2) {
            margin-left: 5px;
        }

        input[type="text"]:focus {
            outline: 2px solid #3ec8ff;
            background: #fff;
        }

        .bottom-widgets {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .notification,
        .todo {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            min-width: 250px;
        }

        .todo ul,
        .notification ul {
            list-style: none;
            padding: 0;
        }

        .todo li,
        .notification li {
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

        .todo-btn, .btn, .btn-edit, .btn-delete {
            padding: 10px 20px;
            background: #61e1ce;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s;
            font-family: 'Fredoka', sans-serif;
            font-size: 1rem;
        }
        
        .todo-btn:hover, .btn:hover {
            transform: scale(1.05);
        }
        
        .card {
            background: white;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 10px 20px rgba(255,105,180,0.3);
            margin-top: 25px;
        }

    .todo-list {
        list-style: none;
        padding: 0;
        margin: 0 0 20px;
    }

    .todo-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        font-size: 17px;
    }

    .todo-list li:last-child {
        border-bottom: none;
    }

    .todo-actions a {
        margin-left: 10px;
        font-size: 20px;
        text-decoration: none;
    }

    .todo-check { 
        color: #2ecc71;
        font-weight: bold;
    }

    .todo-del { 
        color: #e74c3c;
        font-weight: bold;
    }

    .empty {
        text-align: center;
        color: #888;
        padding: 15px;
    }

    .todo-form {
        display: flex;
        gap: 10px;
    }

    .todo-form input {
        flex: 1;
        padding: 12px;
        border: 2px solid #85d7ff;
        border-radius: 10px;
        font-size: 16px;
    }

    .todo-form button {
        padding: 12px 20px;
        background: #55c0ea;
        border: none;
        color: white;
        border-radius: 12px;
        cursor: pointer;
        font-size: 16px;
    }

    .todo-form button:hover {
        background: #3ca8d6;
    }
        .btn-edit {
            background:#3ec8ff; 
            padding:5px 10px;
        }
        
        .btn-delete {
            background:#ff6b6b; 
            padding:5px 10px;
            margin-left: 5px;
        }
        
        .btn-edit:hover, .btn-delete:hover {
            opacity: 0.8;
        }

        .modal {
            display: none; 
            position: fixed; 
            z-index: 3000; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
            justify-content: center; 
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border-radius: 12px;
            width: 90%; 
            max-width: 400px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .modal-content label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #61e1ce;
        }
        
        .modal-content input[type="text"] {
            margin-bottom: 0;
        }

        #cassette-animation {
            width: 100px;
            cursor: pointer;
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            transition: 0.3s;
        }
        
        #cassette-animation:hover {
            opacity: 0.8;
        }

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

        @media (max-width: 768px) {

            .main,
            .bottom-widgets {
                flex-direction: column;
            }

            .right-column {
                width: 100%;
            }
            .studyplanner form input[type="text"] {
                width: 100%;
                display: block;
                margin-left: 0 !important;
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
        
        <a href="dashboard.php">Dasboard</a>
        <a href="todo.php">To Do List</a>
        <a href="tabletugas.php">Table Tugas</a>
        <a href="calender.php">Calender</a>
        <a href="projectmanager.php">Project Manager</a>
        <a href="media.php">Media</a>
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

                <form method="POST" style="margin-bottom:15px;">
                    <input type="text" name="time_range" placeholder="06:00 - 07:00" required>
                    <input type="text" name="activity" placeholder="Activity..." required>
                    <button name="add_study" class="todo-btn">Add</button>
                </form>

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

                                    <button type="button"
                                        onclick='openEdit(<?= json_encode($row['id_studyplanner']) ?>, <?= json_encode($row['time_range']) ?>, <?= json_encode($row['activity']) ?>)'
                                        class="todo-btn"
                                        style="background:#3ec8ff; padding:5px 10px;">
                                        Edit
                                    </button>

                                    <a href="study_planner.php?delete_study=<?= $row['id_studyplanner'] ?>"
                                        onclick="return confirm('Delete this study plan?')"
                                        class="btn-delete">Delete</a>

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

                                        <a href="study_planner.php?delete_class=<?= $cs['id'] ?>"
                                            onclick="return confirm('Delete this class schedule?')"
                                            class="btn-delete delete_study">Delete</a>
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

<div class="card">
    <h2>To-Do List</h2>

    <ul class="todo-list">
        <?php if(mysqli_num_rows($todo) > 0): ?>
            <?php while($t = mysqli_fetch_assoc($todo)): ?>
                <li>
                    <span><?= htmlspecialchars($t['isi_todo']) ?></span>

                    <div class="todo-actions">
                        <a class="todo-check" href="todo_check.php?id=<?= $t['id'] ?>">✔</a>
                        <a class="todo-del" href="todo_delete.php?id=<?= $t['id'] ?>" onclick="return confirm('Delete?')">✖</a>
                    </div>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li class="empty">Belum ada tugas…</li>
        <?php endif; ?>
    </ul>

    <form class="todo-form" action="todo_add.php" method="POST">
        <input type="text" name="task" placeholder="New task..." required>
        <button type="submit">Add</button>
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

    <div id="editModalStudy" class="modal">
        <div class="modal-content">
            <h3>Edit Study Plan</h3>

            <form method="POST">
                <input type="hidden" name="id" id="study_id">

                <label>Time Range</label>
                <input type="text" name="time_range" id="study_time" required>

                <label>Activity</label>
                <input type="text" name="activity" id="study_activity" required>

                <button type="submit" name="edit_study" class="btn">Save</button>
                <button type="button" onclick="closeEditStudy()" class="btn" style="background:#ff6b6b;">Cancel</button>
            </form>
        </div>
    </div>

    <div id="editModalClass" class="modal">
        <div class="modal-content">
            <h3>Edit Class Schedule</h3>

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

    <div id="addModalClass" class="modal">

        <div class="modal-content">
            <h3>Add Class</h3>

            <form method="POST">
                <label>Time Slot</label>
                <input type="text" name="time_slot" placeholder="08:00 - 09:30" required>

                <label>Monday</label>
                <input type="text" name="monday" placeholder="Subject/Lecturer">

                <label>Tuesday</label>
                <input type="text" name="tuesday" placeholder="Subject/Lecturer">

                <label>Wednesday</label>
                <input type="text" name="wednesday" placeholder="Subject/Lecturer">

                <label>Thursday</label>
                <input type="text" name="thursday" placeholder="Subject/Lecturer">

                <label>Friday</label>
                <input type="text" name="friday" placeholder="Subject/Lecturer">

                <button type="submit" name="add_class" class="btn" style="margin-top: 20px;">Add</button>
                <button type="button" onclick="closeAddClass()" class="btn" style="background:#ff6b6b;">Cancel</button>
            </form>
        </div>
    </div>


    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("overlay").style.display = "block";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("overlay").style.display = "none";
        }

        // --- Music Player Functions ---
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

    <div id="editModalClass"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">

        <div style="background:white; padding:20px; width:340px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.3);">
            <h3>Edit Class Schedule</h3>

            <form method="POST">
                <input type="hidden" name="id" id="class_id">

                <label style="display:block; margin-top:10px; font-weight:bold;">Time Slot</label>
                <input type="text" name="time_slot" id="class_time" required>

                <label style="display:block; margin-top:10px; font-weight:bold;">Monday</label>
                <input type="text" name="monday" id="class_mon">

                <label style="display:block; margin-top:10px; font-weight:bold;">Tuesday</label>
                <input type="text" name="tuesday" id="class_tue">

                <label style="display:block; margin-top:10px; font-weight:bold;">Wednesday</label>
                <input type="text" name="wednesday" id="class_wed">

                <label style="display:block; margin-top:10px; font-weight:bold;">Thursday</label>
                <input type="text" name="thursday" id="class_thu">

                <label style="display:block; margin-top:10px; font-weight:bold;">Friday</label>
                <input type="text" name="friday" id="class_fri">

                <button type="submit" name="edit_class" class="todo-btn" style="margin-top:15px; width:100%;">Save</button>
                <button type="button" onclick="closeEditClass()" class="todo-btn" style="background:#ff6b6b; margin-top:5px; width:100%;">Cancel</button>
            </form>
        </div>
    </div>

    <div id="editModalStudy"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">

        <div style="background:white; padding:20px; width:340px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.3);">
            <h3>Edit Study Plan</h3>

            <form method="POST">
                <input type="hidden" name="id" id="study_id">

                <label style="display:block; margin-top:10px; font-weight:bold;">Time Range</label>
                <input type="text" name="time_range" id="study_time" required>

                <label style="display:block; margin-top:10px; font-weight:bold;">Activity</label>
                <input type="text" name="activity" id="study_activity" required>

                <button type="submit" name="edit_study" class="todo-btn" style="margin-top:15px; width:100%;">Save</button>
                <button type="button" onclick="closeEdit()" class="todo-btn" style="background:#ff6b6b; margin-top:5px; width:100%;">Cancel</button>
            </form>
        </div>
    </div>

    <div id="addModalClass"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">

        <div style="background:white; padding:20px; width:340px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.3);">
            <h3>Add Class Schedule</h3>

            <form method="POST">
                <label style="display:block; margin-top:10px; font-weight:bold;">Time Slot</label>
                <input type="text" name="time_slot" required>

                <label style="display:block; margin-top:10px; font-weight:bold;">Monday</label>
                <input type="text" name="monday">

                <label style="display:block; margin-top:10px; font-weight:bold;">Tuesday</label>
                <input type="text" name="tuesday">

                <label style="display:block; margin-top:10px; font-weight:bold;">Wednesday</label>
                <input type="text" name="wednesday">

                <label style="display:block; margin-top:10px; font-weight:bold;">Thursday</label>
                <input type="text" name="thursday">

                <label style="display:block; margin-top:10px; font-weight:bold;">Friday</label>
                <input type="text" name="friday">

                <button type="submit" name="add_class" class="todo-btn" style="margin-top:15px; width:100%;">Add</button>
                <button type="button" onclick="closeAddClass()" class="todo-btn" style="background:#ff6b6b; margin-top:5px; width:100%;">Cancel</button>
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

        function openEdit(id, time, activity) {
            document.getElementById('study_id').value = id;
            document.getElementById('study_time').value = time;
            document.getElementById('study_activity').value = activity;
            document.getElementById('editModalStudy').style.display = 'flex';
        }

        function closeEdit() {
            document.getElementById('editModalStudy').style.display = 'none';
        }
    </script>

</body>

</html>