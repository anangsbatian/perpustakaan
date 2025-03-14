<?php
include 'proses_siswa.php'; // Include your database connection file

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perpustakaan1"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all books
$sql = "SELECT * FROM books"; // Replace 'books' with your table name
$result = $conn->query($sql);
$allBooks = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semua Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5; /* Warna latar belakang yang lebih elegan */
            font-family: 'Arial', sans-serif; /* Font yang lebih modern */
        }
        .card {
            margin: 10px auto;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #ffffff; /* Warna latar belakang kartu */
        }
        .card img {
            height: 250px;
            object-fit: cover;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .navbar-brand .logo {
            width: 50px; /* Atur ukuran logo sesuai kebutuhan */
            height: auto;
        }
        .navbar-brand span {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .navbar-brand small {
            font-size: 0.8rem;
        }   
        .navbar-brand div {
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
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

    <div class="container text-center my-5">
        <h3>Semua Buku</h3>
        <div class="row justify-content-center">
            <?php
            if (count($allBooks) > 0) {
                // Output data of each row
                foreach ($allBooks as $book) {
                    $imagePath = htmlspecialchars($book['cover_image']);
                    if (!file_exists($imagePath) || empty($book['cover_image'])) {
                        $imagePath = 'asset/uploads/default.png'; // Fallback image
                    }
                    echo '<div class="col-md-3 d-flex align-items-stretch">';
                    echo '<div class="card shadow-sm">';
                    echo '<img src="' . $imagePath . '" class="card-img-top" alt="Cover Buku">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($book['title']) . '</h5>';
                    echo '<p class="card-text"><strong>Pengarang:</strong> ' . htmlspecialchars($book['author']) . '</p>';
                    echo '<p class="card-text"><strong>Stok:</strong> ' . htmlspecialchars($book['stock']) . '</p>';
                    echo '<form action="proses_siswa.php" method="POST">';
                    echo '<input type="hidden" name="book_id" value="' . $book['id'] . '">';
                    echo '<button type="submit" class="btn btn-primary btn-sm">Pinjam</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "0 results";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>