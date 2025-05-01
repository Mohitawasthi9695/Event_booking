<?php
include_once 'includes/db_config.php';
include_once 'includes/header.php';
?>
<div class="col-sm-6 justify-content align-item-center mx-auto mt-5 border-1 shadow-sm p-3 m-5 rounded">
    <h2 class="text-center">User Login</h2>
    <p class="text-center">Please enter your username and password to login.</p>
    <div class="card border-1 shadow-sm p-2">
        <form id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <p class="text-center mt-3">Don't have an account? <a href="signup.php">Register here</a></p>
</div>
<script>
    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            e.preventDefault(); 
            const formData = {
                username: $('#username').val(),
                password: $('#password').val()
            };

            $.ajax({
                url: 'logincheck.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful',
                            text: response.message
                        }).then(() => {
                            window.location.href = 'index.php'; 
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: response.message
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'An unexpected error occurred.'
                    });
                }
            });
        });
    });
</script>
<?php
include_once 'includes/footer.php';
?>