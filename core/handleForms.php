<?php
session_start();
require_once 'models.php';

// Prevent direct access to the file (only allow POST requests)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Unauthorized access.");
}

// Handle login form submission
if (isset($_POST['login'])) {
    // Sanitize input data to prevent XSS attacks
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Attempt to login using the provided username and password
    $user = checkLogin($username, $password);

    if ($user) {
        // Store the user in the session and regenerate session ID to prevent session fixation
        $_SESSION['user'] = $user;
        session_regenerate_id(true); // Prevent session fixation
        
        // Redirect based on user role
        if ($user['role'] === 'HR') {
            header("Location: employee.php"); // HR dashboard
        } else {
            header("Location: applicant.php"); // Applicant dashboard
        }
        exit();
    } else {
        // Set error message for invalid login
        $_SESSION['error'] = "Invalid username or password";
        header("Location: login.php");
        exit();
    }
}

// Handle registration form submission
if (isset($_POST['register'])) {
    // Sanitize input data to prevent XSS attacks
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $email = htmlspecialchars($_POST['email']);

    // Register the user and check if successful
    if (registerUser($first_name, $last_name, $username, $password, $email)) {
        $_SESSION['success'] = "Registration successful. You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
        header("Location: register.php");
        exit();
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    // Destroy session and redirect to homepage
    session_destroy();
    header("Location: index.php"); // Redirect to homepage
    exit();
}
?>
