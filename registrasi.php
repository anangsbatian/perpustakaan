<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiuser Registration</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new mysqli("localhost", "root", "", "perpustakaan1");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $username = $conn->real_escape_string($_POST['username']);
        $no_induk = $conn->real_escape_string($_POST['no_induk']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirm_password = $conn->real_escape_string($_POST['confirm_password']);
        $role = $conn->real_escape_string($_POST['role']);

        if ($password !== $confirm_password) {
            echo "<p style='color: red; text-align: center;'>Passwords do not match!</p>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (username, no_induk, password, grade, role) VALUES ('$username','$no_induk', '$hashed_password','$grade', '$role')";

            if ($conn->query($sql) === TRUE) {
                echo "<p style='color: green; text-align: center;'>Registration successful! <a href='index.php'>Login here</a></p>";
            } else {
                echo "<p style='color: red; text-align: center;'>Error: " . $conn->error . "</p>";
            }
        }

        $conn->close();
    }
    ?>

    <div class="register-container">
        <h2>Multiuser Registration</h2>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="no_induk" placeholder="Masukkan NISN/NIDN" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="text" name="grade" placeholder="grade" required>
            <select name="role" required>
                <option value="siswa">Siswa</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="index.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
