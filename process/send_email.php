<?php
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    $to = "balihannavilla@gmail.com";
    $emailSubject = "Contact Us Message: $subject";
    
    $emailMessage = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                color: #333333;
                line-height: 1.6;
            }
            .email-container {
                max-width: 600px;
                margin: auto;
                padding: 20px;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                background-color: #f9f9f9;
            }
            .email-header {
                background-color: #800020;
                color: #ffffff;
                padding: 10px;
                text-align: center;
                font-size: 20px;
                font-weight: bold;
                border-radius: 8px 8px 0 0;
            }
            .email-content {
                padding: 20px;
                background-color: #ffffff;
                border-radius: 0 0 8px 8px;
            }
            .email-content h4 {
                margin: 0;
                color: #555555;
            }
            .email-content p {
                margin: 10px 0;
            }
            .email-footer {
                text-align: center;
                font-size: 12px;
                color: #888888;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='email-header'>
                New Message from Costumer Hanna Villa
            </div>
            <div class='email-content'>
                <p><strong>Sender Name:</strong> $name</p>
                <p><strong>Sender Email:</strong> $email</p>
                <p><strong>Subject:</strong> $subject</p>
                <h4>Message:</h4>
                <p>$message</p>
            </div>
            <div class='email-footer'>
                This message was sent from balihannavilla contact form.
            </div>
        </div>
    </body>
    </html>
    ";

    // Setup PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'balihannavilla@gmail.com';
        $mail->Password = 'yapt zyeh asup nqab';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, $name);
        $mail->addAddress($to);

        // Pengaturan konten email
        $mail->isHTML(true); 
        $mail->Subject = $emailSubject;
        $mail->Body = $emailMessage;

        $mail->send();

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      Swal.fire({
                          title: 'Success!',
                          text: 'Your message has been sent successfully. Please wait for a response.',
                          icon: 'success',
                          confirmButtonText: 'OK'
                      }).then((result) => {
                          if (result.isConfirmed) {
                             window.location.href = '../contact.php';
                          }
                      });
                  });
              </script>";
    } catch (Exception $e) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      Swal.fire({
                          title: 'Failed!',
                          text: 'Message could not be sent. Mailer Error: " . $mail->ErrorInfo . "',
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
?>
