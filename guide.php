<?php
include 'proses.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Admin</title>
    <link rel="stylesheet" href="style3.css">
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
    <div class="guide">
        <header>
            <h1>Panduan Penggunaan Sistem Perpustakaan</h1>
        
        <main>
            <section>
                <h2>1. Login Admin</h2>
                <p>Admin dapat login menggunakan username dan password yang telah diberikan.</p>
            </section>
            <section>
                <h2>2. Mengelola Buku</h2>
                <ul>
                    <li><strong>Menambah Buku:</strong> Masuk ke menu "Kelola Buku" dan isi informasi buku baru.</li>
                    <li><strong>Mengedit Buku:</strong> Klik tombol "Edit" pada buku yang ingin diperbarui.</li>
                    <li><strong>Menghapus Buku:</strong> Klik tombol "Hapus" untuk menghapus buku dari sistem.</li>
                </ul>
            </section>
            <section>
                <h2>3. Mengelola Pengguna</h2>
                <ul>
                    <li><strong>Menambah Siswa:</strong> Masuk ke menu "Kelola Siswa" dan isi informasi siswa baru.</li>
                    <li><strong>Mengedit Siswa:</strong> Klik tombol "Edit" untuk memperbarui data siswa.</li>
                    <li><strong>Menghapus Siswa:</strong> Klik tombol "Hapus" untuk menghapus akun siswa.</li>
                </ul>
            </section>
            <section>
                <h2>4. Mengelola Peminjaman</h2>
                <ul>
                    <li><strong>Melihat Status Peminjaman:</strong> Masuk ke menu "Peminjaman" untuk melihat daftar buku yang dipinjam.</li>
                    <li><strong>Menyetujui Peminjaman:</strong> Klik tombol "Setujui" untuk menyetujui peminjaman.</li>
                    <li><strong>Mengembalikan Buku:</strong> Klik tombol "Kembalikan" untuk memperbarui status buku.</li>
                </ul>
            </section>
            <section>
                <h2>5. Logout</h2>
                <p>Untuk keluar dari sistem, klik tombol "Logout" di pojok kiri bawah.</p>
            </section>
        </main>
        <footer>
            <p>&copy; WidyaKirana Elementary School</p>
        </footer>
        </header>
    </div>
    <div class="motivation-container">
        <div class="motivation-text">
            <span>You're doing great!</span>
            <span>Keep it up!</span>
            <span>Believe in yourself!</span>
            <span>Stay positive!</span>
            <span>😊</span>
        </div>
    </div>
</body>
</html>