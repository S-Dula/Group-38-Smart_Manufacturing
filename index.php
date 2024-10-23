<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Manufacturing Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Full viewport height */
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        header {
            background-color: #007BFF; /* Blue background for the navbar */
            padding: 20px 0; /* Increased padding to make the navbar taller */
        }

        nav ul.navbar {
            list-style-type: none;
            display: flex;
            justify-content: center;
        }

        nav ul.navbar li {
            margin: 0 15px;
        }

        nav ul.navbar li a {
            color: white; /* White font color for the navbar */
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

        nav ul.navbar li a:hover {
            text-decoration: underline;
        }

        .content {
            padding: 20px;
            text-align: center;
            flex-grow: 1; /* Allow content to grow and take available space */
        }

        .dashboard-nav {
            margin-top: 20px; /* Space between main content and dashboard nav */
        }

        .dashboard-nav ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
        }

        .dashboard-nav ul li {
            margin: 0 15px;
        }

        .dashboard-nav ul li a {
            text-decoration: none;
            color: white; /* White color for dashboard links */
            font-weight: bold;
        }

        .dashboard-nav ul li a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #007BFF; /* Blue background for the footer */
            color: white; /* White font color for footer text */
            padding: 20px;
            text-align: center;
            margin-top: auto; /* Push the footer to the bottom */
        }

        footer ul.social-media {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        footer ul.social-media li {
            margin: 0 10px;
        }

        footer ul.social-media li img {
            width: 24px;
            height: 24px;
        }

        footer p {
            margin: 5px 0;
        }
    </style>
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

    <div class="content">
        <h1>Welcome to the Smart Manufacturing Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <nav class="dashboard-nav">
            <ul>
                <li><a href="jobs.php">Manage Jobs</a></li>
                <li><a href="machines.php">Manage Machines</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

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
