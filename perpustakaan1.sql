-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2025 at 03:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan1`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `isbn` varchar(13) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `shelf_location` varchar(50) DEFAULT NULL,
  `status` enum('available','borrowed','damaged','lost') DEFAULT 'available',
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deskripsi` text DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `publisher`, `isbn`, `category`, `shelf_location`, `status`, `cover_image`, `created_at`, `updated_at`, `deskripsi`, `stock`) VALUES
(15, 'ajawk', 'J.K. Rowling', 'Bentang Pustaka', '32232324', 'action', 'A4', 'available', 'asset/uploads/1740053444_Screenshot (255).png', '2025-02-03 14:26:59', '2025-02-27 18:13:33', 'esffd', 3),
(27, 'Bahasa Indonesia Kelas 1', 'A. Irdandi', 'Erlangga', '9786231807090', 'Pendidikan', '1', 'available', 'asset/uploads/1740718793_WhatsApp Image 2025-02-28 at 11.52.51.jpeg', '2025-02-28 04:59:53', '2025-02-28 06:04:01', 'Buku Bahasa Indonesia untuk SD/MI Kelas 1 ini merupakan buku pendamping tematik terpadu yang disusun sesuai dengan Kurikulum 2013 (Revisi). Buku ini membantu siswa dalam memahami dasar-dasar Bahasa Indonesia melalui pendekatan yang interaktif dan menyenangkan.\\\\r\\\\n\\\\r\\\\nMateri dalam buku ini mencakup materi inti, penilaian harian, keterampilan, serta penilaian akhir semester dan akhir tahun. Dengan ilustrasi yang menarik dan latihan soal yang variatif, buku ini cocok digunakan sebagai referensi utama dalam pembelajaran di sekolah maupun belajar mandiri di rumah.', 4),
(28, 'Tematik Terpadu Benda, Hewan, dan Tanaman Disekitarku', 'Irene. M. J. A | Dwi Tyas', 'Erlangga', '979-26-1865-1', 'Pendidikan', '1', 'available', 'asset/uploads/1740723306_WhatsApp Image 2025-02-28 at 11.52.52.jpeg', '2025-02-28 06:15:06', '2025-02-28 06:15:06', 'Buku ini merupakan bagian dari pembelajaran tematik untuk siswa SD Kelas 1 sesuai dengan Kurikulum 2013 (K13). Materinya mengintegrasikan berbagai aspek pembelajaran, termasuk pengenalan benda, hewan, dan tumbuhan di sekitar, serta bagaimana siswa dapat memahami lingkungan secara interaktif.', 5),
(29, 'TIK Kelas 1', 'Hindraswati Enggar Dwipeni', 'Erlangga', '847-378-392-1', 'Pendidikan', '1', 'available', 'asset/uploads/1740723460_WhatsApp Image 2025-02-28 at 11.52.51 (1).jpeg', '2025-02-28 06:17:40', '2025-02-28 07:52:54', 'Buku ini biasanya digunakan sebagai pengenalan dasar Teknologi Informasi dan Komunikasi (TIK) untuk siswa kelas 1 SD. Materinya dapat mencakup pengenalan perangkat komputer, fungsi dasar keyboard dan mouse, serta penggunaan perangkat lunak sederhana.', 3),
(30, 'Matematika Kelas 2', 'Dhesy Adhalia', 'Erlangga', '978-602-298-8', 'Pendidikan', '1', 'available', 'asset/uploads/1740723645_WhatsApp Image 2025-02-28 at 11.52.50.jpeg', '2025-02-28 06:20:45', '2025-02-28 15:43:59', 'Buku ESPS Matematika untuk SD/MI Kelas II disusun berdasarkan Kurikulum Merdeka, mengedepankan semangat merdeka belajar. Materi disajikan dengan pendekatan yang sesuai dengan Capaian Pembelajaran dalam mata pelajaran Matematika.', 5),
(31, 'Spirit Membangun Kepemimpinan 2', 'Malcolm Webber', 'Strategic Press', '978-188881062', 'Agama', '1', 'available', 'asset/uploads/1740723873_WhatsApp Image 2025-02-28 at 11.52.49.jpeg', '2025-02-28 06:24:33', '2025-02-28 06:24:33', 'Buku Healthy Leaders: SpiritBuilt Leadership 2 karya Malcolm Webber menawarkan kerangka kerja konseptual yang alkitabiah untuk memahami karakteristik pemimpin yang sehat. Webber mengidentifikasi lima kategori utama yang membentuk pemimpin yang efektif dan sehat: Kristus, Komunitas, Karakter, Panggilan, dan Kompetensi. Melalui pendekatan ini, pembaca diajak untuk mengenal Tuhan lebih dalam, membangun komunitas yang mendukung dan akuntabel, mengembangkan karakter yang kuat, memahami tujuan ilahi, serta mengasah keterampilan dan pengetahuan yang diperlukan untuk memimpin dengan efektif. Buku ini menjadi panduan transformatif bagi siapa saja yang ingin tumbuh dan berkembang menjadi pemimpin yang sehat dan berdampak.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') DEFAULT 'Dipinjam',
  `borrow_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `return_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `book_id`, `status`, `borrow_date`, `return_date`) VALUES
