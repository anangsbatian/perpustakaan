<?php
include 'proses.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Peminjaman</title>
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

    <div class="main-content">
        <div class="header-container">
            <h2>Daftar Peminjam</h2>
            <form action="download_excel.php" method="GET">
                <label for="bulan">Pilih Bulan:</label>
                <input type="month" id="bulan" name="bulan" required>
                <button type="submit">Download Excel</button>
            </form>

        </div>

        <div class="table-container">
            <table border="1">
                <thead>
                <tr>
                    <th>ID Peminjaman</th>
                    <th>Nama Siswa</th>
                    <th>Grade</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Deadline</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status</th>
                    <th>Keterangan</th> <!-- Tambahkan kolom Keterangan -->
                </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['grade']); ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo $row['borrow_date']; ?></td>
                            <td><?php echo $row['due_date']; ?></td>
                            <td><?php echo ($row['return_date'] ? $row['return_date'] : "-"); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <?php
                                if ($row['status'] === 'Dikembalikan' && $row['return_date'] > $row['due_date']) {
                                    echo "Terlambat";
                                } elseif ($row['status'] === 'Dikembalikan') {
                                    echo "Tepat Waktu";
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>