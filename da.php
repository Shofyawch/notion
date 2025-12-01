<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['level'] !== 'admin') {
    echo "<script>alert('Anda tidak punya akses ke halaman admin!');</script>";
    header("Location: dashboard.php"); // pindahin ke dashboard user biasa
    exit;
}

$nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lautan Informasi</title>
    <!-- Memuat Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
   
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ghibli-water': '#E0F7FA', 
                        'ghibli-deep-sea': '#006064', 
                        'ghibli-coral': '#FF7043', 
                        'ghibli-sand': '#FFF8E1', 
                        'ghibli-kelp': '#4CAF50', 
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
           
            background-image: url('da.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat;
            background-attachment: fixed; 
            background-position: center center;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

 
        .metric-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

       
        .action-button {
            transition: all 0.2s;
            background-color: #FF7043; 
            color: white;
            border: 2px solid #FF7043;
        }
        .action-button:hover {
            background-color: #E64A19; 
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(255, 112, 67, 0.5);
        }
        
        
        .kucing-placeholder {
            width: 100%;
            height: 100%;
            object-fit: contain; 
        }
    </style>
</head>
<body class="p-4 md:p-8">
    <div class="max-w-6xl mx-auto bg-ghibli-sand rounded-3xl p-6 md:p-10 shadow-2xl border-4 border-ghibli-deep-sea">
        
     
        <header class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-ghibli-deep-sea mb-2">
                <span class="inline-block transform -rotate-6">🐟</span> DASHBOARD ADMIN
            </h1>
            <p class="text-ghibli-deep-sea/80 text-lg">
                Jelajahi Lautan Informasi Administrasi Anda
            </p>
        </header>

      
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            
    
            <div class="metric-card bg-white p-6 rounded-2xl border-l-8 border-ghibli-coral">
                <div class="flex items-center space-x-4">
                    <span class="text-4xl text-ghibli-coral">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Pengguna</p>
                        <p class="text-3xl font-bold text-ghibli-deep-sea" id="totalUsers">128</p>
                    </div>
                </div>
            </div>

          
            <div class="metric-card bg-white p-6 rounded-2xl border-l-8 border-ghibli-kelp">
                <div class="flex items-center space-x-4">
                    <span class="text-4xl text-ghibli-kelp">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zm3 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 14a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z"></path></svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Catatan</p>
                        <p class="text-3xl font-bold text-ghibli-deep-sea" id="totalNotes">450</p>
                    </div>
                </div>
            </div>

         
            <div class="metric-card bg-white p-6 rounded-2xl border-l-8 border-ghibli-deep-sea">
                <div class="flex items-center space-x-4">
                    <span class="text-4xl text-ghibli-deep-sea">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM6 10a1 1 0 000 2h8a1 1 0 100-2H6zM4 14a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z"></path></svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Project</p>
                        <p class="text-3xl font-bold text-ghibli-deep-sea" id="totalProjects">92</p>
                    </div>
                </div>
            </div>
        </div>

      
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-lg border border-ghibli-water">
                <h2 class="text-2xl font-semibold text-ghibli-deep-sea border-b pb-3 mb-4 flex items-center">
                    <span class="mr-2 text-ghibli-coral">⭐</span> Aktivitas Terakhir
                </h2>
                <ul class="space-y-3" id="recentActivities">
                
                    <li class="p-3 bg-ghibli-water/50 rounded-lg flex justify-between items-center text-ghibli-deep-sea/90">
                        <span>User A membuat project baru: "Peta Harta Karun"</span>
                        <span class="text-xs text-gray-500">5 menit lalu</span>
                    </li>
                    <li class="p-3 bg-ghibli-water/50 rounded-lg flex justify-between items-center text-ghibli-deep-sea/90">
                        <span>User B mengubah Study Planner: "Jadwal Belajar Biologi"</span>
                        <span class="text-xs text-gray-500">1 jam lalu</span>
                    </li>
                    <li class="p-3 bg-ghibli-water/50 rounded-lg flex justify-between items-center text-ghibli-deep-sea/90">
                        <span>User C menambah Note baru: "Resep Ramen Ponyo"</span>
                        <span class="text-xs text-gray-500">4 jam lalu</span>
                    </li>
                    <li class="p-3 bg-ghibli-water/50 rounded-lg flex justify-between items-center text-ghibli-deep-sea/90">
                        <span>User D mengedit profil</span>
                        <span class="text-xs text-gray-500">1 hari lalu</span>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-lg border border-ghibli-water">
                <h2 class="text-2xl font-semibold text-ghibli-deep-sea border-b pb-3 mb-4 flex items-center">
                    <span class="mr-2 text-ghibli-coral">🚀</span> Aksi Cepat
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <button class="action-button p-4 rounded-xl font-bold text-sm shadow-md">
                        <span class="block mb-1">🧑‍💻</span> Kelola Pengguna
                    </button>
                    <button class="action-button p-4 rounded-xl font-bold text-sm shadow-md">
                        <span class="block mb-1">📝</span> Kelola Konten
                    </button>
                    <button class="action-button p-4 rounded-xl font-bold text-sm shadow-md">
                        <span class="block mb-1">⚙️</span> Pengaturan
                    </button>
                    <button class="action-button p-4 rounded-xl font-bold text-sm shadow-md">
                        <span class="block mb-1">🗄️</span> Database
                    </button>
                </div>
                
               
                <div class="mt-8">

                    
                    
                        <img src="kucing.jpg" alt="Gambar Kucing Pengawas" class="kucing-placeholder">
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script>
        function showConsoleMessage(message) {
            console.log("Pesan Dashboard: " + message);
            const notificationArea = document.createElement('div');
            notificationArea.className = 'fixed bottom-4 right-4 bg-ghibli-deep-sea text-white p-3 rounded-xl shadow-xl z-50 transition-opacity duration-300';
            notificationArea.textContent = message;
            document.body.appendChild(notificationArea);
            setTimeout(() => {
                notificationArea.style.opacity = '0';
                setTimeout(() => notificationArea.remove(), 300);
            }, 3000);
        }

        document.querySelectorAll('.action-button').forEach(button => {
            button.addEventListener('click', () => {
                const actionText = button.textContent.trim().split('\n').pop().trim();
                showConsoleMessage(`Aksi "${actionText}" diklik. Mengarahkan ke halaman terkait...`);
            });
        });

        window.onload = () => {
            const usersElement = document.getElementById('totalUsers');
            let currentUsers = parseInt(usersElement.textContent);
            

            const targetUsers = currentUsers + Math.floor(Math.random() * 20); // Tambah 0-19
            let count = currentUsers;
            
            const interval = setInterval(() => {
                count++;
                usersElement.textContent = count;
                if (count >= targetUsers) {
                    clearInterval(interval);
                    usersElement.textContent = targetUsers;
                }
            }, 50);
        };
    </script>
</body>
</html>