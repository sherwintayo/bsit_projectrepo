<?php
require_once('../config.php');

session_start();

// Function to get the current timestamp
function get_current_time() {
    return time();
}

// Initialize login attempt tracking
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = 0;
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Example user validation (replace with actual validation)
    $is_valid_user = false; // Replace with your validation logic

    // Check if account is locked
    if ($_SESSION['lockout_time'] > get_current_time()) {
        $remaining_time = $_SESSION['lockout_time'] - get_current_time();
        echo json_encode(['status' => 'locked', 'time' => $remaining_time]);
        exit;
    }

    if ($is_valid_user) {
        // Reset login attempts on successful login
        $_SESSION['login_attempts'] = 0;
        echo json_encode(['status' => 'success']);
    } else {
        $_SESSION['login_attempts']++;

        if ($_SESSION['login_attempts'] >= 7) {
            // Lock account for 5 minutes
            $_SESSION['lockout_time'] = get_current_time() + 300;
            echo json_encode(['status' => 'locked', 'time' => 300]);
        } else {
            $attempts_left = 7 - $_SESSION['login_attempts'];
            echo json_encode(['status' => 'failed', 'attempts_left' => $attempts_left]);
        }
    }
}
?>
