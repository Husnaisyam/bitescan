<?php
session_start();
require_once 'dbc.php';

// Redirect to login if user not logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// Get user data from POST
$data = file_get_contents('php://input');
if(empty($data)){
    echo json_encode(['success' => false, 'error' => 'Failed to update profile.']);
    die;
}
$data = json_decode($data);
$username = $data->name;
$email = $data->email;
$calories = $data->calorie_limit;

// Handle Profile Picture Upload
$profilePicPath = null; // No need to store this in the DB

if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
    $profilePic = $_FILES['profilePic'];
    $targetDir = "uploads/";

    // Ensure the directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Sanitize the file name to avoid issues
    $fileName = time() . "_" . basename($profilePic["name"]);
    $targetFile = $targetDir . $fileName;

    // Check file type and size
    $validFileTypes = ['jpg', 'jpeg', 'png'];
    $fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
    if (in_array($fileExtension, $validFileTypes) && $profilePic["size"] < 5000000) {
        // Move the file to the upload directory
        if (move_uploaded_file($profilePic["tmp_name"], $targetFile)) {
            // Profile picture uploaded successfully
            echo json_encode(['success' => true, 'message' => 'Profile picture uploaded successfully']);
            exit();
        } else {
            echo json_encode(['success' => false, 'error' => 'Error uploading image.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid file type or size.']);
        exit();
    }
}

// Update the database without profile picture
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("UPDATE users SET `name` = ?, email = ?, calorie_limit = ? WHERE id = ?");
$stmt->bind_param("sssi", $username, $email, $calories, $user_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update profile.']);
}

$stmt->close();
$conn->close();
?>
