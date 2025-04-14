<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bitescan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Encrypt password
    $weight = floatval($_POST['weight']);
    $height = floatval($_POST['height']);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];
    $activity_level = $_POST['activity_level'];

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email already registered. Please log in.'); window.location.href = 'index.html';</script>";
        $check->close();
        $conn->close();
        exit();
    }
    $check->close();

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, weight, height, age, gender, activity_level) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssddiss", $name, $email, $password, $weight, $height, $age, $gender, $activity_level);

    if ($stmt->execute()) {
        // Redirect to signin.html
        echo "<script>alert('Successfully registered. Please log in to continue.'); window.location.href = 'index.html';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
