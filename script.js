function openPopup(action, book = null) {
    document.getElementById("popup").style.display = "block";
    document.getElementById("form-action").value = action;
    document.getElementById("popup-title").innerText = action === "create" ? "Tambah Buku" : "Edit Buku";
    
    if (action === "edit" && book) {
        document.getElementById("book-id").value = book.id;
        document.getElementById("title").value = book.title;
        document.getElementById("author").value = book.author;
        document.getElementById("publisher").value = book.publisher;
        document.getElementById("isbn").value = book.isbn;
        document.getElementById("category").value = book.category;
        document.getElementById("shelf_location").value = book.shelf_location;
        document.getElementById("deskripsi").value = book.deskripsi;
        document.getElementById("stock").value = book.stock;
    } else {
        document.getElementById("bookForm").reset();
    }
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}

function openBookDetail(bookId) {
    fetch(`get_book_detail.php?id=${bookId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("book-image").src = data.image_url;
            document.getElementById("book-title").textContent = data.title;
            document.getElementById("book-author").textContent = data.author;
            document.getElementById("book-description").textContent = data.description;
            document.getElementById("book-stock").textContent = data.stock;

            document.getElementById("book-detail-popup").style.display = "block";
        })
        .catch(error => console.error('Error:', error));
}

function closeBookDetail() {
    document.getElementById("book-detail-popup").style.display = "none";
}



