<?php
include_once 'includes/db_config.php';
header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Username and password required.']);
    exit;
}

// Sample query — use prepared statements
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // You can start session and store user info
    session_start();
    $_SESSION['user_id'] = $user['id'];
    echo json_encode(['status' => 'success', 'message' => 'Login successful.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
}
