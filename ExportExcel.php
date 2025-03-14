<?php
require 'vendor/autoload.php';
include 'koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header kolom
$sheet->setCellValue('A1', 'Judul');
$sheet->setCellValue('B1', 'Pengarang');
$sheet->setCellValue('C1', 'Penerbit');
$sheet->setCellValue('D1', 'ISBN');
$sheet->setCellValue('E1', 'Kategori');
$sheet->setCellValue('F1', 'Lokasi Rak');
$sheet->setCellValue('G1', 'Deskripsi');
$sheet->setCellValue('H1', 'Stok');

$query = "SELECT title, author, publisher, isbn, category, shelf_location, deskripsi, stock FROM books";
$result = $conn->query($query);

$row = 2;
while ($book = $result->fetch_assoc()) {
    $sheet->setCellValue("A$row", $book['title']);
    $sheet->setCellValue("B$row", $book['author']);
    $sheet->setCellValue("C$row", $book['publisher']);
    $sheet->setCellValue("D$row", $book['isbn']);
    $sheet->setCellValue("E$row", $book['category']);
    $sheet->setCellValue("F$row", $book['shelf_location']);
    $sheet->setCellValue("G$row", $book['deskripsi']);
    $sheet->setCellValue("H$row", $book['stock']);
    $row++;
}

$filename = "daftar_buku.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
