<?php
include_once 'includes/db_config.php';
include_once 'includes/header.php';
?>

<!-- Main Container -->
<div class="container">
    <div class="row">
        <div class="col-sm-6 mx-auto mt-5 shadow-sm p-4 rounded">
            <h2 class="text-center">User Register</h2>
            <p class="text-center">Please enter your username, email, and password to register.</p>
            <div class="card p-3">
                <form id="registerForm" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- jQuery Validation Plugin -->

<script>
    $(document).ready(function () {
        $('#registerForm').validate({
            errorClass: 'text-danger',
            rules: {
                username: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                password_confirmation: {
                    equalTo: "Passwords do not match"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: 'signup_action.php',
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message
                            }).then(() => {
                                window.location.href = 'login.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: response.message,
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong. Try again!',
                            confirmButtonText: 'Close'
                        });
                    }
                });
            }
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>