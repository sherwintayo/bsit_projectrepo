<?php
require_once('../config.php');

session_start();

// Function to get the user's IP address
function getIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Initialize variables
$ip = getIpAddr();
$maxAttempts = 7;
$lockoutTime = 5 * 60; // 5 minutes in seconds
$currentTime = time();

// Check login attempts based on IP
$login_attempts_query = mysqli_query($conn, "SELECT COUNT(*) as total_count, MAX(login_time) as last_attempt FROM ip_details WHERE ip='$ip' AND login_time > ($currentTime - $lockoutTime)");
$res = mysqli_fetch_assoc($login_attempts_query);
$attempts = $res['total_count'];
$last_attempt_time = $res['last_attempt'] ?? 0;

if ($attempts >= $maxAttempts && ($currentTime - $last_attempt_time) < $lockoutTime) {
    $remaining_time = $lockoutTime - ($currentTime - $last_attempt_time);
    echo json_encode(['status' => 'locked', 'time' => $remaining_time]);
    exit;
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Example user validation (replace with actual validation)
    $is_valid_user = false; // Replace with your validation logic

    if ($is_valid_user) {
        // Successful login
        mysqli_query($conn, "DELETE FROM ip_details WHERE ip='$ip'"); // Clear attempts after successful login
        echo json_encode(['status' => 'success']);
    } else {
        // Record the failed login attempt
        mysqli_query($conn, "INSERT INTO ip_details (ip, login_time) VALUES ('$ip', '$currentTime')");

        $attempts_left = $maxAttempts - ($attempts + 1);
        if ($attempts_left <= 0) {
            echo json_encode(['status' => 'locked', 'time' => $lockoutTime]);
        } else {
            echo json_encode(['status' => 'failed', 'attempts_left' => $attempts_left]);
        }
    }
}
?>
