<?php
include 'db.php';
session_start();

if (isset($_POST['login_user'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header('Location: index.php');
    } else {
        echo "<h3>Invalid email or password!</h3>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General styles */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #007BFF;
            padding: 10px;
        }

        .navbar {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
        }

        .navbar li {
            display: inline;
        }

        .navbar li a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }

        h2 {
            text-align: center;
            color: #007BFF;
            margin-top: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        footer {
            margin-top: auto;
            background-color: #007BFF;
            padding: 20px;
            color: white;
            text-align: center;
        }

        .social-media {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .social-media li {
            margin: 0 10px;
        }

        .social-media li a {
            color: white;
        }

        .social-media li img {
            width: 24px;
            height: 24px;
        }

        footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
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

        <h2>User Login</h2>

        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login_user">Login</button>
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
    </div>
</body>
</html>
