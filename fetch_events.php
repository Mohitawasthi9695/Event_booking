<?php
include 'includes/db_config.php';

$stmt = $pdo->query("SELECT `id`, `name`, `date`, `venue`, `available_seats` FROM `events` LIMIT 5");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($events as $event): ?>
    <div class="col-md-4 mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($event['name']) ?></h5>
                <p class="card-text">
                    <strong>Date:</strong> <?= htmlspecialchars($event['date']) ?><br>
                    <strong>Venue:</strong> <?= htmlspecialchars($event['venue']) ?><br>
                    <strong>Seats Available:</strong> <span
                        id="seats-<?= $event['id'] ?>"><?= htmlspecialchars($event['available_seats']) ?></span>
                </p>
                <button type="button" data-id="<?= $event['id'] ?>" class="btn btn-primary book-btn"
                    <?= $event['available_seats'] <= 0 ? 'disabled' : '' ?>>
                    Book Now
                </button>
            </div>
        </div>
    </div>
<?php endforeach; ?>