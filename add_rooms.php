<?php
include 'process/config.php';

if (isset($_POST['submit'])) {
    // Collect form data and sanitize it
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $person = htmlspecialchars($_POST['person'], ENT_QUOTES, 'UTF-8');
    $size = htmlspecialchars($_POST['size'], ENT_QUOTES, 'UTF-8');
    $price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
    $bed = intval($_POST['bed']); // Ensure bed is an integer

    // Image upload directory
    $targetDir = "assets/uploads/";
    $imagePaths = [];
    $status = "Available";

    // Check if files are uploaded
    if (isset($_FILES['images']['name']) && is_array($_FILES['images']['name'])) {
        // Loop through each uploaded file
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            // Check if there was an upload error
            if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                // Create a unique file name to avoid duplicates
                $fileName = time() . "_" . basename($_FILES['images']['name'][$key]);
                $targetFilePath = $targetDir . $fileName;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($tmpName, $targetFilePath)) {
                    // Store the relative file path
                    $imagePaths[] = $targetFilePath;
                } else {
                    echo "Failed to upload file: " . $_FILES['images']['name'][$key];
                    exit;
                }
            }
        }
    } else {
        echo "No images were uploaded.";
        exit;
    }

    // Join the file paths as a comma-separated string
    $imagePathsStr = implode(",", $imagePaths);

    // Insert form data into the database
    $sql = "INSERT INTO rooms (name, person, size, price, bed, image, status) 
            VALUES ('$name', '$person', '$size', '$price', '$bed', '$imagePathsStr', '$status')";

if (mysqli_query($conn, $sql)) {
    // Show success popup with redirect
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Success!',
            text: 'Added Rooms successfully!',
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
    // Show error popup
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Error!',
            text: 'Failed to add record: " . mysqli_error($conn) . "',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
    </script>";
}
}
?>
