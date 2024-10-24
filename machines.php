<?php
include 'db.php';

$message = "";

// Handle adding a machine
if (isset($_POST['add_machine'])) {
    $machine_name = $_POST['machine_name'];
    $machine_description = $_POST['machine_description'];
    $status = $_POST['status'];

    $sql = "INSERT INTO machines (machine_name, machine_description, status) VALUES ('$machine_name', '$machine_description', '$status')";
    if (mysqli_query($conn, $sql)) {
        $message = "Machine added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Handle updating a machine
if (isset($_POST['update_machine'])) {
    $id = $_POST['id'];
    $machine_name = $_POST['machine_name'];
    $machine_description = $_POST['machine_description'];
    $status = $_POST['status'];

    $sql = "UPDATE machines SET machine_name='$machine_name', machine_description='$machine_description', status='$status' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $message = "Machine updated successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Handle deleting a machine
if (isset($_GET['delete_machine'])) {
    $id = $_GET['delete_machine'];

    $sql = "DELETE FROM machines WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        $message = "Machine deleted successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fetch existing machines
$sql = "SELECT * FROM machines";
$result = mysqli_query($conn, $sql);
$machines = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Machine Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        h2, h3 {
            text-align: center;
        }
        form {
            margin: 20px;
            text-align: center;
        }
        input, textarea, select {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 100%;
            max-width: 300px;
        }
        button {
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
        }
        .delete-btn {
            background-color: red;
            color: white;
        }
        table {
            width: 80%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
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
    
    <h2>Manage Machines</h2>

    <!-- Display message if any -->
    <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>

    <!-- Add Machine Form -->
    <form action="machines.php" method="POST">
        <input type="text" name="machine_name" placeholder="Machine Name" required>
        <textarea name="machine_description" placeholder="Machine Description" required></textarea>
        <select name="status">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
        <button type="submit" name="add_machine">Add Machine</button>
    </form>

    <!-- Existing Machines Table -->
    <h3>Existing Machines</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Machine Name</th>
                <th>Machine Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="machine_table_body">
            <?php foreach ($machines as $machine): ?>
            <tr>
                <td><?php echo $machine['id']; ?></td>
                <td><?php echo htmlspecialchars($machine['machine_name']); ?></td>
                <td><?php echo htmlspecialchars($machine['machine_description']); ?></td>
                <td><?php echo htmlspecialchars($machine['status']); ?></td>
                <td>
                    <!-- Edit button -->
                    <button type="button" onclick="populateUpdateForm(<?php echo $machine['id']; ?>, '<?php echo addslashes($machine['machine_name']); ?>', '<?php echo addslashes($machine['machine_description']); ?>', '<?php echo $machine['status']; ?>')">Edit</button>
                    <!-- Delete button -->
                    <a href="machines.php?delete_machine=<?php echo $machine['id']; ?>" onclick="return confirm('Are you sure you want to delete this machine?');">
                        <button class="delete-btn" type="button">Delete</button>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Update Machine Form -->
    <h3>Update Machine</h3>
    <form action="machines.php" method="POST">
        <input type="hidden" name="id" id="machine_id" required>
        <input type="text" name="machine_name" id="machine_name" placeholder="Machine Name" required>
        <textarea name="machine_description" id="machine_description" placeholder="Machine Description" required></textarea>
        <select name="status" id="status">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
        <button type="submit" name="update_machine">Update Machine</button>
    </form>

    <!-- Button to Load Factory Logs -->
    <h3>Factory Logs</h3>
    <button id="load_logs_button" onclick="loadFactoryLogs()">Load Factory Logs</button>
    
    <!-- Search Functionality -->
    <input type="text" id="search_input" placeholder="Search by Machine Name" onkeyup="filterLogs()">
    <button id="search_button" onclick="filterLogs()">Search</button>
    
    <!-- Table to Display CSV Data -->
    <table id="factory_logs_table" style="display:none;">
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>Machine Name</th>
                <th>Temperature</th>
                <th>Pressure</th>
                <th>Vibration</th>
                <th>Humidity</th>
                <th>Power Consumption</th>
                <th>Operational Status</th>
                <th>Error Code</th>
                <th>Production Count</th>
                <th>Maintenance Log</th>
                <th>Speed</th>
            </tr>
        </thead>
        <tbody id="logs_table_body">
        </tbody>
    </table>

    <div id="pagination" style="display:none;">
        <button onclick="previousPage()">Previous</button>
        <button onclick="nextPage()">Next</button>
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

    <script>
        let csvData = [];
        let currentPage = 0;
        const rowsPerPage = 20;

        // Function to load CSV data
        function loadFactoryLogs() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'factory_logs.csv', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    csvData = xhr.responseText.split("\n").slice(1).filter(row => row.trim() !== ""); // Skip header row and empty rows
                    currentPage = 0; // Reset page
                    displayLogs();
                    document.getElementById('factory_logs_table').style.display = "table";
                    document.getElementById('pagination').style.display = "block";
                }
            };
            xhr.send();
        }

        // Function to display logs
        function displayLogs() {
            const start = currentPage * rowsPerPage;
            const end = start + rowsPerPage;
            const logsToDisplay = csvData.slice(start, end);
            const tableBody = document.getElementById('logs_table_body');
            tableBody.innerHTML = ''; // Clear previous rows

            logsToDisplay.forEach(log => {
                const cols = log.split(","); // Assuming comma as delimiter
                const row = tableBody.insertRow();
                cols.forEach(col => {
                    const cell = row.insertCell();
                    cell.textContent = col; // Populate the cells
                });
            });
        }

        // Function for next page
        function nextPage() {
            if ((currentPage + 1) * rowsPerPage < csvData.length) {
                currentPage++;
                displayLogs();
            }
        }

        // Function for previous page
        function previousPage() {
            if (currentPage > 0) {
                currentPage--;
                displayLogs();
            }
        }

        // Function to populate the update form
        function populateUpdateForm(id, name, description, status) {
            document.getElementById('machine_id').value = id;
            document.getElementById('machine_name').value = name;
            document.getElementById('machine_description').value = description;
            document.getElementById('status').value = status;
        }

        // Function to filter logs by machine name
        function filterLogs() {
            const input = document.getElementById('search_input').value.toLowerCase();
            const filteredLogs = csvData.filter(log => {
                const cols = log.split(",");
                return cols[1] && cols[1].toLowerCase().includes(input); // Assuming machine name is in the second column
            });
            const start = currentPage * rowsPerPage;
            const end = start + rowsPerPage;
            const logsToDisplay = filteredLogs.slice(start, end);
            const tableBody = document.getElementById('logs_table_body');
            tableBody.innerHTML = ''; // Clear previous rows

            logsToDisplay.forEach(log => {
                const cols = log.split(","); // Assuming comma as delimiter
                const row = tableBody.insertRow();
                cols.forEach(col => {
                    const cell = row.insertCell();
                    cell.textContent = col; // Populate the cells
                });
            });
        }

        // Load factory logs on page load
        window.onload = function() {
            loadFactoryLogs();
        };
    </script>
</body>
</html>
