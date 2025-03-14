<?php
include 'proses.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

<div class="dashboard-container">
    <div class="dashboard-card blue-box">
        <h3>Jumlah Peminjam</h3>
        <p style="font-size: 24px; font-weight: bold;"><?= $total_peminjam; ?></p>
    </div>
    <div class="dashboard-card red-box">
        <h3>Jumlah Siswa</h3>
        <p style="font-size: 24px; font-weight: bold;"><?= $total_siswa; ?></p>
    </div>
    <div class="dashboard-card green-box">
    <h3>Total Peminjaman</h3>
    <p style="font-size: 24px; font-weight: bold;"><?= $total_peminjaman; ?></p>
</div>
</div>



</body>
</html>
