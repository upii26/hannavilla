<?php
include "process/config.php";
session_start();

if (isset($_POST['verify'])) {
    $entered_otp = $_SESSION['otp'];

    if ($entered_otp === $_SESSION['otp']) {
        $email = $_SESSION['email'];
        $new_password = $_SESSION['new_password'];

        
        $update_password_query = "UPDATE users SET password ='$new_password' WHERE email='$email'";
        if (mysqli_query($conn, $update_password_query)) {
            unset($_SESSION['otp'], $_SESSION['new_password'], $_SESSION['email']);
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Successful update password',
                        icon: 'success',
                        confirmButtonText: 'Go to Login'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'login.php';
                        }
                    });
                }
            </script>";

        } else {
            echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Registration Failed!',
                            text: 'Please try again: " . $stmt->error . "',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                </script>";
        }
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Incorrect OTP!',
                        text: 'Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Retry'
                    }).then((result) => {
                        if (result.isConfirmed) {
                             window.history.back(); 
                        }
                    });
                }
            </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify | Password</title>
    <link rel="icon" href="images/logo.png" type="image/x-icon" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .otp-input {
            border: 2px solid #ced4da;
            transition: border-color 0.3s;
        }

        .otp-input:focus {
            border-color: #007bff;
            box-shadow: none;
            outline: none;
        }

        .card-header {
            padding: 1.5rem;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .text-muted:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0">
                    <!-- Logo and Header Section -->
                    <div class="card-header text-center">
                        <img src="images/logo.png" alt="Logo" class="img-fluid mb-2" style="width: 80px;"> <!-- Logo -->
                        <h6>A verification code has been sent to your email <strong><?php echo $_SESSION['email']; ?></strong></h6>
                    </div>

                    <!-- Card Body with OTP Form -->
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h6 class="text-secondary">Enter the code sent to your mail</h6>
                        </div>

                        <form action="otp_password.php" method="POST">
                            <!-- OTP Input Fields -->
                            <div class="otp-container d-flex justify-content-center mb-4">
                                <input type="text" class="otp-input form-control text-center mx-1" name="otp1" maxlength="1" required onkeyup="moveFocus(this, 'otp2')" style="width: 40px; font-size: 24px;">
                                <input type="text" class="otp-input form-control text-center mx-1" name="otp2" maxlength="1" required onkeyup="moveFocus(this, 'otp3')" style="width: 40px; font-size: 24px;">
                                <input type="text" class="otp-input form-control text-center mx-1" name="otp3" maxlength="1" required onkeyup="moveFocus(this, 'otp4')" style="width: 40px; font-size: 24px;">
                                <input type="text" class="otp-input form-control text-center mx-1" name="otp4" maxlength="1" required onkeyup="moveFocus(this, 'otp5')" style="width: 40px; font-size: 24px;">
                                <input type="text" class="otp-input form-control text-center mx-1" name="otp5" maxlength="1" required onkeyup="moveFocus(this, 'otp6')" style="width: 40px; font-size: 24px;">
                                <input type="text" class="otp-input form-control text-center mx-1" name="otp6" maxlength="1" required onkeyup="moveFocus(this, 'otp1')" style="width: 40px; font-size: 24px;">
                            </div>

                            <input type="hidden" name="otp" id="otp" value="">

                            <!-- Verify Button -->
                            <button type="submit" name="verify" class="btn btn-success btn-block">Verify</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap JS dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function moveFocus(currentInput, nextInputName) {
            if (currentInput.value.length === 1) {
                document.getElementsByName(nextInputName)[0].focus();
            }
            // Set the value of the hidden input field
            const otp = Array.from(document.querySelectorAll('.otp-input')).map(input => input.value).join('');
            document.getElementById('otp').value = otp;
        }
    </script>
</body>

</html>
