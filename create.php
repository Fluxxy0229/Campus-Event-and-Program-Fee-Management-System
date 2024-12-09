<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'student_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_event'])) {
    $event_name = $conn->real_escape_string($_POST['event_name']);
    $event_date = $conn->real_escape_string($_POST['event_date']);
    $fee_amount = $conn->real_escape_string($_POST['fee_amount']);
    $due_date = !empty($_POST['due_date']) ? $conn->real_escape_string($_POST['due_date']) : NULL;
    $event_description = $conn->real_escape_string($_POST['event_description']);

    $sql = "INSERT INTO events (name, date, fee_amount, due_date, description) 
            VALUES ('$event_name', '$event_date', '$fee_amount', " . 
            ($due_date ? "'$due_date'" : "NULL") . ", '$event_description')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Event created successfully!";
    } else {
        $error_message = "Error creating event: " . $conn->error;
    }
}
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
    <h2>Create Event/Program</h2>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="event_name">Event/Program Name</label>
            <input type="text" class="form-control" name="event_name" required>
        </div>
        <div class="form-group">
            <label for="event_date">Event/Program Date</label>
            <input type="date" class="form-control" name="event_date" required>
        </div>
        <div class="form-group">
            <label for="fee_amount">Registration Fee Amount</label>
            <input type="number" class="form-control" name="fee_amount" required>
        </div>
        <div class="form-group">
            <label for="due_date">Payment Due Date</label>
            <input type="date" class="form-control" name="due_date">
        </div>
        <div class="form-group">
            <label for="event_description">Description</label>
            <textarea class="form-control" name="event_description" required></textarea>
        </div>
        <button type="submit" name="create_event" class="btn btn-primary">Create</button>
    </form>
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
