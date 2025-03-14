<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial Peminjaman Buku</title>
    <!-- Tambahkan Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        header {
            background-color: rgba(0, 0, 0, 0.53);
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        header h1 {
            font-size: 2rem;
            font-weight: bold;
            animation: fadeIn 1s ease-in-out;
        }
        main {
            padding: 20px;
        }
        section {
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        section:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }
        section h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: rgba(3, 3, 3, 0.59);
            margin-bottom: 15px;
            animation: slideIn 1s ease-in-out;
        }
        section p {
            font-size: 1rem;
            color: #6c757d;
        }
        section img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 15px;
            transition: transform 0.3s ease-in-out;
        }
        section img:hover {
            transform: scale(1.05);
        }
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
        .navbar {
            padding: 0.5rem 1rem; 
        }
        .navbar-brand .logo {
            width: 50px; 
            height: auto;
        }
        .navbar-brand span {
            font-size: 1.2rem; 
            font-weight: bold; 
        }
        .navbar-brand small {
            font-size: 0.8rem;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes slideIn {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="asset/logo/logo.png" alt="Logo" class="logo">
            </a>
            <div class="navbar-brand">
                <span>PERPUSTAKAAN</span><br>
                <small style="font-size: 1rem;">SD Widya Kirana</small>
            </div>
            <div class="ms-auto">
                <a href="log-out.php" class="btn btn-outline-success">Logout</a>
            </div>
        </div>
    </nav>

    <section class="text-center" style="position: relative; height: 90vh; overflow: hidden; animation: fadeIn 1.5s ease-in-out; margin-top: 20px;">
        <img src="asset/guide/guide.jpg" alt="Panduan Peminjaman Buku" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1; animation: fadeIn 1.5s ease-in-out;">
        <div class="container d-flex flex-column justify-content-center align-items-center h-100 text-white">
            <h1 class="display-4 fw-bold text-shadow">Panduan Peminjaman Buku</h1>
            <p class="lead mt-3 text-shadow">Panduan lengkap untuk memanfaatkan layanan perpustakaan kami dengan mudah dan cepat.</p>
        </div>
    </section>

    
    <style>
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
    </style>
    
    <main class="container">
        <section class="text-center mx-auto" style="max-width: 800px;">
            <h2>Langkah 1: Lihat Koleksi Buku</h2>
            <p>Klik tombol "Lihat Koleksi" untuk melihat daftar buku yang tersedia di perpustakaan.</p>
            <img src="asset\guide\1g.png" alt="Contoh halaman koleksi buku">
        </section>
        <section class="text-center mx-auto" style="max-width: 800px;">
            <h2>Langkah 2: Pilih Kategori Buku</h2>
            <p>Pilih kategori buku yang ingin Anda cari. Jika tidak menemukan kategori yang sesuai, klik "Lihat Semua Buku" untuk menampilkan seluruh koleksi.</p>
            <img src="asset\guide\2g.png" alt="Contoh halaman kategori buku">
        </section>
        <section class="text-center mx-auto" style="max-width: 800px;">
            <h2>Langkah 3: Pinjam Buku</h2>
            <p>Setelah menemukan buku yang diinginkan, klik tombol "Pinjam" untuk mengajukan peminjaman.</p>
            <img src="asset\guide\3g.png" alt="Contoh halaman peminjaman buku">
        </section>
        <section class="text-center mx-auto" style="max-width: 800px;">
            <h2>Langkah 4: Pengembalian Buku</h2>
            <p>Untuk mengembalikan buku yang telah dipinjam, buka halaman "Pengembalian" dan klik tombol "Kembalikan Buku" pada buku yang ingin dikembalikan.</p>
            <img src="asset\guide\4g.png" alt="Contoh halaman pengembalian buku">
        </section>
        <section class="text-center mx-auto" style="max-width: 800px;">
            <h2>Langkah 5: Logout Pengguna</h2>
            <p>Klik tombol "Logout" sistem akan mengeluarkan akun Anda dan mengarahkan kembali ke halaman login </p>
            <img src="asset\guide\5g.png" alt="Contoh halaman pengembalian buku">
        </section>
    </main>
    <div class="d-flex justify-content-center mt-4">
        <a href="landing.php" class="btn btn-primary btn-lg">Selesai</a>
    </div>
    <footer>
        <p>&copy; 2025 Perpustakaan SD Widya Kirana</p>
    </footer>

    <!-- Tambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
