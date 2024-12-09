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

$sql = "SELECT e.id AS event_id, e.name AS event_name, e.date AS event_date, e.fee_amount, 
        IFNULL(p.payment_status, 'unpaid') AS payment_status
        FROM events e
        LEFT JOIN payments p ON e.id = p.event_id AND p.student_id = $student_id
        ORDER BY e.date ASC";

$result = $conn->query($sql);

$total_paid_sql = "SELECT SUM(e.fee_amount) AS total_paid 
                   FROM payments p 
                   JOIN events e ON p.event_id = e.id 
                   WHERE p.student_id = $student_id AND p.payment_status = 'paid'";
$total_paid_result = $conn->query($total_paid_sql);
$total_paid_row = $total_paid_result->fetch_assoc();
$total_paid = $total_paid_row['total_paid'] ?? 0;

$total_fees_sql = "SELECT SUM(e.fee_amount) AS total_fees 
                   FROM events e
                   LEFT JOIN payments p ON e.id = p.event_id AND p.student_id = $student_id
                   WHERE p.student_id IS NULL OR p.payment_status = 'unpaid'";
$total_fees_result = $conn->query($total_fees_sql);
$total_fees_row = $total_fees_result->fetch_assoc();
$total_fees = $total_fees_row['total_fees'] ?? 0;

$conn->close();
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
        <h2>Fee Status</h2>

        <div class="alert alert-info">
            <strong>Total Paid: ₱<?php echo number_format($total_paid, 2); ?></strong><br>
            <strong>Total Unpaid Fees: ₱<?php echo number_format($total_fees, 2); ?></strong>
        </div>

        <h4>Events/Programs Payment Status</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Event/Program Name</th>
                    <th>Event/Program Date</th>
                    <th>Fee Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($event = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                            <td>₱<?php echo number_format($event['fee_amount'], 2); ?></td>
                            <td>
                                <?php if ($event['payment_status'] == 'paid'): ?>
                                    <span class="badge badge-success">Paid</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Unpaid</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($event['payment_status'] == 'unpaid'): ?>
                                    <a href="payment.php?event_id=<?php echo $event['event_id']; ?>" class="btn btn-primary">Pay Now</a>
                                <?php else: ?>
                                    <button class="btn btn-secondary" disabled>Paid</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">No events found.</td></tr>
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
