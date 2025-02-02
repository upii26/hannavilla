<?php
session_start();
include "config.php"; 

if (isset($_POST['submit'])) {
    
    $email = trim($_POST['email']); 
    $password = $_POST['password'];

    
    if (empty($email) || empty($password)) {
        echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Email and password must be filled in.',
                            text: 'Tray Again',
                            icon: 'warning',
                            confirmButtonText: 'Back to Login'
                        }).then((result) => {
                            if (result.isConfirmed) {
                               window.history.back(); 
                            }
                        });
                    }
                </script>";
    }

    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; 
            $_SESSION['email'] = $user['email']; 

            
            if ($user['role'] === 'admin') {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Login Successful!',
                            text: 'Welcome, " . $user['username'] . "!',
                            icon: 'success',
                            confirmButtonText: 'Go to Dashboard'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../dashboard.php';
                            }
                        });
                    }
                </script>";
                
            } else if ($user['role'] === 'customer') {
                echo "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Login Successful!',
            text: 'Welcome, " . $user['username'] . "',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../index.php';
            }
        });
    });
</script>";
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Role is not recognised.',
                            icon: 'warning',
                            confirmButtonText: 'Back to Login'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../login.php';
                            }
                        });
                    }
                </script>";
                
            }
            exit();
        } else {
            
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Wrong Password.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../login.php';
                        }
                    });
                }
            </script>";
            
            exit();
        }
    } else {
        // Jika email tidak ada
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            window.onload = function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Unregistered Email.',
                    icon: 'warning',
                    confirmButtonText: 'Try Again'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../login.php';
                    }
                });
            }
        </script>";
        
        exit();
    }

    $stmt->close();
}
?>
