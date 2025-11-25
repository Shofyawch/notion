<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Database</title>

    <style>
        /* --- STYLE SAMA SEPERTI SEBELUMNYA (Saya persingkat agar fokus ke logika) --- */
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One&family=M+PLUS+Rounded+1c:wght@700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&display=swap'); 

        body {
            margin: 0;
            font-family: 'M PLUS Rounded 1c', sans-serif;
            background-image: url('bg2.gif'); /* Pastikan file ada */
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
        
        /* ... (Copy paste style CSS kamu yang sebelumnya di sini) ... */
        /* Agar tidak terlalu panjang, saya menggunakan style penting saja di sini */
        
        .menu-btn { position: fixed; top: 20px; left: 20px; background-color: rgba(255,255,255,0.8); color: #ff1493; border: 2px dashed #ff1493; padding: 10px 15px; font-size: 1.5rem; border-radius: 10px; cursor: pointer; z-index: 2000; font-family: 'Fredoka One'; }
        .sidebar { height: 100%; width: 0; position: fixed; z-index: 2001; top: 0; left: 0; background-color: rgba(255,255,255,0.85); backdrop-filter: blur(10px); overflow-x: hidden; transition: 0.4s; padding-top: 60px; box-shadow: 5px 0 15px rgba(0,0,0,0.1); }
        .sidebar a { padding: 15px 25px; text-decoration: none; font-size: 1.2rem; color: #333; display: block; transition: 0.3s; font-family: 'Fredoka'; }
        .sidebar a:hover { background-color: pink; color: white; }
        .sidebar .close-btn { position: absolute; top: 10px; right: 25px; font-size: 36px; margin-left: 50px; background: none; border: none; color: #ff1493; cursor: pointer; }
        #overlay { position: fixed; display: none; width: 100%; height: 100%; top: 0; left: 0; background-color: rgba(0,0,0,0.5); z-index: 1999; }

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

    <button class="menu-btn" onclick="openNav()">☰ Menu</button>
    <div id="overlay" onclick="closeNav()"></div>

    <div id="mySidebar" class="sidebar">
        <button class="close-btn" onclick="closeNav()">&times;</button>
        <a href="dahsboard.php">Dashboard</a>
        <a href="tabletugas.php">Table Tugas</a>
        <a href="studyplanner.html">Study Planner</a>
        <a href="projectmanager.php">Project Manager</a>
        <a href="media.html">Media</a>
        <a href="login.php">Login</a>
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
