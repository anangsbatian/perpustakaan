<?php
include 'koneksi.php';

// Cek apakah ada ID buku di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID buku tidak ditemukan!";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT title, deskripsi, stock, cover_image FROM books WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $book = mysqli_fetch_assoc($result);
} else {
    echo "Buku tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Buku</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="container">
    <div class="book-detail">
        <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="Cover Buku" class="book-cover">
        <div class="book-info">
            <h2><?= htmlspecialchars($book['title']) ?></h2>
            <p><strong>Deskripsi:</strong></p>
            <p><?= nl2br(htmlspecialchars($book['deskripsi'])) ?></p>
            <p><strong>Stok:</strong> <?= htmlspecialchars($book['stock']) ?></p>
            <a href="manage_books.php" class="back-link">Kembali ke daftar buku</a>
        </div>
    </div>
</div>

<footer>
    &copy; Widya Kirana Elementary School
</footer>

</body>
</html>

<?php
mysqli_close($conn);
?>