(1, 8, 15, 'Dikembalikan', '2025-02-20 14:51:32', NULL),
(5, 8, 15, 'Dikembalikan', '2025-02-21 17:31:15', '2025-02-22 16:20:24'),
(6, 8, 15, 'Dikembalikan', '2025-02-22 17:30:52', '2025-02-22 17:44:03'),
(37, 8, 15, 'Dikembalikan', '2025-02-23 12:29:55', '2025-02-23 12:31:31'),
(38, 8, 15, 'Dikembalikan', '2025-02-23 12:36:21', '2025-02-23 13:26:08'),
(41, 8, NULL, 'Dikembalikan', '2025-02-27 15:02:36', '2025-02-27 15:04:02'),
(42, 8, NULL, 'Dikembalikan', '2025-02-27 15:06:40', '2025-02-27 15:06:51'),
(43, 8, NULL, 'Dikembalikan', '2025-02-27 15:24:06', '2025-02-27 15:24:13'),
(44, 8, 15, 'Dikembalikan', '2025-02-27 16:44:36', '2025-02-27 16:45:06'),
(45, 8, 15, 'Dikembalikan', '2025-02-27 17:28:46', '2025-02-27 17:28:54'),
(46, 12, 15, 'Dikembalikan', '2025-02-27 18:13:29', '2025-02-27 18:13:33'),
(47, 12, 30, 'Dikembalikan', '2025-02-28 06:30:45', '2025-02-28 06:31:20'),
(48, 13, 29, 'Dikembalikan', '2025-02-28 07:51:51', '2025-02-28 07:52:54'),
(49, 13, 30, 'Dikembalikan', '2025-02-28 15:42:22', '2025-02-28 15:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL,
  `grade` varchar(50) NOT NULL,
  `no_induk` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `grade`, `no_induk`) VALUES
(7, 'aka', '$2y$10$WZWWeIeeCrjWF6uiPtirXu/K.he27r7yAMSgvMnV4pnMgg8ervhrS', 'admin', '', '123456'),
(8, 'hyerin', '$2y$10$KWcPZYw8JDoeNL1mI2H8P.s5JnwFN/95IrTrSMg8hnNhOw8arO7nO', 'siswa', '2', '654321'),
(12, 'minan', '$2y$10$M8XmwuYU/0o9LaMAoQdUXeC0bNLO/roMLggYn4YbilXV28yDyvre.', 'siswa', '3', '132344'),
(13, 'Ramadhan sulthon alfanie', '$2y$10$TueEWiW.v2H8S0.6CSXNXee/9jbf53Eh9WwWRfUZ28Ed7RcNxtDj.', 'siswa', '3', '111222');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_induk` (`no_induk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
