<?php
include 'proses_siswa.php';

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "perpustakaan1");
if ($conn->connect_error) {
    die("<p style='color: red; text-align: center;'>Connection failed: " . $conn->connect_error . "</p>");
}


$sql = "SELECT * FROM books WHERE LOWER(category) = 'seni&budaya'";
$result = $conn->query($sql);
$pendidikanBooks = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();

// Notifikasi setelah peminjaman
$success_message = isset($_GET['success']) ? "Buku berhasil dipinjam!" : "";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Buku - Seni dan Budaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color:#0080ff;
        }
        .navbar-brand {
            color: #ffffff !important;
            font-weight: bold;
        }
        .card {
            margin-bottom: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card img {
            height: 250px;
            object-fit: cover;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .container {
            max-width: 1200px;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem;
        }
        .card-body p {
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PERPUSTAKAAN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-light text-white px-3 py-2" href="book.php" style="font-weight: bold; border: 2px solid #ffffff; border-radius: 5px;">Kembali</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <?php if ($success_message): ?>
            <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?= $success_message; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <?php foreach ($pendidikanBooks as $book): ?>
                <div class="col-md-3 d-flex align-items-stretch">
                    <div class="card shadow-sm">
                        <img src="<?= htmlspecialchars($book['cover_image']) ?>" class="card-img-top" alt="Cover Buku">
                        <div class="card-body">
                            <h5 class="card-title"> <?= htmlspecialchars($book['title']) ?> </h5>
                            <p class="card-text"><strong>Pengarang:</strong> <?= htmlspecialchars($book['author']) ?></p>
                            <p class="card-text"><strong>Stok:</strong> <?= htmlspecialchars($book['stock']) ?></p>
                            <p class="card-text"><strong>Lokasi Rak:</strong> <?= htmlspecialchars($book['shelf_location']) ?></p>
                            <form action="proses_siswa.php" method="POST">
                                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Pinjam</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl)
            })
            toastList.forEach(toast => toast.show());
        });
    </script>
</body>
</html>