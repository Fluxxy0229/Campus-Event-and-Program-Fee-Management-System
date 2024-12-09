<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'student_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['student_id'])) {
    header("Location: student-login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM students WHERE student_id = '$student_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $full_name = $student['full_name'];
    $photo = $student['photo'];
} else {
    echo "Student not found.";
    exit();
}

$notifications = $conn->query("SELECT message, created_at FROM notifications WHERE student_id = '$student_id' AND is_read = FALSE ORDER BY created_at DESC");

$conn->query("UPDATE notifications SET is_read = TRUE WHERE student_id = '$student_id'");

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
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .dashboard-link {
            margin: 10px 0;
            display: block;
        }
        .logout-button {
            margin-top: 20px;
        }
        .notification-container {
            margin-top: 20px;
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
        }
        .notification-item {
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .notification-date {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <img src="uploads/<?php echo htmlspecialchars($photo); ?>" alt="Student Photo" class="profile-img">
        <h2><?php echo htmlspecialchars($full_name); ?></h2>
        <p class="h6">ID: <?php echo htmlspecialchars($student_id); ?></p>

        <h3 class="mt-4">Dashboard</h3>
        <a href="fee-status.php" class="btn btn-primary dashboard-link">Fee Status</a>
        <a href="payment-history.php" class="btn btn-secondary dashboard-link">Payment History</a>
        <a href="students-events-programs.php" class="btn btn-success dashboard-link">Events and Programs</a>
        <a href="other-feature.php" class="btn btn-info dashboard-link">Other Features</a>

        <a href="choose-role.html" class="btn btn-danger logout-button">Sign Out</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
