<?php
include 'db.php';

// Handle adding a job
if (isset($_POST['add_job'])) {
    $job_name = $_POST['job_name'];
    $job_description = $_POST['job_description'];

    $sql = "INSERT INTO jobs (job_name, job_description) VALUES ('$job_name', '$job_description')";
    if (mysqli_query($conn, $sql)) {
        $message = "Job added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Handle updating a job
if (isset($_POST['update_job'])) {
    $id = $_POST['id'];
    $job_name = $_POST['job_name'];
    $job_description = $_POST['job_description'];

    $sql = "UPDATE jobs SET job_name='$job_name', job_description='$job_description' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $message = "Job updated successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Handle deleting a job
if (isset($_GET['delete_job'])) {
    $id = $_GET['delete_job'];

    $sql = "DELETE FROM jobs WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $message = "Job deleted successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fetch existing jobs for displaying
$sql = "SELECT * FROM jobs";
$result = mysqli_query($conn, $sql);
$jobs = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Management</title>
    <style>
        /* General styles */
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #eaf2f8;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        header {
            margin-bottom: 20px;
        }

        nav {
            background-color: #007BFF;
            padding: 10px;
            border-radius: 8px;
        }

        .navbar {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
        }

        .navbar li a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }

        h2, h3 {
            color: #007BFF;
            text-align: center;
            margin-bottom: 20px;
        }

        form, table {
            width: 100%;
            margin-bottom: 20px;
        }

        form input, form textarea, form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border: 1px solid #007BFF;
            border-radius: 8px;
            box-sizing: border-box;
        }

        form button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: #333;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
        }

        .action-buttons button, .action-buttons a {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            text-decoration: none;
            margin: 0 5px;
            border-radius: 8px;
        }

        .action-buttons a {
            background-color: #dc3545;
        }

        .action-buttons button:hover, .action-buttons a:hover {
            background-color: #218838;
        }

        .action-buttons a:hover {
            background-color: #c82333;
        }

        .update-form {
            margin-top: 20px;
        }

        .message {
            text-align: center;
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #007BFF;
            color: white;
            border-top: 4px solid #004f9e;
            margin-top: 20px;
        }

        footer .social-media {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        footer .social-media li {
            margin: 0 10px;
        }

        footer .social-media a img {
            width: 24px;
            height: 24px;
        }

        footer p {
            margin: 5px;
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
        <h2>Manage Jobs</h2>

        <!-- Display message if any -->
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>

        <!-- Add Job Form -->
        <h3>Add Job</h3>
        <form action="jobs.php" method="POST">
            <input type="text" name="job_name" placeholder="Job Name" required>
            <textarea name="job_description" placeholder="Job Description" required></textarea>
            <button type="submit" name="add_job">Add Job</button>
        </form>

        <!-- Existing Jobs Table -->
        <h3>Existing Jobs</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Name</th>
                    <th>Job Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?php echo $job['id']; ?></td>
                    <td><?php echo htmlspecialchars($job['job_name']); ?></td>
                    <td><?php echo htmlspecialchars($job['job_description']); ?></td>
                    <td class="action-buttons">
                        <button type="button" onclick="populateUpdateForm(<?php echo $job['id']; ?>, '<?php echo addslashes($job['job_name']); ?>', '<?php echo addslashes($job['job_description']); ?>')">Edit</button>
                        <a href="jobs.php?delete_job=<?php echo $job['id']; ?>" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Update Job Form -->
        <h3>Update Job</h3>
        <form action="jobs.php" method="POST" class="update-form">
            <input type="hidden" name="id" id="job_id" required>
            <input type="text" name="job_name" id="job_name" placeholder="Job Name" required>
            <textarea name="job_description" id="job_description" placeholder="Job Description" required></textarea>
            <button type="submit" name="update_job">Update Job</button>
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

    

    <script>
        function populateUpdateForm(id, name, description) {
            document.getElementById('job_id').value = id;
            document.getElementById('job_name').value = name;
            document.getElementById('job_description').value = description;
        }
    </script>
</body>
</html>
