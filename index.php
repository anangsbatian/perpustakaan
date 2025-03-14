<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login</title>
    <link rel="stylesheet" href="style3.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    

    <div class="login-container">
        <h2> Login</h2>
        <?php
        // Display error message if login fails
        if (!empty($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
        <form action="proses.php" method="POST">
            <input type="text" name="no_induk" placeholder="Masukkan NISN/NIDN" required>
            <input type="password" name="password" placeholder="Masukkan Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="registrasi.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
