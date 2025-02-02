<?php

include 'config.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];


    if (empty($username) || empty($email) || empty($password) || empty($phone)) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please fill in all fields.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
               }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        });
        </script>";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Invalid Email!',
                    text: 'Please enter a valid email format.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                         window.history.back(); 
                    }
                });
            });
        </script>";
    } else if (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Invalid Phone Number!',
                    text: 'Phone numbers must be a number with a length of 10-15 characters.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                         window.history.back();
                    }
                });
            });
        </script>";
    } else {

        $check_email_query = $conn->prepare("SELECT * FROM users WHERE email=?");
        $check_email_query->bind_param("s", $email);
        $check_email_query->execute();
        $result = $check_email_query->get_result();

        if ($result->num_rows > 0) {
            // Jika email sudah ada
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Email Already Registered!',
                        text: 'Please use another email.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                             window.history.back();
                        }
                    });
                });
            </script>";
        } else {

            $role = "admin";

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);


            $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $email, $hashed_password, $phone, $role);

            if ($stmt->execute()) {
                echo "
                        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Add User successfully!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                       window.history.back();
                                    }
                                });
                            });
                        </script>";
                exit();
            } else {
                echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Error!',
                text: 'Add User failed, Please try again: $stmtError',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        });
    </script>";
            }
        }

        $check_email_query->close();
    }
}
