<?php
include 'process/config.php';

if (isset($_POST['roomId'])) {
    $roomId = $_POST['roomId'];
    $name = $_POST['name'];
    $person = $_POST['person'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $bed = $_POST['bed'];

    // Handle file uploads (if any)
    $targetDir = "assets/uploads/";
    $imagePaths = [];

    if (isset($_FILES['images']['name'][0]) && !empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $fileName = time() . "_" . basename($_FILES['images']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            if (move_uploaded_file($tmpName, $targetFilePath)) {
                $imagePaths[] = $targetFilePath;
            }
        }
        $imagePathsStr = implode(",", $imagePaths);
    } else {
        // If no new images are uploaded, keep the existing ones
        $imagePathsStr = $_POST['current_images'];
    }

    // Update room data in database
    $query = "UPDATE rooms SET name = ?, person = ?, size = ?, price = ?, bed = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sissisi", $name, $person, $size, $price, $bed, $imagePathsStr, $roomId);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Success!',
            text: 'Edit Rooms successfully!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'dashboard.php'; // Redirect to dashboard
            }
        });
    });
    </script>";
    } else {
        echo "Error updating room: " . $conn->error;
    }
}
