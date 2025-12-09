<?php
include "koneksi.php";

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
$id_user = $_SESSION['id'];

$user_id = $_SESSION['id'];

$notes = mysqli_query($koneksi,
    "SELECT * FROM notes WHERE id='$user_id' ORDER BY created_at DESC"
);

$tasks = mysqli_query($koneksi,
    "SELECT * FROM tasks WHERE id='$user_id' ORDER BY created_at DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Page :</title>

    <style>
        body {
            font-family: "Arial", sans-serif;
            background: #00bfff25;
            margin: 0;
            padding: 20px;
        }

        h1 {
            font-weight: 600;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .sub {
            font-size: 14px;
            padding: 10px;
            background: #fff8d6;
            border-radius: 60px;
            display: inline-block;
        }

        .container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 25px;
            margin-top: 20px;
        }

        /* To-do */
        .todo-box {
            background: #ffc1c2;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .todo-box h2 {
            margin-top: 0;
            font-size: 20px;
        }

        .todo-box input[type="checkbox"] {
            margin-right: 6px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee;
            cursor: pointer;
            transition: 0.3s;
        }

        .card img {
            width: 100%;
            height: 130px;
            object-fit: cover;
        }

        .card div {
            padding: 10px;
            font-size: 18px;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .notes {
            margin-top: 25px;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .calendar {
            margin-top: 25px;
            padding: 15px;
            background: #fafafa;
            border-radius: 10px;
            border: 1px solid #eee;
        }
    </style>
</head>

<body>

<b><span style="font-size: 20px">Welcome to 𓇼</span></b>
<h1>my page :</h1>
<div class="sub">loading . . . . . . . . . . . . . . . . . .</div>

<div class="container">

    <div class="todo-box">
        <h2>today’s tasks ;</h2>

        <form action="add_task.php" method="POST" style="margin-bottom:10px;">
            <input type="text" name="task_text" placeholder="Add new task..." required
                style="width: 90%; padding: 8px; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 6px;">
            <button type="submit"
                style="padding: 6px 12px; border: none; border-radius: 6px; background: #ff8a8a; cursor: pointer; font-weight: bold;">
                Add Task
            </button>
        </form>

        <?php while($t = mysqli_fetch_assoc($tasks)) { ?>
            <label>
                <input type="checkbox" <?= $t['is_done'] ? 'checked' : '' ?>>
                <?= $t['task_text'] ?>
            </label><br>
        <?php } ?>
    </div>

    <div>

        <h2>navigation ଳ</h2>

        <div class="grid">
    <div class="card">
        <a href="todo.php">
            <img src="107958.gif">
            <div>📝 to do list ,!</div>
        </a>
    </div>

    <div class="card">
        <a href="media.php">
            <img src="icegif-6415.gif">
            <div>🍀 media ,!</div>
        </a>
    </div>

    <div class="card">
        <a href="study_planner.php">
            <img src="We17sl.gif">
            <div>✏️ Study / Goals planner ,!</div>
        </a>
    </div>

    <div class="card">
        <a href="projectmanager.php">
            <img src="eb33b949c8da70c163f3e5e99e441947.gif">
            <div>📒 project manager ,!</div>
        </a>
    </div>
</div>


        <div class="notes">
            <h2>notes 🗒️</h2>

            <form action="note_add.php" method="POST"> 
                <textarea name="note" required style="width: 100%; height: 120px; border-radius: 10px; border: 1px solid #ddd; padding: 10px; font-size: 15px;" placeholder="Write your notes here...">

                </textarea> <button type="submit" style="margin-top: 10px; padding: 8px 15px; border-radius: 8px; background: #ffd447; border: none; cursor: pointer; font-weight: bold;"> 
                    Save note </button>
            </form>


            <hr style="margin: 15px 0">

            
        </div>

        <div class="calendar">
            <a href="calender.php"><h2>calendar 📅</h2></a>
            <input type="date"
                style="padding: 8px; font-size: 16px; border-radius: 6px; border: 1px solid #ddd;">
        </div>

    </div>

</div>

</body>
</html>
