<?php
require 'vendor/autoload.php'; // Jika pakai Composer
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Koneksi database
$conn = new mysqli("localhost", "root", "", "perpustakaan1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil bulan dari GET (misalnya: ?bulan=2025-02)
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');

// Query untuk mengambil data peminjaman berdasarkan bulan
$query = "SELECT loans.id, user.username, user.grade, books.title, loans.borrow_date, loans.return_date, loans.status 
          FROM loans
          JOIN user ON loans.user_id = user.id
          JOIN books ON loans.book_id = books.id
          WHERE DATE_FORMAT(loans.borrow_date, '%Y-%m') = ?
          ORDER BY loans.borrow_date ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $bulan);
$stmt->execute();
$result = $stmt->get_result();

// Buat file Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Peminjaman Bulan " . $bulan);

// Header kolom
$headers = ["ID Peminjaman", "Nama Siswa", "Kelas", "Judul Buku", "Tanggal Peminjaman", "Tanggal Pengembalian", "Status"];
$sheet->fromArray([$headers], NULL, 'A1');

// Isi data dari database
$rowNum = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->fromArray([
        $row['id'],
        $row['username'],
        $row['grade'],
        $row['title'],
        $row['borrow_date'],
        $row['return_date'] ? $row['return_date'] : "-",
        $row['status']
    ], NULL, 'A' . $rowNum);
    $rowNum++;
}

// Set header untuk download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Peminjaman_' . $bulan . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
