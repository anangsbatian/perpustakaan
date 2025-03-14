<?php
session_start();

// Periksa apakah pengguna sudah login sebagai siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: index.php"); // Redirect ke halaman login jika bukan siswa
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "perpustakaan1");
if ($conn->connect_error) {
    die("<p style='color: red; text-align: center;'>Connection failed: " . $conn->connect_error . "</p>");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif; /* Font yang lebih modern */
        }
        html {
            scroll-behavior: smooth;
        }
        .hero {
            position: relative;
            background: url('https://source.unsplash.com/1600x900/?library,books') no-repeat center center/cover;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.6);
            margin-top: 100px; /* Sesuaikan dengan tinggi navbar */
        }
        .hero .home-background {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: blur(8px);
            z-index: -1;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            z-index: 1;
        }
        .hero p {
            font-size: 1.25rem;
            max-width: 700px;

        }
        /* Fitur Section */
        .fitur .icon-box {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }
        .fitur .icon-box:hover {
            transform: translateY(-10px);
        }
        .fitur i {
            font-size: 3rem;
            color: #007bff;
        }
        /* Footer */
        .footer {
            background: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .navbar-brand .logo {
            width: 50px;
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
        .fade-in {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .fade-in.visible {
            opacity: 1;
        }
        .interactive-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        .interactive-background .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            animation: move 20s infinite;
        }
        @keyframes move {
            0% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-100px) translateX(100px);
            }
            100% {
                transform: translateY(0) translateX(0);
            }
        }
        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            background-color:rgb(199, 200, 201);
            text-align: center;
            padding: 20px;
        }
        .card-body i {
            font-size: 3rem;
            color:rgb(0, 115, 255);
        }
        .card-body h4 {
            color: #343a40;
            font-weight: bold;
        }
        .card-body p {
            color:rgb(0, 0, 0);
        }
        .logo-circle img {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }
        .logo-square img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <nav class="navbar bg-primary fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
        <a class="navbar-brand" href="landing.php">
                <img src="asset/logo/logo.png" alt="Logo" class="logo">
                <div>
                    <span>PERPUSTAKAAN</span><br>
                    <small style="font-size: 1rem;">SD Widya Kirana</small>
                </div>
            </a>
            <div class="ms-auto">
                <a href="log-out.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <section class="hero fade-in">
        <div class="interactive-background">
            <div class="circle" style="width: 100px; height: 100px; top: 20%; left: 10%;"></div>
            <div class="circle" style="width: 150px; height: 150px; top: 50%; left: 70%;"></div>
            <div class="circle" style="width: 80px; height: 80px; top: 80%; left: 30%;"></div>
        </div>
        <div class="container text-center" style="margin-top: -5px;">
            <a class="navbar-brand" href="#">
                <img src="asset/home/landing.png" alt="Logo" class="home-background">
            </a>
            <h1>Selamat Datang di Perpustakaan Digital</h1>
            <div class="d-flex justify-content-center mt-4">
                <div class="logo-square mx-3">
                    <img src="asset/logo/logo1.png" alt="Logo 1" class="square">
                </div>
                <div class="logo-square mx-3">
                    <img src="asset/logo/logo2.png" alt="Logo 2" class="square">
                </div>
                <div class="logo-square mx-3">
                    <img src="asset/logo/logo3.png" alt="Logo 3" class="square">
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Perpustakaan -->
    <section class="fitur container mt-5 fade-in">
        <h2 class="text-center fw-bold mb-4">Quotes</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="asset\home\Screenshot 2025-03-11 212303.png" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                        <i class="fa-solid fa-book"></i>
                        <h4 class="mt-3">"Buku adalah jendela dunia yang terbuka"</h4>
                        <p>"Setiap halaman yang kau baca membuka cakrawala baru dan memperluas wawasanmu."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="asset\home\Screenshot 2025-03-11 212621.png" class="card-img-top" alt="Image 2">
                    <div class="card-body">
                        <i class="fa-solid fa-desktop"></i>
                        <h4 class="mt-3">"Membaca adalah perjalanan tanpa batas"</h4>
                        <p>"Dunia baru terbuka di hadapanmu. Pinjam buku dan mulai petualanganmu."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <img src="asset\home\Screenshot 2025-03-11 213327.png" class="card-img-top" alt="Image 3">
                    <div class="card-body">
                        <i class="fa-solid fa-chair"></i>
                        <h4 class="mt-3">"Temukan ketenangan dalam halaman buku"</h4>
                        <p>"Di ruang yang tenang, setiap lembar buku mengantarkanmu pada dunia yang penuh inspirasi."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5 fade-in">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold">Panduan Pengguna</h2>
                <p>Ikuti langkah-langkah dalam panduan ini untuk mempelajari cara menggunakan fitur utama dengan cepat.</p>
                <a href="loansguide.php" class="btn btn-primary btn-lg" style="transition: transform 0.3s ease;" 
                   onmouseover="this.style.transform='scale(1.1)';" 
                   onmouseout="this.style.transform='scale(1)';">
                    Pelajari Lebih Lanjut
                </a>
            </div>
            <div class="col-md-6 position-relative">
                <img src="asset/home/tutor.png" alt="Panduan Pengguna" class="img-fluid" 
                     style="transition: transform 0.3s ease;" 
                     onmouseover="this.style.transform='scale(1.1)';" 
                     onmouseout="this.style.transform='scale(1)';">
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const image = document.querySelector('.col-md-6 img');
            const tooltip = document.getElementById('tooltip');

            image.addEventListener('mouseover', function() {
                tooltip.style.display = 'block';
                image.style.transform = 'scale(1.05)';
            });

            image.addEventListener('mouseout', function() {
                tooltip.style.display = 'none';
                image.style.transform = 'scale(1)';
            });
        });
    </script>
    <!-- CTA -->
    <section class="container text-center mt-5 fade-in position-relative">
        <div class="position-relative">
            <img src="asset/home/main.jpg" alt="Main Image" class="img-fluid my-4 w-100" 
                 style="transition: transform 0.3s ease;" 
                 onmouseover="this.style.transform='scale(1.05)';" 
                 onmouseout="this.style.transform='scale(1)';">
            <div class="position-absolute top-50 start-50 translate-middle text-white p-3" style="background: rgba(0, 0, 0, 0.5); border-radius: 10px;">
                <h2 class="fw-bold">Siap Menjelajahi Dunia Pengetahuan?</h2>
                <p>Temukan buku favoritmu sekarang dan mulai perjalanan membaca yang menyenangkan.</p>
                <a href="book.php" class="btn btn-success btn-lg mt-3" style="transition: transform 0.3s ease;" 
                   onmouseover="this.style.transform='scale(1.1)';" 
                   onmouseout="this.style.transform='scale(1)';">
                    Lihat Koleksi
                </a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const exploreButton = document.getElementById('exploreButton');
            exploreButton.addEventListener('mouseover', function() {
                this.style.transform = 'scale(1.1)';
                this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
            });
            exploreButton.addEventListener('mouseout', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
            });
            exploreButton.addEventListener('click', function() {
                alert('Ayo mulai menjelajahi koleksi buku kami!');
            });
        });
    </script>

    <footer class="footer mt-5 fade-in">
        <p>&copy; 2025 Perpustakaan SD Widya Kirana | <a href="contact.php" class="text-white">Hubungi Kami</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faders = document.querySelectorAll('.fade-in');
            const appearOptions = {
                threshold: 0.5,
                rootMargin: "0px 0px -50px 0px"
            };

            const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) {
                        return;
                    } else {
                        entry.target.classList.add('visible');
                        appearOnScroll.unobserve(entry.target);
                    }
                });
            }, appearOptions);

            faders.forEach(fader => {
                appearOnScroll.observe(fader);
            });

            const circles = document.querySelectorAll('.interactive-background .circle');
            circles.forEach(circle => {
                const randomDuration = Math.random() * 20 + 10;
                circle.style.animationDuration = `${randomDuration}s`;
            });
        });
    </script>
</body>
</html>