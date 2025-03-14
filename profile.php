<?php
session_start();

date_default_timezone_set('Asia/Jakarta');

$conn = new mysqli("localhost", "root", "", "perpustakaan1");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data pengguna dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "Pengguna tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-header h2 {
            margin: 10px 0 5px;
        }
        .profile-header p {
            color: #666;
            font-size: 14px;
        }
        .profile-details {
            margin-top: 20px;
        }
        .profile-details .detail {
            margin-bottom: 15px;
        }
        .profile-details .detail label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .profile-details .detail span {
            color: #333;
        }
        .logout-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .logout-btn a {
            text-decoration: none;
            color: #fff;
            background: #ff4d4d;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .logout-btn a:hover {
            background: #e60000;
        }
        .navbar-brand .logo {
            width: 50px; /* Atur ukuran logo sesuai kebutuhan */
            height: auto;
        }
        .navbar-brand div {
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }
        .navbar-brand span {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .navbar-brand small {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid ">
        <a class="navbar-brand" href="landing.php">
                <img src="asset/logo/logo.png" alt="Logo" class="logo">
                <div>
                    <span>PERPUSTAKAAN</span><br>
                    <small style="font-size: 1rem;">SD Widya Kirana</small>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'landing.php' ? 'active' : '' ?>" href="landing.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'book.php' ? 'active' : '' ?>" href="book.php">Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'my_loans.php' ? 'active' : '' ?>" href="my_loans.php">Pengembalian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>" href="profile.php">Profil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="profile-container" style="margin-top: 120px;">
        <div class="profile-details">
            <div class="detail">
                <label>Username:</label>
                <span><?= htmlspecialchars($user['username']) ?></span>
            </div>
            <div class="detail">
                <label>Role:</label>
                <span><?= htmlspecialchars($user['role']) ?></span>
            </div>
            <div class="detail">
                <label>Grade:</label>
                <span><?= htmlspecialchars($user['grade']) ?></span>
            </div>
            <div class="detail">
                <label>No Induk:</label>
                <span><?= htmlspecialchars($user['no_induk']) ?></span>
            </div>
            <div class="logout-btn" style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                <a href="logout.php" style="background: #ff4d4d;">Logout</a>
                <a href="book.php" style="background: #007bff;">Kembali</a>
            </div>
    </div>
</body>
</html>