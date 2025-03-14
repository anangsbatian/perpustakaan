<?php
include 'proses_siswa.php';

// Notifikasi setelah peminjaman
$success_message = isset($_GET['success']) ? "Buku berhasil dipinjam!" : "";
$error_message = isset($_GET['error']) && $_GET['error'] === 'duplicate' ? "Anda sudah meminjam buku ini sebelumnya!" : "";
$error_message = isset($_GET['error']) && $_GET['error'] === 'failed' ? "Terjadi kesalahan saat meminjam buku!" : $error_message;
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
            font-family: 'Arial', sans-serif; /* Font yang lebih modern */
        }
        html {
            scroll-behavior: smooth;
        }
        .hero-section {
            background: url('asset/home/landing.png') no-repeat center center fixed;
            background-size: cover;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            position: relative;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Overlay untuk membuat teks lebih terbaca */
        }
        .hero-section > * {
            position: relative;
            z-index: 1;
        }
        .card {
            width: 100%;
            max-width: 250px;
            margin: 10px auto;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #ffffff; /* Warna latar belakang kartu */
        }
        .card img {
            height: 350px;
            object-fit: cover;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .logo {
            width: 50px;
            height: 50px;
        }
        .bg-primary {
            background-color: #007bff !important; /* Warna biru yang lebih elegan */
        }
        .btn-outline-success {
            color: #28a745;
            border-color: #28a745;
        }
        .btn-outline-success:hover {
            background-color: #28a745;
            color: #ffffff;
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
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 1s ease-out, transform 1s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .toast-center {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            width: 400px; /* Lebar toast */
            padding: 20px; /* Padding untuk membuatnya lebih besar */
            font-size: 1.25rem; /* Ukuran teks lebih besar */
        }

        .toast-body {
            text-align: center; /* Teks di tengah */
        }

        .btn-close {
            font-size: 1rem; /* Ukuran tombol close lebih besar */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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

    <!-- Hero Section -->
    <div class="hero-section fade-in mt-5" style="z-index: 2; position: relative;">
        
    </div>

    <!-- Kategori Buku -->
    <div class="container text-center my-5 fade-in">
        <h3>Pilih subjek yang menarik bagi Anda</h3>
        <div class="row justify-content-center">
            <div class="col-md-2 fade-in">
                <a href="sains.php" class="text-decoration-none text-dark">
                    <div class="card p-3 text-center">
                        <img src="asset/home/sains.png" alt="sains&teknologi">
                        <p>Sains dan Teknologi</p>
                    </div>
                </a>
            </div>
            <div class="col-md-2 fade-in">
                <a href="sosial.php" class="text-decoration-none text-dark">
                    <div class="card p-3 text-center">
                        <img src="asset/home/sosial.png" alt="alam&sosial">
                        <p>Ilmu Alam&Sosial</p>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="seni.php" class="text-decoration-none text-dark">
                    <div class="card p-3 text-center">
                        <img src="asset/home/seni.png" alt="seni&budaya">
                        <p>Seni dan Budaya</p>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="olahraga.php" class="text-decoration-none text-dark">
                    <div class="card p-3 text-center">
                        <img src="asset/home/olahraga.png" alt="hiburan&olahraga">
                        <p>Hiburan dan Olahraga</p>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="agama.php" class="text-decoration-none text-dark">
                    <div class="card p-3 text-center">
                        <img src="asset/home/agama.png" alt="agama">
                        <p>Agama</p>
                    </div>
                </a>
            </div>
            <div class="col-md-2">
                <a href="matematika.php" class="text-decoration-none text-dark">
                    <div class="card p-3 text-center">
                        <img src="asset/home/math.jpg" alt="matematika">
                        <p>Matematika</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <a href="allbook.php" class="btn btn-primary">Lihat Semua Buku</a>
        </div>
    </div>
    <div class="container mt-4">
    <?php if ($success_message): ?>
        <div class="toast toast-center align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= $success_message; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div class="toast toast-center align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= $error_message; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faders = document.querySelectorAll('.fade-in');
            const options = {
                threshold: 0.5,
                rootMargin: "0px 0px -50px 0px"
            };

            const appearOnScroll = new IntersectionObserver(function (entries, observer) {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) {
                        return;
                    } else {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            faders.forEach(fader => {
                appearOnScroll.observe(fader);
            });

            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl);
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
</body>
</html>