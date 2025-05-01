<?php
session_start();
require_once 'includes/db_config.php';
header('Content-Type: application/json');
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$password_confirmation = $_POST['password_confirmation'];

if ($password !== $password_confirmation) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
    exit;
}

// Check if email already exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
$stmt->execute([$email, $username]);
$user = $stmt->fetch();

if ($user) {
    // Check which field caused the conflict
    $stmtEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmtEmail->execute([$email]);
    if ($stmtEmail->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
        exit;
    }

    $stmtUsername = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmtUsername->execute([$username]);
    if ($stmtUsername->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Username already taken.']);
        exit;
    }
}

// All clear, insert user
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
if ($stmt->execute([$username, $email, $hashedPassword])) {
    echo json_encode(['status' => 200, 'message' => 'Registration complete.']);
} else {
    echo json_encode(['status' => 202, 'message' => 'Registration failed. Try again later.']);
}
?>
