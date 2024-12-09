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

$courses = [
    "BSED: Major in Social Studies",
    "BSED: Major in Mathematics",
    "BTVTED: Major in Garments Fashion and Design",
    "BTVTED: Major in Electrical Technology",
    "BTVTED: Major in Electronics Technology",
    "BSIT",
    "DAT",
    "BAT"
];
$years = ["1st Year", "2nd Year", "3rd Year", "4th Year"];
$sections = ["A", "B", "C", "D"];

$selected_course = isset($_POST['course']) ? $conn->real_escape_string($_POST['course']) : '';
$selected_year = isset($_POST['year']) ? $conn->real_escape_string($_POST['year']) : '';
$selected_section = isset($_POST['section']) ? $conn->real_escape_string($_POST['section']) : '';

$students_sql = "SELECT s.student_id, s.full_name, s.year, s.course, s.section, 
                        p.payment_status
                 FROM students s
                 LEFT JOIN payments p ON s.student_id = p.student_id
                 WHERE 
                    ('' = '$selected_course' OR s.course = '$selected_course') AND
                    ('' = '$selected_year' OR s.year = '$selected_year') AND
                    ('' = '$selected_section' OR s.section = '$selected_section')
                 GROUP BY s.student_id";
$students_result = $conn->query($students_sql);
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
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <h2 class="mt-5">Filter Students</h2>
        <form method="POST">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="course">Course</label>
                    <select class="form-control" name="course">
                        <option value="">Select Course</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo htmlspecialchars($course); ?>" <?php echo ($course == $selected_course) ? 'selected' : ''; ?>><?php echo htmlspecialchars($course); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="year">Year</label>
                    <select class="form-control" name="year">
                        <option value="">Select Year</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo htmlspecialchars($year); ?>" <?php echo ($year == $selected_year) ? 'selected' : ''; ?>><?php echo htmlspecialchars($year); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="section">Section</label>
                    <select class="form-control" name="section">
                        <option value="">Select Section</option>
                        <?php foreach ($sections as $section): ?>
                            <option value="<?php echo htmlspecialchars($section); ?>" <?php echo ($section == $selected_section) ? 'selected' : ''; ?>><?php echo htmlspecialchars($section); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <h2 class="mt-5">Students List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Year</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Fee Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($students_result->num_rows > 0): ?>
                    <?php while($student = $students_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($student['year']); ?></td>
                            <td><?php echo htmlspecialchars($student['course']); ?></td>
                            <td><?php echo htmlspecialchars($student['section']); ?></td>
                            <td>
                                <?php 
                                    if ($student['payment_status'] == 'paid') {
                                        echo '<span class="badge badge-success">Paid</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Unpaid</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">No students found.</td></tr>
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
