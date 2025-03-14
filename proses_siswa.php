<?php
session_start();

date_default_timezone_set('Asia/Jakarta');

$conn = new mysqli("localhost", "root", "", "perpustakaan1");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'siswa') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Menentukan kategori berdasarkan nama file
$page = basename($_SERVER['PHP_SELF'], ".php");
$categoryMap = [
    "agama" => "Agama",
    "olahraga" => "Olahraga",
    "matematika" => "Matematika",
    "teknologi" => "Teknologi"
    
];
$category = $categoryMap[$page] ?? "Umum";

// Ambil daftar buku yang sudah dipinjam oleh siswa
$borrowedBooksQuery = "SELECT book_id FROM loans WHERE user_id = ? AND status = 'Dipinjam'";
$stmt = $conn->prepare($borrowedBooksQuery);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$borrowedBooksResult = $stmt->get_result();

$borrowedBooks = [];
while ($row = $borrowedBooksResult->fetch_assoc()) {
    $borrowedBooks[] = $row['book_id'];
}
$stmt->close();

// Ambil daftar buku berdasarkan kategori
$query = "SELECT * FROM books WHERE LOWER(category) = LOWER(?)";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

// Proses peminjaman buku jika ada permintaan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    // Cek apakah buku ini sudah dipinjam oleh siswa
    if (in_array($book_id, $borrowedBooks)) {
        header("Location: book.php?error=duplicate");
        exit();
    }

    // Cek stok buku
    $checkStock = $conn->prepare("SELECT stock, shelf_location FROM books WHERE id = ?");
    if ($checkStock === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $checkStock->bind_param("i", $book_id);
    $checkStock->execute();
    $checkStock->bind_result($stock, $shelf_location);
    $checkStock->fetch();
    $checkStock->close();

    if ($stock > 0) {
        // Kurangi stok buku
        $updateStock = $conn->prepare("UPDATE books SET stock = stock - 1 WHERE id = ?");
        if ($updateStock === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $updateStock->bind_param("i", $book_id);
        $updateStock->execute();
        $updateStock->close();

        // Simpan data peminjaman dengan tanggal dan waktu peminjaman serta deadline
        $borrow_date = date('Y-m-d H:i:s'); // Waktu saat ini
        $due_date = date('Y-m-d H:i:s', strtotime('+7 days', strtotime($borrow_date))); // Tepat 7 hari dari waktu peminjaman

        $insertLoan = $conn->prepare("INSERT INTO loans (user_id, book_id, status, borrow_date, due_date, shelf_location) VALUES (?, ?, 'Dipinjam', ?, ?, ?)");
        if ($insertLoan === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $insertLoan->bind_param("iisss", $user_id, $book_id, $borrow_date, $due_date, $shelf_location);
        $insertLoan->execute();
        $insertLoan->close();

        if ($stmt->execute()) {
            header("Location: book.php?success=1");
        } else {
            header("Location: book.php?error=failed");
        }
    } else {
        echo "<script>alert('Stok habis!'); window.location.href='list_books.php';</script>";
    }
}

// Ambil daftar buku yang sedang dipinjam
$loanQuery = "SELECT loans.id AS loan_id, books.title, books.author, books.shelf_location, loans.status, loans.due_date 
              FROM loans 
              JOIN books ON loans.book_id = books.id 
              WHERE loans.user_id = ? AND loans.status = 'Dipinjam'";

$stmt = $conn->prepare($loanQuery);
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$loanResult = $stmt->get_result();

// Proses pengembalian buku jika ada permintaan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loan_id'])) {
    $loan_id = $_POST['loan_id'];

    // Ambil ID buku dari loan
    $loanQuery = $conn->prepare("SELECT book_id FROM loans WHERE id = ?");
    if ($loanQuery === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $loanQuery->bind_param("i", $loan_id);
    $loanQuery->execute();
    $loanQuery->bind_result($book_id);
    $loanQuery->fetch();
    $loanQuery->close();

    // Tambah stok buku
    $updateStock = $conn->prepare("UPDATE books SET stock = stock + 1 WHERE id = ?");
    if ($updateStock === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $updateStock->bind_param("i", $book_id);
    $updateStock->execute();
    $updateStock->close();

    // Update status peminjaman dan tambahkan tanggal pengembalian
    $updateLoan = $conn->prepare("UPDATE loans SET status = 'Dikembalikan', return_date = NOW() WHERE id = ?");
    if ($updateLoan === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $updateLoan->bind_param("i", $loan_id);
    $updateLoan->execute();
    $updateLoan->close();

    echo "<script>alert('Buku berhasil dikembalikan!'); window.location.href='my_loans.php';</script>";
}

$conn->close();
?>