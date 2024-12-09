<?php
$conn = new mysqli('localhost', 'root', '', 'student_portal');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $studentId = $_POST['studentId'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $phoneNumber = $_POST['phoneNumber'];
    $guardianName = $_POST['guardianName'];
    $guardianNumber = $_POST['guardianNumber'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $photo = $_FILES['photo']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

    $sql = "INSERT INTO students (full_name, student_id, course, year, section, phone_number, guardian_name, guardian_phone_number, password, photo) 
            VALUES ('$fullName', '$studentId', '$course', '$year', '$section', '$phoneNumber', '$guardianName', '$guardianNumber', '$password', '$photo')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student successfully registered'); window.location.href='student-login.php';</script>";
        // header("Location: student-login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="text-right mb-3">
            <button type="button" class="btn btn-light" onclick="goBack()" style="border: none; background-color: transparent;">
                <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; color: #000;"></i>
            </button>
        </div>

        <h2 class="text-center">Sign Up</h2>
        <form class="mt-4" action="" method="POST" enctype="multipart/form-data" onsubmit="return validatePasswords();">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter Full Name" required>
            </div>
            <div class="form-group">
                <label for="studentId">ID Number</label>
                <input type="text" class="form-control" id="studentId" name="studentId" placeholder="Enter ID Number" required>
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <select class="form-control" id="course" name="course" required>
                    <option value="" disabled selected>Select Course</option>
                    <option value="BSED: Major in Social Studies">BSED: Major in Social Studies</option>
                    <option value="BSED: Major in Mathematics">BSED: Major in Mathematics</option>
                    <option value="BTVTED: Major in Garments Fashion and Design">BTVTED: Major in Garments Fashion and Design</option>
                    <option value="BTVTED: Major in Electrical Technology">BTVTED: Major in Electrical Technology</option>
                    <option value="BTVTED: Major in Electronics Technology">BTVTED: Major in Electronics Technology</option>
                    <option value="BSIT">BSIT</option>
                    <option value="DAT">DAT</option>
                    <option value="BAT">BAT</option>
                </select>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <select class="form-control" id="year" name="year" required>
                    <option value="" disabled selected>Select Year</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                </select>
            </div>
            <div class="form-group">
                <label for="section">Section</label>
                <select class="form-control" id="section" name="section" required>
                    <option value="" disabled selected>Select Section</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter Phone Number" required>
            </div>
            <div class="form-group">
                <label for="guardianName">Parent/Guardian Name</label>
                <input type="text" class="form-control" id="guardianName" name="guardianName" placeholder="Enter Parent/Guardian Name" required>
            </div>
            <div class="form-group">
                <label for="guardianNumber">Parent/Guardian Contact Number</label>
                <input type="tel" class="form-control" id="guardianNumber" name="guardianNumber" placeholder="Enter Parent/Guardian Contact Number" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <label for="photo">Upload Photo</label>
                <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
            <p class="text-center mt-3">
                Don't have an account? <a href="student-login.php">Login</a>
            </p>
        </form>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }

        function validatePasswords() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
