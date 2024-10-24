<?php
include 'db.php';

if (isset($_POST['register_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if the email already exists
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) == 0) {
        // Insert new user into the database
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Email already exists!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul class="navbar">
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>
    <h2>User Registration</h2>

    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="User">User</option>
            <option value="Admin">Admin</option>
        </select>
        <button type="submit" name="register_user">Register</button>
    </form>

    <footer>
        <ul class="social-media">
            <li><a href="https://www.youtube.com" target="_blank"><img src="youtube.jpg" alt="YouTube"></a></li>
            <li><a href="https://www.facebook.com" target="_blank"><img src="facebook.png" alt="Facebook"></a></li>
            <li><a href="https://www.twitter.com" target="_blank"><img src="x.webp" alt="X"></a></li>
            <li><a href="https://www.linkedin.com" target="_blank"><img src="linkedin.webp" alt="LinkedIn"></a></li>
        </ul>
        <p>Contact Us: info@smartdashboard.com | +123 456 789</p>
        <p>&copy; 2024 Smart Manufacturing Dashboard. All rights reserved.</p>
    </footer>
</body>
</html>
