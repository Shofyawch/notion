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
   USER MANAGEMENT CRUD
============================================================ */

/* ---- ADD USER ---- */
if (isset($_POST['add_user'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level    = mysqli_real_escape_string($koneksi, $_POST['level']);

    $check = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' OR email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $error = "Username atau email sudah terdaftar!";
    } else {
        mysqli_query(
            $koneksi,
            "INSERT INTO user (nama, username, email, password, level)
             VALUES ('$nama', '$username', '$email', '$password', '$level')"
        ) or die("INSERT ERROR: " . mysqli_error($koneksi));

        header("Location: management.php");
        exit;
    }
}/* ---- DELETE USER ---- */
if (isset($_GET['delete_user'])) {
    $id = intval($_GET['delete_user']);

    mysqli_query(
        $koneksi,
        "DELETE FROM user WHERE id=$id"
    ) or die("DELETE ERROR: " . mysqli_error($koneksi));

    header("Location: management.php");
    exit;
}

/* ---- UPDATE USER ---- */
if (isset($_POST['edit_user'])) {
    $id       = intval($_POST['id']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $level    = mysqli_real_escape_string($koneksi, $_POST['level']);

    mysqli_query(
        $koneksi,
        "UPDATE user SET
            nama     = '$nama',
            username = '$username',
            email    = '$email',
            level    = '$level'
         WHERE id = $id"
    ) or die("UPDATE ERROR: " . mysqli_error($koneksi));

    header("Location: management.php");
    exit;
}

/* ---- CHANGE LEVEL ---- */
if (isset($_POST['change_level'])) {
    $id        = intval($_POST['id']);
    $new_level = mysqli_real_escape_string($koneksi, $_POST['level']);

    mysqli_query(
        $koneksi,
        "UPDATE user SET level = '$new_level' WHERE id = $id"
    ) or die("UPDATE ERROR: " . mysqli_error($koneksi));

    header("Location: management.php");
    exit;
}

/* ---- READ ALL USERS ---- */
$users = mysqli_query(
    $koneksi,
    "SELECT id, nama, username, email, level FROM user ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Student Planner</title>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            background-image: url('bg1.gif');
            background-size: cover;
            background-attachment: fixed;
        }

        .menu-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #61e1ce;
            border: 2px solid #61e1ce;
            padding: 10px 15px;
            font-size: 1.5rem;
            border-radius: 10px;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .menu-btn:hover {
            background-color: #61e1ce;
            color: white;
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            background-color: rgba(188, 228, 255, 0.95);
            color: white;
            position: fixed;
            left: -280px;
            top: 0;
            padding: 30px;
            box-sizing: border-box;
            overflow-y: auto;
            transition: left 0.3s ease;
            z-index: 999;
        }

        .sidebar.active {
            left: 0;
        }

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 998;
        }

        #overlay.active {
            display: block;
        }

        .sidebar h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .sidebar a {
            display: block;
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
            text-decoration: none;
            transition: 0.2s;
            font-weight: 600;
        }

        .sidebar a:hover {
            color: #61e1ce;
            padding-left: 10px;
        }

        .main-content {
            margin-left: 0;
            padding: 40px 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1em;
        }

        .content-box {
            background: white;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 10px 20px rgba(97, 225, 206, 0.2);
        }

        .error-msg {
            background-color: #f8d7da;
            border: 2px solid #ff6b6b;
            color: #721c24;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .success-msg {
            background-color: #d4edda;
            border: 2px solid #61e1ce;
            color: #155724;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .search-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-area input[type="text"] {
            flex: 1;
            min-width: 200px;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 1em;
            font-family: 'Fredoka', sans-serif;
            transition: all 0.3s;
        }

        .search-area input[type="text"]:focus {
            border-color: #61e1ce;
            outline: none;
            box-shadow: 0 0 10px rgba(97, 225, 206, 0.5);
        }

        .add-user-btn {
            background-color: #61e1ce;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            font-family: 'Fredoka', sans-serif;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(97, 225, 206, 0.3);
        }

        .add-user-btn:hover {
            background-color: #3ec8ff;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(62, 200, 255, 0.4);
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .user-table th {
            background-color: #61e1ce;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }

        .user-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        .user-table tbody tr {
            background-color: #fff;
            transition: all 0.3s;
        }

        .user-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-table tbody tr:hover {
            background-color: #f0f9ff;
            box-shadow: inset 0 0 10px rgba(97, 225, 206, 0.2);
        }

        .action-btn {
            padding: 8px 12px;
            margin-right: 8px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9em;
            font-weight: bold;
            color: white;
            transition: all 0.3s;
            font-family: 'Fredoka', sans-serif;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-edit {
            background-color: #ffc107;
            color: #000;
        }

        .btn-delete {
            background-color: #ff6b6b;
        }

        .btn-change-role {
            background-color: #3ec8ff;
        }

        /* MODAL STYLES */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(3px);
        }

        .modal.show {
            display: flex;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: linear-gradient(135deg, #ffffff 0%, #f0fffe 100%);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 450px;
            animation: slideUp 0.4s ease-out;
            border: 2px solid rgba(97, 225, 206, 0.3);
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px dashed #3ec8ff;
            padding-bottom: 15px;
        }

        .modal-header h2 {
            color: #61e1ce;
            font-size: 1.5em;
            margin: 0;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 2em;
            color: #ff6b6b;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .close-btn:hover {
            transform: rotate(90deg);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
            font-size: 0.95em;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 0.95em;
            font-family: 'Fredoka', sans-serif;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #61e1ce;
            outline: none;
            box-shadow: 0 0 10px rgba(97, 225, 206, 0.4);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px dashed #3ec8ff;
        }

        .btn-cancel,
        .btn-submit {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-family: 'Fredoka', sans-serif;
            transition: all 0.3s;
        }

        .btn-cancel {
            background-color: #e0e0e0;
            color: #333;
        }

        .btn-cancel:hover {
            background-color: #d0d0d0;
            transform: translateY(-2px);
        }

        .btn-submit {
            background-color: #61e1ce;
            color: white;
            box-shadow: 0 5px 15px rgba(97, 225, 206, 0.3);
        }

        .btn-submit:hover {
            background-color: #3ec8ff;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(62, 200, 255, 0.4);
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.1em;
        }

        .no-data a {
            color: #3ec8ff;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .no-data a:hover {
            color: #61e1ce;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 20px;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .header h1 {
                font-size: 1.8em;
            }

            .search-area {
                flex-direction: column;
            }

            .search-area input[type="text"],
            .add-user-btn {
                width: 100%;
            }

            .modal-content {
                width: 95%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

    <button class="menu-btn" onclick="toggleSidebar()">☰ Menu</button>
    <div id="overlay" onclick="toggleSidebar()"></div>

    <div id="sidebar" class="sidebar">
        <h2>Menu</h2>
        <a href="dashboard.php" onclick="toggleSidebar()">Dashboard</a>
        <a href="study_planner.php" onclick="toggleSidebar()">Study Planner</a>
        <a href="projectmanager.php" onclick="toggleSidebar()">Project Manager</a>
        <a href="todo.php" onclick="toggleSidebar()">Todo List</a>
        <a href="login.php">Logout</a>
    </div>

    <div class="main-content">

        <div class="header">
            <h1>👥 USER MANAGEMENT</h1>
            <p>Kelola pengguna sistem dengan mudah</p>
        </div>

        <div class="content-box">

            <?php if (isset($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="search-area">
                <input type="text" id="searchInput" placeholder="Cari Nama, Username, Email, atau Level...">
                <button class="add-user-btn" onclick="openAddUserModal()">➕ Tambah User Baru</button>
            </div>

            <?php if (mysqli_num_rows($users) > 0): ?>
                <table class="user-table" id="userTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <?php while ($user = mysqli_fetch_assoc($users)): ?>
                            <tr class="user-row" data-nama="<?= strtolower($user['nama']) ?>" data-username="<?= strtolower($user['username']) ?>" data-email="<?= strtolower($user['email']) ?>" data-level="<?= strtolower($user['level']) ?>">
                                <td><?= htmlspecialchars($user['nama']) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['level']) ?></td>
                                <td>
                                    <button class="action-btn btn-edit" onclick="openEditUserModal(<?= $user['id'] ?>, '<?= htmlspecialchars($user['nama']) ?>', '<?= htmlspecialchars($user['username']) ?>', '<?= htmlspecialchars($user['email']) ?>', '<?= htmlspecialchars($user['level']) ?>')">Edit</button>
                                    <button class="action-btn btn-delete" onclick="if(confirm('Hapus user ini?')) location.href='management.php?delete_user=<?= $user['id'] ?>'">Delete</button>
                                    <button class="action-btn btn-change-role" onclick="openChangeLevelModal(<?= $user['id'] ?>, '<?= htmlspecialchars($user['level']) ?>')">Change Level</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <p>Tidak ada data pengguna. <a href="#" onclick="openAddUserModal(); return false;">Tambah user baru</a></p>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <!-- ===== MODAL ADD USER ===== -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-btn" onclick="closeAddUserModal()">&times;</button>
                <h2>Tambah User Baru</h2>
            </div>

            <form method="POST" onsubmit="return validateAddUserForm()">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="level_add">Level</label>
                    <select id="level_add" name="level" required>
                        <option value="">-- Pilih Level --</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeAddUserModal()">Batal</button>
                    <button type="submit" name="add_user" class="btn-submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL EDIT USER ===== -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-btn" onclick="closeEditUserModal()">&times;</button>
                <h2>Edit User</h2>
            </div>

            <form method="POST" onsubmit="return validateEditUserForm()">
                <input type="hidden" name="id" id="edit_user_id">

                <div class="form-group">
                    <label for="edit_nama">Nama Lengkap</label>
                    <input type="text" id="edit_nama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="edit_username">Username</label>
                    <input type="text" id="edit_username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="edit_email">Email</label>
                    <input type="email" id="edit_email" name="email">
                </div>

                <div class="form-group">
                    <label for="level_edit">Level</label>
                    <select id="level_edit" name="level" required>
                        <option value="">-- Pilih Level --</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditUserModal()">Batal</button>
                    <button type="submit" name="edit_user" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MODAL CHANGE LEVEL ===== -->
    <div id="changeLevelModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-btn" onclick="closeChangeLevelModal()">&times;</button>
                <h2>Ubah Level</h2>
            </div>

            <form method="POST">
                <input type="hidden" name="id" id="change_level_id">

                <div class="form-group">
                    <label for="new_level">Level Baru</label>
                    <select id="new_level" name="level" required>
                        <option value="">-- Pilih Level --</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeChangeLevelModal()">Batal</button>
                    <button type="submit" name="change_level" class="btn-submit">Ubah Level</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Add User Modal
        function openAddUserModal() {
            document.getElementById('addUserModal').classList.add('show');
            document.getElementById('nama').focus();
        }

        function closeAddUserModal() {
            document.getElementById('addUserModal').classList.remove('show');
        }

        // Edit User Modal
        function openEditUserModal(id, nama, username, email, level) {
            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('level_edit').value = level;
            document.getElementById('editUserModal').classList.add('show');
        }

        function closeEditUserModal() {
            document.getElementById('editUserModal').classList.remove('show');
        }

        // Change Level Modal
        function openChangeLevelModal(id, currentLevel) {
            document.getElementById('change_level_id').value = id;
            document.getElementById('new_level').value = currentLevel;
            document.getElementById('changeLevelModal').classList.add('show');
        }

        function closeChangeLevelModal() {
            document.getElementById('changeLevelModal').classList.remove('show');
        }

        // Close modals on background click
        window.onclick = function(event) {
            const addModal = document.getElementById('addUserModal');
            const editModal = document.getElementById('editUserModal');
            const levelModal = document.getElementById('changeLevelModal');

            if (event.target === addModal) {
                closeAddUserModal();
            }
            if (event.target === editModal) {
                closeEditUserModal();
            }
            if (event.target === levelModal) {
                closeChangeLevelModal();
            }
        }

        // Form validation
        function validateAddUserForm() {
            const nama = document.getElementById('nama').value.trim();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const level = document.getElementById('level_add').value;

            if (nama.length < 3) {
                alert('Nama minimal 3 karakter');
                return false;
            }
            if (username.length < 3) {
                alert('Username minimal 3 karakter');
                return false;
            }
            if (password.length < 6) {
                alert('Password minimal 6 karakter');
                return false;
            }
            if (level === '') {
                alert('Pilih level terlebih dahulu');
                return false;
            }
            return true;
        }

        function validateEditUserForm() {
            const nama = document.getElementById('edit_nama').value.trim();
            const username = document.getElementById('edit_username').value.trim();
            const level = document.getElementById('level_edit').value;

            if (nama.length < 3) {
                alert('Nama minimal 3 karakter');
                return false;
            }
            if (username.length < 3) {
                alert('Username minimal 3 karakter');
                return false;
            }
            if (level === '') {
                alert('Pilih level terlebih dahulu');
                return false;
            }
            return true;
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.user-row');

            rows.forEach(row => {
                const nama = row.getAttribute('data-nama');
                const username = row.getAttribute('data-username');
                const email = row.getAttribute('data-email');
                const level = row.getAttribute('data-level');

                if (nama.includes(searchTerm) || username.includes(searchTerm) || email.includes(searchTerm) || level.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>