<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "perpustakaan1");

if ($conn->connect_error) {
    die("<p style='color: red; text-align: center;'>Connection failed: " . $conn->connect_error . "</p>");
}

$error = "";

// **Proses Login**
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['no_induk']) && isset($_POST['password'])) {
    $no_induk = $conn->real_escape_string($_POST['no_induk']);
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan email
    $sql = "SELECT id, username, password, role FROM user WHERE no_induk = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $no_induk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan session user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; 
            $_SESSION['username'] = $user['username']; 
            $_SESSION['no_induk'] = $no_induk;

            // Redirect sesuai role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } elseif ($user['role'] === 'siswa') {
                header("Location: landing.php");
                exit();
            }
        } else {
            echo "<script>alert('Password salah!'); window.location.href='index.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.location.href='index.php';</script>";
        exit();
    }
    $stmt->close();
}

// **Buat folder untuk upload jika belum ada**
$uploadDir = "asset/uploads/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// **Tambah Buku**
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'create') {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $publisher = $conn->real_escape_string($_POST['publisher']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $category = $conn->real_escape_string($_POST['category']);
    $shelf_location = $conn->real_escape_string($_POST['shelf_location']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $stock = $conn->real_escape_string($_POST['stock']);

    // Upload Gambar Cover
    $image = $_FILES['cover_image']['name'];
    $tmp = $_FILES['cover_image']['tmp_name'];
    $filePath = $uploadDir . time() . "_" . basename($image); 

    if (move_uploaded_file($tmp, $filePath)) {
        $sql = "INSERT INTO books (title, author, publisher, isbn, category, shelf_location, cover_image, deskripsi, stock) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $title, $author, $publisher, $isbn, $category, $shelf_location, $filePath, $deskripsi, $stock);

        if ($stmt->execute()) {
            header("Location: manage_books.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Gagal mengunggah gambar!";
    }
}

// **Edit Buku**

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $publisher = $conn->real_escape_string($_POST['publisher']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $category = $conn->real_escape_string($_POST['category']);
    $shelf_location = $conn->real_escape_string($_POST['shelf_location']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $stock = intval($_POST['stock']);

    // Periksa apakah ada file cover yang diunggah
    if (!empty($_FILES['cover_image']['name'])) {
        $uploadDir = "asset/uploads/";
        $cover_image = $uploadDir . time() . "_" . basename($_FILES['cover_image']['name']);

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_image)) {
            // Update semua field termasuk cover_image
            $sql = "UPDATE books SET title=?, author=?, publisher=?, isbn=?, category=?, shelf_location=?, deskripsi=?, stock=?, cover_image=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssisi", $title, $author, $publisher, $isbn, $category, $shelf_location, $deskripsi, $stock, $cover_image, $id);
        } else {
            echo "<script>alert('Gagal mengunggah cover!'); window.history.back();</script>";
            exit();
        }
    } else {
        // Update semua field kecuali cover_image
        $sql = "UPDATE books SET title=?, author=?, publisher=?, isbn=?, category=?, shelf_location=?, deskripsi=?, stock=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssii", $title, $author, $publisher, $isbn, $category, $shelf_location, $deskripsi, $stock, $id);
    }

    // Jalankan query
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='manage_books.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . addslashes($stmt->error) . "'); window.history.back();</script>";
    }

    $stmt->close();
}


// **Hapus Buku**
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    // Hapus gambar jika ada
    $query = $conn->query("SELECT cover_image FROM books WHERE id='$id'");
    $data = $query->fetch_assoc();
    if ($data && file_exists($data['cover_image'])) {
        unlink($data['cover_image']);
    }

    $sql = "DELETE FROM books WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_books.php");
    exit;
}

// Tentukan jumlah buku per halaman
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk mengambil total jumlah buku
$total_query = "SELECT COUNT(*) as total FROM books";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_books = $total_row['total'];
$total_pages = ceil($total_books / $limit);

// Query untuk mengambil data buku dengan paginasi
$query = "SELECT * FROM books LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

// **Ambil Username Admin**
// Fetch the username using the stored email in the session
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Ambil username langsung dari session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Admin";

//ambil data siswa untuk manage siswa
// Ambil data siswa
$query = "SELECT id, username, grade, password FROM user WHERE role = 'siswa' ORDER BY id DESC";
$result = $conn->query($query);

// Simpan hasil query ke dalam array
$students = [];
while ($row = $result->fetch_assoc()) { 
    $students[] = $row;
}
// update siswa


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $grade = $_POST['grade'];
    $password = $_POST['password'];

 

    // Cek apakah user ingin mengganti password atau tidak
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE user SET username = ?, grade = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $username, $grade, $hashed_password, $id);
    } else {
        $query = "UPDATE user SET username = ?, grade = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $username, $grade, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='manage_users.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . addslashes($stmt->error) . "');</script>";
    }

    $stmt->close();
}



// **Pencarian Buku Berdasarkan Kategori**
// **Pencarian Buku Berdasarkan Kategori dengan Paginasi**
$search_category = isset($_GET['search_category']) ? trim($_GET['search_category']) : '';
$limit = 5; // Jumlah buku per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if (!empty($search_category)) {
    $query = "SELECT * FROM books WHERE category LIKE ? LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $search_param = "%" . $search_category . "%";
    $stmt->bind_param("sii", $search_param, $limit, $offset);
} else {
    $query = "SELECT * FROM books LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}
$stmt->close();

// **Hitung Total Buku dalam Pencarian**
if (!empty($search_category)) {
    $count_query = "SELECT COUNT(*) as total FROM books WHERE category LIKE ?";
    $stmt = $conn->prepare($count_query);
    $stmt->bind_param("s", $search_param);
} else {
    $count_query = "SELECT COUNT(*) as total FROM books";
    $stmt = $conn->prepare($count_query);
}

$stmt->execute();
$count_result = $stmt->get_result();
$total_row = $count_result->fetch_assoc();
$total_books = $total_row['total'];
$total_pages = ceil($total_books / $limit);

$stmt->close();

// Ambil data peminjaman
$query = "SELECT loans.id, user.username, user.grade, 
       COALESCE(books.title, 'Buku Telah Dihapus') AS title, 
       loans.borrow_date, loans.due_date, loans.return_date, loans.status 
        FROM loans
        JOIN user ON loans.user_id = user.id
        LEFT JOIN books ON loans.book_id = books.id
        ORDER BY loans.borrow_date DESC";

$result = $conn->query($query);

// Ambil username langsung dari session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Admin";

// Ambil jumlah total peminjam
$query_peminjam = "SELECT COUNT(DISTINCT user_id) AS total_peminjam FROM loans";
$result_peminjam = $conn->query($query_peminjam);
$row_peminjam = $result_peminjam->fetch_assoc();
$total_peminjam = $row_peminjam['total_peminjam'];

// Ambil jumlah total siswa
$query_siswa = "SELECT COUNT(*) AS total_siswa FROM user WHERE role = 'siswa'";
$result_siswa = $conn->query($query_siswa);
$row_siswa = $result_siswa->fetch_assoc();
$total_siswa = $row_siswa['total_siswa'];

// Ambil jumlah total peminjaman
$query_total_peminjaman = "SELECT COUNT(*) AS total_peminjaman FROM loans";
$result_total_peminjaman = $conn->query($query_total_peminjaman);
$row_total_peminjaman = $result_total_peminjaman->fetch_assoc();
$total_peminjaman = $row_total_peminjaman['total_peminjaman'];

$conn->close();

?>
