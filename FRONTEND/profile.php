<?php
session_start();
require_once 'dbc.php';

// Redirect to login if user not logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// Get user data
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, weight, height, calorie_limit, age, gender, activity_level FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $weight, $height, $calorie_limit, $age, $gender, $activity_level);
$stmt->fetch();
$stmt->close();
$conn->close();

// BMR Calculation using Mifflin-St Jeor Equation
if ($gender == "male") {
    $bmr = 10 * $weight + 6.25 * $height - 5 * $age + 5; // for male
} else {
    $bmr = 10 * $weight + 6.25 * $height - 5 * $age - 161; // for female
}

// Activity factor based on activity level
switch ($activity_level) {
    case "sedentary":
        $activity_factor = 1.2;
        break;
    case "lightly_active":
        $activity_factor = 1.375;
        break;
    case "moderately_active":
        $activity_factor = 1.55;
        break;
    case "very_active":
        $activity_factor = 1.725;
        break;
    case "super_active":
        $activity_factor = 1.9;
        break;
    default:
        $activity_factor = 1.2; // Default to sedentary if unknown
}

// Calculate Total Daily Energy Expenditure (TDEE)
$tdee = !empty($calorie_limit) ? $calorie_limit : ($bmr * $activity_factor);

// Return profile data as JSON
echo json_encode([
    'success' => true,
    'name' => $name,
    'email' => $email,
    'calorie_limit' => round($tdee) // Rounded to the nearest whole number
]);
?>
