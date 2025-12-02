<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Database</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=M+PLUS+Rounded+1c:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&display=swap" rel="stylesheet"> 
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* --- STYLE SAMA SEPERTI SEBELUMNYA (Saya persingkat agar fokus ke logika) --- */
        
        body {
            margin: 0;
            font-family: 'M PLUS Rounded 1c', sans-serif;
            background-image: url('bg2.gif'); /* Pastikan file ada */
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
        
        /* --- STYLE SIDEBAR GLASSMORPHISM --- */
        .menu-btn { 
            position: fixed; top: 20px; left: 20px; 
            background-color: rgba(255,255,255,0.8); 
            color: #ff1493; 
            border: 2px dashed #ff1493; 
            padding: 10px 15px; 
            font-size: 1.5rem; 
            border-radius: 10px; 
            cursor: pointer; 
            z-index: 2000; 
            font-family: 'Fredoka One'; 
            transition: 0.3s;
            box-shadow: 0px 5px 10px rgba(0,0,0,0.1);
        }
        .menu-btn:hover { background-color: #ff1493; color: white; border-style: solid; }

        .sidebar { 
            height: 100%; width: 0; position: fixed; z-index: 2001; top: 0; left: 0; 
            /* Glassmorphism Effect */
            background-color: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
            /* End Glassmorphism */
            overflow-x: hidden; transition: 0.4s; padding-top: 60px; 
            box-shadow: 5px 0 15px rgba(0,0,0,0.1);
            white-space: nowrap;
        }
        .sidebar a { 
            padding: 15px 25px; 
            text-decoration: none; 
            font-size: 1.2rem; 
            color: #333; 
            display: block; 
            transition: 0.3s; 
            font-family: 'Fredoka'; 
            font-weight: 700;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.5);
            text-shadow: 0px 0px 2px rgba(255,255,255,0.8);
        }
        .sidebar a:hover { 
            background-color: rgba(255, 192, 203, 0.5); /* Pink semi-transparan */
            color: #ff1493; 
            padding-left: 35px;
        }
        .sidebar .close-btn { 
            position: absolute; top: 10px; right: 20px; font-size: 2rem;
            color: #ff1493; background: none; border: none; cursor: pointer;
            text-shadow: 2px 2px 5px rgba(255,255,255,1);
        }
        .sidebar-title {
            padding: 0 25px 20px; font-size: 1.5rem; color: #ff69b4;
            font-weight: bold; text-align: center; text-shadow: 2px 2px 0px #fff;
        }
        #overlay { position: fixed; display: none; width: 100%; height: 100%; top: 0; left: 0; background-color: rgba(0,0,0,0.2); z-index: 1999; backdrop-filter: blur(2px); cursor: pointer; }

        /* Utility Class untuk Margin Kanan Ikon */
        .me-2 { margin-right: 0.5rem; }

        /* --- KALENDER & Konten Lain (Tidak Berubah) --- */
        .main-content { display: flex; flex-direction: column; align-items: center; padding-top: 80px; min-height: 100vh; }
        .calendar-header { display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #ffc0cb; border-radius: 15px; border: 4px solid #333; width: 90%; max-width: 800px; margin-bottom: 20px; }
        .calendar-header h2 { font-family: 'Fredoka One'; color: #ff1493; margin: 0; text-shadow: 2px 2px 0 #fff; }
        .calendar-header button { background: white; border: 3px solid #ff69b4; border-radius: 50%; width: 50px; height: 50px; font-weight: bold; cursor: pointer; font-size: 1.2rem; color: #ff69b4; }
        
        .calendar-container { width: 90%; max-width: 800px; background: rgba(255,255,255,0.9); border: 4px solid #333; border-radius: 15px; padding: 20px; box-shadow: 10px 10px 0 rgba(0,0,0,0.2); }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 2px solid #333; width: 14.28%; vertical-align: top; height: 100px; padding: 5px; }
        th { background: #ffe6f2; font-family: 'Fredoka One'; color: #444; }
        td:hover:not(.empty) { background-color: #fff0f5; cursor: pointer; }
        .date-number { font-size: 1.2em; font-weight: bold; }
        
        /* Note styling */
        .note { margin-top: 5px; font-size: 0.85em; color: #d946ef; font-weight: bold; background: rgba(255, 192, 203, 0.3); padding: 2px; border-radius: 4px; }
        .empty { background-color: #eee; }

        #cassette-animation { width: 80px; position: fixed; bottom: 30px; right: 30px; cursor: pointer; }
        .spinning { animation: spin 2s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

    <button class="menu-btn" onclick="openNav()"><i class="bi bi-list"></i> Menu</button>
    <div id="overlay" onclick="closeNav()"></div>

    <div id="mySidebar" class="sidebar">
        <button class="close-btn" onclick="closeNav()">&times;</button>
        <div class="sidebar-title">Navigasi Kalender</div>
        <a href="Dashboard.php"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
        <a href="todo.php"><i class="bi bi-check2-square me-2"></i> To Do List</a>
        <a href="tabletugas.php"><i class="bi bi-table me-2"></i> Table Tugas</a>
        <a href="study_planner.php"><i class="bi bi-journal-text me-2"></i> Study Planner</a>
        <a href="projectmanager.php"><i class="bi bi-kanban me-2"></i> Project Manager</a>
        <a href="media.php"><i class="bi bi-images me-2"></i> Media</a>
      

        
        <div style="border-top: 1px dashed rgba(0,0,0,0.1); margin: 10px 0;"></div>
        <a href="login.php" style="color:#ff1493;"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="calendar-header">
            <button id="prevMonth">&lt;</button>
            <h2 id="monthYear"></h2>
            <button id="nextMonth">&gt;</button>
        </div>

        <div class="calendar-container">
            <table class="calendar-grid">
                <thead>
                    <tr>
                        <th>SUN</th><th>MON</th><th>TUE</th><th>WED</th><th>THU</th><th>FRI</th><th>SAT</th>
                    </tr>
                </thead>
                <tbody id="calendarBody"></tbody>
            </table>
        </div>
    </div>

    <img id="cassette-animation" src="music.png" alt="Music">
    <audio id="audio-player" loop>
        <source src="Nandemonaiya - movie ver..mp3" type="audio/mpeg">
    </audio>

    <script>
        // --- SIDEBAR (Tetap sama) ---
        function openNav() {
            document.getElementById("mySidebar").style.width = "280px";
            document.getElementById("overlay").style.display = "block";
        }
        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("overlay").style.display = "none";
        }

        // --- LOGIKA KALENDER ---
        const monthYearEl = document.getElementById('monthYear');
        const calendarBody = document.getElementById('calendarBody');
        const prevBtn = document.getElementById('prevMonth');
        const nextBtn = document.getElementById('nextMonth');

        let currentDate = new Date();
        let eventsData = {}; // Data event

        // 1. Render Kalender (Fungsi Utama)
        function renderCalendar() {
            calendarBody.innerHTML = ''; // Bersihkan isi lama

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            // Set Header (Bulan & Tahun)
            monthYearEl.textContent = `${currentDate.toLocaleString('id-ID', { month: 'long' })} ${year}`;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            let date = 1;
            // Format bulan jadi 2 digit (01, 02, dst)
            const formattedMonth = String(month + 1).padStart(2, '0');

            for (let i = 0; i < 6; i++) {
                let row = document.createElement('tr');
                let hasDate = false;

                for (let j = 0; j < 7; j++) {
                    let cell = document.createElement('td');

                    if (i === 0 && j < firstDay) {
                        cell.classList.add('empty');
                    } else if (date > daysInMonth) {
                        cell.classList.add('empty');
                    } else {
                        hasDate = true;
                        
                        const formattedDate = String(date).padStart(2, '0');
                        const fullDateStr = `${year}-${formattedMonth}-${formattedDate}`;

                        let dateNum = document.createElement('div');
                        dateNum.classList.add('date-number');
                        dateNum.textContent = date;
                        cell.appendChild(dateNum);

                        // Cek Note dari database
                        let noteContent = eventsData[fullDateStr] || ""; 
                        
                        let noteDiv = document.createElement('div');
                        noteDiv.classList.add('note');
                        noteDiv.textContent = noteContent;
                        cell.appendChild(noteDiv);

                        cell.addEventListener('click', () => {
                            const newNote = prompt(`Catatan untuk ${date}-${formattedMonth}-${year}:`, noteContent);
                            if (newNote !== null) {
                                saveEvent(fullDateStr, newNote);
                                noteDiv.textContent = newNote; // Update tampilan langsung
                                eventsData[fullDateStr] = newNote; // Update memori lokal
                            }
                        });

                        date++;
                    }
                    row.appendChild(cell);
                }

                if(hasDate || date <= daysInMonth) {
                    calendarBody.appendChild(row);
                }
                if (date > daysInMonth) break;
            }
        }

        // 2. Fetch Data (Ambil dari PHP)
        async function fetchEvents() {
            try {
                const response = await fetch('get_events.php');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                eventsData = await response.json();
                console.log("Data berhasil diambil:", eventsData);
                renderCalendar(); // Gambar ulang setelah data masuk
            } catch (error) {
                console.error('Gagal mengambil data (Cek Console):', error);
                // PENTING: Tetap gambar kalender meski database error
                renderCalendar(); 
            }
        }

        // 3. Save Data (Kirim ke PHP)
        async function saveEvent(dateStr, noteText) {
            try {
                const response = await fetch('save_event.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ date: dateStr, note: noteText })
                });
                const result = await response.json();
                console.log("Simpan status:", result);
            } catch (error) {
                console.error('Gagal menyimpan:', error);
                alert("Gagal menyimpan ke database. Cek koneksi!");
            }
        }

        // Event Listener Tombol
        prevBtn.onclick = () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        };

        nextBtn.onclick = () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        };

        // --- EKSEKUSI AWAL ---
        // Panggil renderCalendar DULUAN agar tampilan tidak kosong
        renderCalendar();
        // Baru panggil fetchEvents untuk update data
        fetchEvents();


        // --- AUDIO ---
        const audioPlayer = document.getElementById('audio-player');
        const cassetteImg = document.getElementById('cassette-animation');

        cassetteImg.addEventListener('click', () => {
            if (audioPlayer.paused) audioPlayer.play();
            else audioPlayer.pause();
        });

        audioPlayer.addEventListener('play', () => cassetteImg.classList.add('spinning'));
        audioPlayer.addEventListener('pause', () => cassetteImg.classList.remove('spinning'));
    </script>

</body>
</html>
