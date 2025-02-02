<?php
include "config.php"; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();

require 'vendor/autoload.php'; 

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
                        window.location.href = '../register.php';
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
                        window.location.href = '../register.php'; 
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
                    window.location.href = '../register.php';
                }
            });
        });
    </script>";
    } else {
       
        $check_email_query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $check_email_query);

        if ($result && $result->num_rows > 0) {
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
                            window.location.href = '../register.php'; 
                        }
                    });
                });
            </script>";
        } else {
            
            $otp = rand(100000, 999999);

            
            $_SESSION['otp'] = $otp;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['phone'] = $phone;

            
            $mail = new PHPMailer(true);
            try {
                
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'balihannavilla@gmail.com'; 
                $mail->Password = 'yapt zyeh asup nqab'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587 ;

                
                $mail->setFrom('balihannavilla@gmail.com', 'HANNA VILLA'); 
                $mail->addAddress($email, $username); 

              
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code';
                $mail->Body = '
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Your OTP Code</title>
                </head>
                <body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f3f4f6;">
                    <div style="width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15); text-align: center;">
                        
                        <!-- Header Section -->
                        <div style="background-color: #e3bd34; color: #ffffff; padding: 20px; border-radius: 8px 8px 0 0; font-size: 24px; font-weight: bold;">
                            Your OTP Code
                        </div>
                
                        <!-- OTP Content Section -->
                        <div style="padding: 20px; font-size: 16px; color: #333333;">
                            <p>Hello,</p>
                            <p>Use the code below to verify your identity. This code will expire in 10 minutes.</p>
                            <div style="display: inline-block; padding: 10px 20px; margin: 20px 0; font-size: 28px; font-weight: bold; color: #e3bd34; border: 2px dashed #e3bd34; border-radius: 5px;">
                                ' . $otp . '
                            </div>
                            <p>If you did not request this code, please disregard this message.</p>
                        </div>
                
                        <!-- Footer Section -->
                        <div style="padding: 20px 20px 20px 20px; font-size: 12px; color: #777777; border-top: 1px solid #e9ecef; background-color: #f8f9fa; border-radius: 0 0 8px 8px;">
                            <p>&copy; ' . date("Y") . 'Hanna Villa. All rights reserved.</p>
                            <p><a href="https://hannavilla.com" style="color: #e3bd34; text-decoration: none;">Visit our website</a> | <a href=balihannavilla@gmail.com" style="color: #e3bd34; text-decoration: none;">Contact Support</a></p>
                        </div>
                    </div>
                </body>
                </html>';
                
                $mail->AltBody = 'Your OTP code is: ' . $otp;           

                $mail->send();
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'OTP has been sent to your email.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../verify_otp.php'; // Redirect ke verify_otp.php
                            }
                        });
                    });
                </script>";

            } catch (Exception $e) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Email Delivery Failed!',
                            text: 'Error: $errorInfo',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'add_user.php'; // Redirect ke halaman yang sesuai
                            }
                        });
                    });
                </script>";
            }
        }
    }
}
?>