<?php
require 'vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_name = $_POST['room_name']; 
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email']; 
    $id = $_POST['id']; 
    $status = "Booked";

    if (!preg_match("/^\d{10,15}$/", $phone)) {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Invalid Phone Number!',
                    text: 'Phone numbers must be numeric and have a length of 10 to 15 digits.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back(); 
                    }
                });
            });
        </script>";
        exit; 
    }

    $roomQuery = $conn->prepare("SELECT id_rooms FROM rooms WHERE id_rooms = ? LIMIT 1");
    $roomQuery->bind_param('i', $id); 
    $roomQuery->execute();
    $room = $roomQuery->get_result()->fetch_assoc(); 
    
    if ($room) {
        $room_id = $room['id_rooms'];

       
        $sql = "INSERT INTO `order` (id_rooms, name_rooms, checkin_date, checkout_date, name, phone, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
       
        $stmt->bind_param('issssss', $room_id, $room_name, $checkin_date, $checkout_date, $name, $phone, $status);

        if ($stmt->execute()) {
            
            $updateRoomStatus = $conn->prepare("UPDATE rooms SET status = ? WHERE id_rooms = ?");
            $updateRoomStatus->bind_param('si', $status, $room_id); 
            $updateRoomStatus->execute();

            
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

                // Konten email
                $mail->isHTML(true); 
                $mail->Subject = "Room Booking HANNA VILLA";
                $mail->Body = "
                <html>
                <head>
                    <title>Booking Detail</title>
                    <style>
                        /* Inline styling for compatibility in email clients */
                        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; }
                        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 8px; }
                        .header { background-color: #E3BD34; padding: 20px; text-align: center; color: #ffffff; border-radius: 8px 8px 0 0; }
                        .header img { max-width: 50px; }
                        .header h1 { margin: 0; font-size: 24px; }
                        .content h2 { color: #343a40; }
                        .content p { color: #6c757d; line-height: 1.6; }
                        .footer { text-align: center; padding: 10px; font-size: 12px; color: #6c757d; border-top: 1px solid #e9ecef; }
                        .footer a { color: #E3BD34; text-decoration: none; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <!-- Header / Navbar with Logo -->
                        <div class='header'>
                            <h1>HANNA VILLA</h1>
                        </div>
                
                        <!-- Booking Details Content -->
                        <div class='content'>
                            <h2>Your Booking Details</h2>
                            <p><strong>Room Name:</strong> $room_name</p>
                            <p><strong>Check-In Date:</strong> $checkin_date</p>
                            <p><strong>Check-Out Date:</strong> $checkout_date</p>
                            <p><strong>Name:</strong> $name</p>
                            <p><strong>Phone:</strong> $phone</p>
                            <p><strong>Status:</strong> $status</p>
                        </div>
                
                        <!-- Footer Section -->
                        <div class='footer'>
                            <p>&copy; " . date('Y') . " HANNA VILLA. All rights reserved.</p>
                            <p><a href='https://hannavilla.com'>Visit our website</a> | <a href='balihannavilla@gmail.com'>Contact Us</a></p>
                        </div>
                    </div>
                </body>
                </html>";

                $mail->send();

                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: 'Booking Successful!',
                            text: 'Thanks For Ordering. Your booking details have been sent to your email.',
                            icon: 'success',
                            confirmButtonText: 'Back to Rooms'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../rooms.php'; 
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
                            title: 'Booking Successful!',
                            text: 'Thanks For Ordering, but we could not send the email. Error: {$mail->ErrorInfo}',
                            icon: 'warning',
                            confirmButtonText: 'Back to Rooms'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../rooms.php'; 
                            }
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
                        title: 'Failed to book the room.',
                        text: 'Please Try Again or Call Customer Service',
                        icon: 'error',
                        confirmButtonText: 'Back to Rooms'
                    }).then((result) => {
                        if (result.isConfirmed) {
                           window.history.back(); 
                        }
                    });
                }
            </script>";
        }
    } else {
        echo "Room not found";
    }
}
?>
