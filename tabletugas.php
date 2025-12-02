<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Tugas Database</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* CSS SAMA PERSIS SEPERTI SEBELUMNYA */
        body {
            font-family: 'Fredoka', sans-serif;
            background-image: url('bg1.gif'); 
            background-size: cover;    
            background-position: center;  
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            flex-direction: column;
        }

        h1 {
            color: #61e1ce;
            text-shadow: 3px 3px 0px #acfad1;
            font-size: 3rem;
            margin-bottom: 20px;
        }

        /* --- STYLE SIDEBAR GLASSMORPHISM --- */
        .menu-btn {
            position: fixed;
            top: 20px; left: 20px;
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
            background-color: #61e1ce; color: white; border-style: solid;
        }
        .sidebar {
            height: 100%; 
            width: 0; 
            position: fixed; 
            z-index: 2001; 
            top: 0; left: 0;
            
            /* Glassmorphism Effect */
            background-color: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            /* End Glassmorphism */

            overflow-x: hidden; 
            transition: 0.4s;
            padding-top: 60px; 
            white-space: nowrap;
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
            position: absolute; top: 10px; right: 20px; font-size: 2rem;
            color: #ff6b6b; background: none; border: none; cursor: pointer;
            text-shadow: 2px 2px 5px rgba(255,255,255,1);
        }
        .sidebar-title {
            padding: 0 25px 20px; font-size: 1.5rem; color: #3ec8ff;
            font-weight: bold; text-align: center; text-shadow: 2px 2px 0px #fff;
        }
        #overlay {
            position: fixed; display: none; width: 100%; height: 100%;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0,0,0,0.2); z-index: 1999;
            cursor: pointer; backdrop-filter: blur(2px);
        }

        /* Utility Class untuk Margin Kanan Ikon */
        .me-2 {
            margin-right: 0.5rem;
        }
        
        /* --- STYLE FORM & TABLE (Tidak Berubah) --- */
        .form-container {
            background-color: #ffffff; padding: 25px; border-radius: 20px;
            box-shadow: 0px 10px 20px rgba(255, 105, 180, 0.3);
            margin-bottom: 30px; width: 80%; max-width: 900px;
        }
        #form-tugas {
            display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; 
        }
        #form-tugas input, #form-tugas select {
            font-family: 'Fredoka', sans-serif; font-size: 1rem; padding: 12px;
            border: 2px dashed #3ec8ff; border-radius: 10px; flex-grow: 1; 
        }
        #form-tugas input:focus, #form-tugas select:focus {
            outline: none; border-style: solid; border-color: #3ec8ff; box-shadow: 0 0 5px #b6efff; 
        }
        .tambah-btn {
            font-family: 'Fredoka', sans-serif; font-size: 1rem; font-weight: 700;
            background-color: #68c8ed; color: white; padding: 14px 25px;
            border: none; border-radius: 10px; cursor: pointer;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }
        .tambah-btn:hover {
            background-color: #55c0ea; transform: scale(1.05); 
        }
        table {
            width: 80%; max-width: 900px; border-collapse: separate; border-spacing: 0;
            border-radius: 25px; box-shadow: 0px 10px 20px rgba(255, 105, 180, 0.3);
            overflow: hidden; background-color: #ffffff;
        }
        th {
            background-color: #61e1ce; color: white; padding: 20px;
            font-size: 1.2rem; font-weight: 700; text-align: left;
        }
        td {
            padding: 18px 20px; color: #333; border-bottom: 2px dashed #ddd;
        }
        tbody tr:nth-child(even) { background-color: #FFF5FA; }
        tbody tr:hover { background-color: #FFE4E1; cursor: default; }
        tbody tr:last-child td { border-bottom: none; }
        .hapus-btn {
            font-family: 'Fredoka', sans-serif; font-size: 0.9rem;
            background-color: #3ec8ff; color: white; border: none;
            padding: 8px 12px; border-radius: 8px; cursor: pointer;
            transition: transform 0.2s ease;
        }
        .hapus-btn:hover { background-color: #3ec8ff; transform: scale(1.1); }
        
        /* Animasi Kaset */
        #cassette-animation {
            width: 100px; cursor: pointer; position: fixed; bottom: 50px; right: 100px; z-index: 1000; 
        }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .spinning { animation: spin 2s linear infinite; }
    </style>
</head>
<body>

    <button class="menu-btn" onclick="openNav()"><i class="bi bi-list"></i> Menu</button>
    <div id="overlay" onclick="closeNav()"></div>

    <div id="mySidebar" class="sidebar">
        <button class="close-btn" onclick="closeNav()">&times;</button>
        <div class="sidebar-title">Navigasi Tugas</div>
        
        <a href="dashboard.php"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
        <a href="study_planner.php"><i class="bi bi-journal-text me-2"></i> Study Planner</a>
        <a href="calender.php"><i class="bi bi-calendar-event me-2"></i> Kalender</a>
        <a href="projectmanager.php"><i class="bi bi-kanban me-2"></i> Project Manager</a>
        <a href="media.php"><i class="bi bi-images me-2"></i> Media</a>
        <a href="todo.php"><i class="bi bi-check2-square me-2"></i> To Do List</a>
         

        
        <div style="border-top: 1px dashed rgba(0,0,0,0.1); margin: 10px 0;"></div>
        <a href="login.php" style="color:#ff6b6b;"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
    </div>

    <h1> Table Tugas </h1>

    <div class="form-container">
        <form id="form-tugas">
            <input type="text" id="input-mapel" placeholder="Mata Pelajaran" required>
            <input type="text" id="input-detail" placeholder="Detail Tugas" required>
            <input type="text" id="input-deadline" placeholder="Deadline (cth: Jumat, 21 Nov)" required>
            <select id="input-status" required>
                <option value="Belum ❌">Belum ❌</option>
                <option value="Proses... ">Proses... </option>
                <option value="Selesai ✅">Selesai ✅</option>
            </select>
            <button type="submit" class="tambah-btn">Tambah Tugas!</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Detail Tugas</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="isi-tabel">
             </tbody>
    </table>

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
        // --- LOGIKA SIDEBAR ---
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("overlay").style.display = "block";
        }
        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("overlay").style.display = "none";
        }

        const formTugas = document.getElementById('form-tugas');
        const isiTabel = document.getElementById('isi-tabel');

        // --- FUNGSI UNTUK MERENDER TABEL (TIDAK LAGI HARDCODE) ---
        function renderTugas(id, mapel, detail, deadline, status) {
            const barisBaru = document.createElement('tr');
            // Menyimpan ID database di attribute data-id
            barisBaru.setAttribute('data-id', id);

            const selMapel = document.createElement('td');
            selMapel.textContent = mapel;
            barisBaru.appendChild(selMapel);

            const selDetail = document.createElement('td');
            selDetail.textContent = detail;
            barisBaru.appendChild(selDetail);

            const selDeadline = document.createElement('td');
            selDeadline.textContent = deadline;
            barisBaru.appendChild(selDeadline);

            const selStatus = document.createElement('td');
            selStatus.textContent = status;
            barisBaru.appendChild(selStatus);

            const selAksi = document.createElement('td');
            const tombolHapus = document.createElement('button');
            tombolHapus.textContent = 'Hapus';
            tombolHapus.className = 'hapus-btn';

            // EVENT HAPUS MENGHUBUNGI DATABASE
            tombolHapus.addEventListener('click', function() {
                hapusTugasKeDB(id, barisBaru);
            });

            selAksi.appendChild(tombolHapus);
            barisBaru.appendChild(selAksi);
            isiTabel.appendChild(barisBaru);
        }

        // --- 1. LOAD DATA DARI DATABASE SAAT HALAMAN DIBUKA ---
        document.addEventListener("DOMContentLoaded", function() {
            fetch('ambil_data.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(tugas => {
                    renderTugas(tugas.id, tugas.mapel, tugas.detail, tugas.deadline, tugas.status);
                });
            })
            .catch(error => console.error('Error:', error));

            // Logika Musik
            setupMusicPlayer();
        });

        // --- 2. TAMBAH TUGAS KE DATABASE ---
        formTugas.addEventListener('submit', function(event) {
            event.preventDefault();

            const mapel = document.getElementById('input-mapel').value;
            const detail = document.getElementById('input-detail').value;
            const deadline = document.getElementById('input-deadline').value;
            const status = document.getElementById('input-status').value;

            // Buat FormData untuk dikirim ke PHP
            const formData = new FormData();
            formData.append('mapel', mapel);
            formData.append('detail', detail);
            formData.append('deadline', deadline);
            formData.append('status', status);

            fetch('tambah_tugas.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(newId => {
                if(newId !== "Error") {
                    // Jika sukses, render ke tabel tanpa refresh
                    renderTugas(newId, mapel, detail, deadline, status);
                    formTugas.reset();
                } else {
                    alert("Gagal menambah data ke database");
                }
            });
        });

        // --- 3. HAPUS TUGAS DARI DATABASE ---
        function hapusTugasKeDB(id, elemenBaris) {
            const formData = new FormData();
            formData.append('id', id);

            fetch('hapus_tugas.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                if(result === "Sukses") {
                    elemenBaris.remove();
                } else {
                    alert("Gagal menghapus data");
                }
            });
        }

        // --- SETUP MUSIK ---
        function setupMusicPlayer() {
            const audioPlayer = document.getElementById('audio-player');
            const cassetteImg = document.getElementById('cassette-animation');
            
            cassetteImg.addEventListener('click', () => {
                if (audioPlayer.paused) {
                    audioPlayer.play(); 
                } else {
                    audioPlayer.pause(); 
                }
            });
            audioPlayer.addEventListener('play', () => cassetteImg.classList.add('spinning'));
            audioPlayer.addEventListener('pause', () => cassetteImg.classList.remove('spinning'));
            audioPlayer.addEventListener('ended', () => cassetteImg.classList.remove('spinning'));
        }

    </script>

</body>
</html>