<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'student_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header("Location: admin-login.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM admins WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $username = $result->fetch_assoc();
    $username = $username['username'];
} else {
    echo "Student not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event and Program Fee Management System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            margin-top: 20px;
            max-width: 400px;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        .dashboard-link {
            margin: 10px 0;
            display: block;
        }
        .logout-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <h3><?php echo htmlspecialchars($username); ?></h3> 
        <h3 class="mt-4">Admin Dashboard</h3>
        <a href="create.php" class="btn btn-primary dashboard-link">Create Event/Program</a>
        <a href="students-list.php" class="btn btn-secondary dashboard-link">Students List</a>
        <a href="events-programs.php" class="btn btn-success dashboard-link">Events and Programs</a>
        <a href="other-feature.php" class="btn btn-info dashboard-link">Other Features</a>

        <a href="choose-role.html" class="btn btn-danger logout-button">Sign Out</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
