<?php
require_once('../config.php');
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Initialize or reset login attempts if not already set
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

if (isset($_SESSION['locked']) && $_SESSION['locked'] > time()) {
    $_SESSION['error'] = "Too many login attempts. Please try again later.";
    redirect('login.php');
    exit;
}

// Dummy authentication logic
if ($username === 'admin' && $password === 'admin') {
    $_SESSION['attempts'] = 0; // Reset attempts on successful login
    redirect('dashboard.php');
} else {
    $_SESSION['attempts']++;

    if ($_SESSION['attempts'] >= 7) {
        $_SESSION['locked'] = time() + (5 * 60); // Lock for 5 minutes
    }

    $_SESSION['error'] = "Invalid username or password.";
    redirect('login.php');
}
