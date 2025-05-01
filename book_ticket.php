<?php
session_start();
include 'includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}else
{
    $user_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = (int) $_POST['event_id'];
    $pdo->beginTransaction();

    // Lock the row to prevent race condition
    $stmt = $pdo->prepare("SELECT available_seats FROM events WHERE id = ? FOR UPDATE");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        echo json_encode(['success' => false, 'message' => 'Event not found.']);
        exit;
    }

    if ($event['available_seats'] <= 0) {
        echo json_encode(['success' => false, 'message' => 'No seats available.']);
        exit;
    }

    // Reduce available seats
    $stmt = $pdo->prepare("UPDATE events SET available_seats = available_seats - 1 WHERE id = ?");
    $stmt->execute([$event_id]);

    // Insert booking record
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, event_id, booked_at) VALUES (?, ?, NOW())");
    $stmt->execute([$user_id, $event_id]);

    // Commit transaction
    $pdo->commit();

    // Fetch new seat count
    $stmt = $pdo->prepare("SELECT available_seats FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $updated = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'message' => 'Ticket booked successfully!', 'available_seats' => $updated['available_seats']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
