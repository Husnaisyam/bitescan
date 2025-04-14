<?php
session_start();
require_once 'dbc.php';

// If login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $email, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Store user info in session
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;

            // Redirect to profile page
            header("Location: profile.html");
            exit();
        } else {
            echo "<script>alert('Invalid password'); window.location.href = 'index.html';</script>";
        }
    } else {
        echo "<script>alert('Email not registered'); window.location.href = 'index.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
