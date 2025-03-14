<?php
include 'koneksi.php';
include 'proses.php';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta charset="UTF-8">
    <title>Manajemen Buku</title>
    
</head>
<body>
    <div class="sidebar">
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <ul>
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="manage_books.php">Manage Books</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="history.php">History</a></li>
            <li><a href="guide.php">Guide</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    
    <div class="main-content">
        <div class="header-container">
            <h2>Book List</h2>

            <div class="search-add-container">
                <form method="GET" class="search-container">
                    <input type="text" name="search_category" id="search-category" placeholder="Cari kategori">
                    <button type="submit" class="fa fa-search"></button>
                </form>

                <a href="ExportExcel.php" class="btn btn-success">
                    <i class="fas fa-file-excel"></i>
                </a>

                <button class="btn btn-primary" onclick="openPopup('create')">
                    <i class="fas fa-plus"></i> 
                </button>
            </div>
        </div>
        
        
        <!-- Popup Form -->
        <div id="popup" class="popup-container">
            <div class="popup-content">
                <div class='popup-header'>
                    <span class="close" onclick="closePopup()">&times;</span>
                </div>
                <h2 id="popup-title">Tambah Buku</h2>
                <form id="bookForm" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="action" id="form-action" value="create">
                    <input type="hidden" name="id" id="book-id">
                    
                    <label>Judul:</label>
                    <input type="text" name="title" id="title" required><br>
                    
                    <label>Pengarang:</label>
                    <input type="text" name="author" id="author" required><br>
                    
                    <label>Penerbit:</label>
                    <input type="text" name="publisher" id="publisher"><br>
                    
                    <label>ISBN:</label>
                    <input type="text" name="isbn" id="isbn"><br>
                    
                    <label>Kategori:</label>
                    <select name="category" id="category" onchange="checkOtherCategory(this)">
                        <option value="">Pilih Kategori</option>
                        <option value="sains&teknologi">Sains & Teknologi</option>
                        <option value="alam&sosial">Alam & Sosial</option>
                        <option value="seni&budaya">Seni & Budaya</option>
                        <option value="hiburan&olahraga">Hiburan & Olahraga</option>
                        <option value="agama">Agama</option>
                        <option value="matematika">Matematika</option>
                        <option value="other">Lainnya</option>
                    </select>
                    <input 
                        type="text" 
                        name="custom_category" 
                        id="custom_category" 
                        placeholder="Tulis kategori lain" 
                        style="display:none;" 
                        oninput="setCustomCategory(this.value)"
                    ><br>

                    <script>
                        function checkOtherCategory(select) {
                            const customCategoryInput = document.getElementById('custom_category');
                            if (select.value === 'other') {
                                customCategoryInput.style.display = 'inline';
                                customCategoryInput.required = true;
                            } else {
                                customCategoryInput.style.display = 'none';
                                customCategoryInput.required = false;
                                customCategoryInput.value = '';
                            }
                        }

                        function setCustomCategory(value) {
                            document.getElementById('category').value = value;
                        }
                    </script>
                    
                    <label>Lokasi Rak:</label>
                    <input type="text" name="shelf_location" id="shelf_location"><br>
                    
                    <label>Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi"></textarea><br>
                    
                    <label>Stok:</label>
                    <input type="number" name="stock" id="stock"><br>
                    
                    <label>Cover:</label>
                    <input type="file" name="cover_image" id="cover_image"><br>
                    
                    <button type="save">Save</button>
                </form>
            </div>
        </div>

        <div class='header-container'>
            
                
            
        </div>
        <table border="1">
            <tr>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>ISBN</th>
                <th>Kategori</th>
                <th>Lokasi Rak</th>
                <th>Deskripsi</th>
                <th>Tersedia</th>
                <th>Cover</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><a href="detail_buku.php?id=<?= $book['id'] ?>"><?= htmlspecialchars($book['title']) ?></a></td>
                    <td><?= htmlspecialchars($book['author']) ?></td>
                    <td><?= htmlspecialchars($book['publisher'])?></td>
                    <td><?= htmlspecialchars($book['isbn'])?></td>
                    <td><?= htmlspecialchars($book['category'])?></td>
                    <td><?= htmlspecialchars($book['shelf_location'])?></td>
                    <td><?= mb_strimwidth(htmlspecialchars($book['deskripsi']), 0, 50, "...") ?></td>
                    <td><?= htmlspecialchars($book['stock'])?></td>
                    <td><img src="<?= htmlspecialchars($book['cover_image']) ?>" width="50"></td>
                    <td>
                        <button class='fa-solid fa-pen-to-square' onclick="openPopup('edit', <?= htmlspecialchars(json_encode($book)) ?>)"></button>
                        <a href="?action=delete&id=<?= $book['id'] ?>" onclick="return confirm('Hapus buku ini?')">
                            <button class='fa-solid fa-trash'></button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <!-- Navigasi Halaman -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"> <?= $i ?> </a>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="script.js"></script>

</body>
</html>


