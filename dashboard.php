<?php
include_once 'includes/db_config.php';
include_once 'includes/header.php';
?>
<?php session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
} ?>
<div class="row">
    <div class="col-md-3">
        <?php include_once 'includes/sidebar.php'; ?>
    </div>
    <div class="col-md-9">
        <div class="row" id="event-container">
            <!-- Events will be loaded here via AJAX -->
        </div>
    </div>
    <script>
        function loadEvents() {
            $('#event-container').load('fetch_events.php', function () {
                $('.book-btn').click(function () {
                    const eventId = $(this).data('id');
                    const button = $(this);
                    button.prop('disabled', true);

                    $.ajax({
                        url: 'book_ticket.php',
                        type: 'POST',
                        data: { event_id: eventId },
                        success: function (response) {
                            const res = JSON.parse(response);
                            if (res.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: true,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: res.message
                                });
                            }
                            loadEvents();
                        },
                        error: function () {
                            Swal.fire('Error', 'Something went wrong.', 'error');
                            button.prop('disabled', false);
                        }
                    });
                });
            });
        }
        $(document).ready(function () {
            loadEvents();
        });
    </script>
    <?php include_once 'includes/footer.php'; ?>