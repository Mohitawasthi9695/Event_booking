<?php
include_once 'includes/db_config.php';
include_once 'includes/header.php';
?>
<?php session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
} else {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("
    SELECT b.id, e.name AS event_name, e.date, e.venue, b.booked_at
    FROM bookings b
    JOIN events e ON b.event_id = e.id
    WHERE b.user_id = ?
    ORDER BY b.booked_at DESC
");
    $stmt->execute([$user_id]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<div class="row">
    <div class="col-md-3">
        <?php include_once 'includes/sidebar.php'; ?>
    </div>
    <div class="col-md-9">
    <div class="container mt-5">
        <h3 class="mb-4">My Booked Events</h3>
        <table id="bookingsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Booked At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $index => $booking): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($booking['event_name']) ?></td>
                        <td><?= htmlspecialchars($booking['date']) ?></td>
                        <td><?= htmlspecialchars($booking['venue']) ?></td>
                        <td><?= htmlspecialchars($booking['booked_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>  

    <script>
        $(document).ready(function () {
            $('#bookingsTable').DataTable({
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50],
                "order": [[4, "desc"]]
            });
        });
    </script>
    <?php include_once 'includes/footer.php'; ?>