<?php
include 'proses_siswa.php';

// Ambil tanggal hari ini
$current_date = date('Y-m-d');

// Tambahkan array untuk menyimpan notifikasi
$notifications = [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku yang Dipinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif; /* Font yang lebih modern */
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

    <div class="container mt-5 pt-5">
        <h2 class="text-center">Buku yang Anda Pinjam</h2>

        <!-- Notifikasi -->
        <?php if (!empty($notifications)) : ?>
            <div class="alert alert-warning" role="alert">
                <ul>
                    <?php foreach ($notifications as $notification) : ?>
                        <li><?php echo $notification; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Nomor Rak</th>
                    <th>Batas Pengembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $loanResult->fetch_assoc()) : ?>
                    <?php
                    // Hitung selisih hari antara deadline dan tanggal hari ini
                    $due_date = $row['due_date'];
                    $days_left = round((strtotime($due_date) - strtotime($current_date)) / (60 * 60 * 24), 1);

                    // Tambahkan notifikasi jika mendekati deadline (2 hari atau kurang)
                    if ($days_left > 0 && $days_left <= 2 && $row['status'] !== 'Dikembalikan') {
                        $notifications[] = "Buku '{$row['title']}' harus dikembalikan dalam $days_left hari. (Tanggal: " . date('d-m-Y') . ", Jam: " . date('H:i') . ")";
                    }
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo htmlspecialchars($row['shelf_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                        <td>
                            <form action="" method="POST" onsubmit="return confirmReturn();">
                                <input type="hidden" name="loan_id" value="<?php echo $row['loan_id']; ?>">
                                <button type="submit" class="btn btn-danger">Kembalikan</button>
                            </form>
                            <script>
                                function confirmReturn() {
                                    const modalHtml = `
                                        <div class="modal fade" id="confirmReturnModal" tabindex="-1" aria-labelledby="confirmReturnModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning text-dark">
                                                        <h5 class="modal-title" id="confirmReturnModalLabel">Konfirmasi Pengembalian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Pastikan buku ditaruh pada nomor rak yang sesuai. Klik <strong>OK</strong> untuk melanjutkan.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="button" class="btn btn-danger" id="confirmButton">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;

                                    // Append modal to body
                                    document.body.insertAdjacentHTML('beforeend', modalHtml);

                                    // Show modal
                                    const confirmModal = new bootstrap.Modal(document.getElementById('confirmReturnModal'));
                                    confirmModal.show();

                                    // Handle confirm button click
                                    document.getElementById('confirmButton').addEventListener('click', function () {
                                        confirmModal.hide();
                                        document.querySelector('form').submit();
                                    });

                                    // Prevent default form submission
                                    return false;
                                }
                            </script>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php
                if ($loanResult->num_rows === 0) {
                    echo "<p class='text-center text-danger'>Tidak ada buku yang sedang dipinjam.</p>";
                }
                ?>
            </tbody>

            <!-- Popup Notifikasi -->
            <?php if (!empty($notifications)) : ?>
                <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="notificationModalLabel">Peringatan Pengembalian Buku</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <?php foreach ($notifications as $notification) : ?>
                                        <li><?php echo $notification; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    // Tampilkan popup saat halaman dimuat
                    document.addEventListener('DOMContentLoaded', function () {
                        var notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
                        notificationModal.show();
                    });
                </script>
            <?php endif; ?>
        </table>
        <p class="text-danger text-center mt-3"><strong>Catatan:</strong> Harap mengembalikan buku pada raknya.</p>
        <div class="d-flex justify-content-center mt-4">
        <a href="book.php" class="btn btn-primary btn-lg">Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
