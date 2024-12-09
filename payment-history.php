<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['student_id'])) {
    header("Location: student-login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'student_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_SESSION['student_id'];

$sql = "SELECT e.name AS event_name, p.payment_date, e.fee_amount, p.payment_status 
        FROM payments p 
        JOIN events e ON p.event_id = e.id
        WHERE p.student_id = $student_id
        ORDER BY p.payment_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event and Program Fee Management System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
    <div class="text-right mb-3">
            <button type="button" class="btn btn-light" onclick="goBack()" style="border: none; background-color: transparent;">
                <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; color: #000;"></i>
            </button>
        </div>
        <h2>Your Payment History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Events/Programs Name</th>
                    <th>Payment Date</th>
                    <th>Fee Amount</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_date']); ?></td>
                            <td><?php echo number_format($row['fee_amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No payment history available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <script>
        function goBack() {
    window.history.back();
}
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
