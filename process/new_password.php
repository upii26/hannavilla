<?php
include "config.php"; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();

require 'vendor/autoload.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    if (empty($email) || empty($new_password)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.');</script>";
    } else {
        // Check if email exists in database
        $check_email_query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $check_email_query);

        if ($result && $result->num_rows > 0) {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;
            $_SESSION['new_password'] = password_hash($new_password, PASSWORD_DEFAULT);

            // Send OTP email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'balihannavilla@gmail.com';
                $mail->Password = 'yapt zyeh asup nqab';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('balihannavilla@gmail.com', 'HANNA VILLA');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP Code for Password Reset';
                $mail->Body = ' <!DOCTYPE html>
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

                $mail->send();

                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'OTP has been sent to your email.',
                            icon: 'success',
                            confirmButtonText: 'Go to Verification'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../otp_password.php';
                            }
                        });
                    }
                </script>";

            } catch (Exception $e) {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Email could not be sent.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                </script>
            ";
            
            }
        } else {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Email does not exist.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            </script>
        ";
        
        }
    }
}
?>
