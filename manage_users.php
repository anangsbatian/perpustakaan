<?php
include 'proses.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <ul>
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="manage_books.php">Manage Books</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="history.php">History</a></li>
            <li><a href="guide.php">Guide</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header-container">
            <h2>Daftar siswa</h2>

        </div>
            <!-- Tabel ditempatkan di bawah tulisan "Daftar Siswa" -->
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Grade</th>
                    <th>Password</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['id']) ?></td>
                        <td><?= htmlspecialchars($student['username']) ?></td>
                        <td><?= htmlspecialchars($student['grade']) ?></td>
                        <td><?= mb_strimwidth (htmlspecialchars($student['password']), 0 ,10, "...") ?></td>
                        <td>
                            <button class='fa-solid fa-pen-to-square' 
                                onclick='openPopup(<?= json_encode($student, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                            </button>
                            <a href="?action=delete&id=<?= $student['id'] ?>" onclick="return confirm('Hapus siswa ini?')">
                                <button class='fa-solid fa-trash'></button>
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
            <!-- Popup Edit -->
            <!-- Popup Edit -->
            <div id="popup" class="popup-container">
                <div class="popup-content">
                    <h3>Edit Siswa</h3>
                    <form method="POST" action="">
                        <input type="hidden" name="id" id="edit-id">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="edit-username" required>
                        <label for="grade">Grade:</label>
                        <input type="text" name="grade" id="edit-grade" required>
                        <label for="password">Password (biarkan kosong jika tidak ingin mengubah):</label>
                        <input type="password" name="password" id="edit-password">
                        <button type="submit" name="update">Update</button>
                        <button type="button" onclick="closePopup()">Batal</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script src="script2.js"></script>

</body>
</html>