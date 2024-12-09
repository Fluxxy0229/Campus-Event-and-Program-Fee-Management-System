<?php
if (!isset($_GET['event_id'])) {
    die("Event ID is required.");
}

$event_id = $_GET['event_id'];
$conn = new mysqli('localhost', 'root', '', 'student_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM events WHERE id = $event_id";
$result = $conn->query($sql);
$event = $result->fetch_assoc();

if (!$event) {
    die("Event not found.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Event and Program Fee Management System - <?php echo htmlspecialchars($event['name']); ?></title>
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
        <h2>Payment for Event: <?php echo htmlspecialchars($event['name']); ?></h2>
        <p>Event Date: <?php echo htmlspecialchars($event['date']); ?></p>
        <p>Fee Amount: ₱<?php echo number_format($event['fee_amount'], 2); ?></p>

        <form action="process_payment.php" method="POST">
            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
            <div class="form-group">
                <label for="gcash_number">Enter your GCash Number</label>
                <input type="text" class="form-control" name="gcash_number" required>
            </div>
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
        </form>
    </div>
</body>
</html>

<script>
    function goBack() {
    window.history.back();
}
</script>

<?php
$conn->close();
?>
