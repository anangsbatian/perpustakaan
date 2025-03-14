function openPopup(student) {
    document.getElementById("edit-id").value = student.id;
    document.getElementById("edit-username").value = student.username;
    document.getElementById("edit-grade").value = student.grade;
    document.getElementById("edit-password").value = ""; // Biarkan kosong
    document.getElementById("popup").style.display = "block";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}
