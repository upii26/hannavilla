<?php
include "config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Pastikan ID adalah integer

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to delete this room?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mengarahkan ke delete_rooms.php untuk mengonfirmasi penghapusan
                    window.location.href = 'delete_rooms.php?id=$id&confirm=true';
                } else {
                    // Redirect kembali ke dashboard jika dibatalkan
                    window.location.href = '../dashboard.php';
                }
            });
        });
    </script>";
}

// Cek untuk konfirmasi penghapusan
if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $id); // Mengikat parameter

    if ($stmt->execute()) {
        // Menampilkan popup setelah penghapusan berhasil
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'The room has been deleted.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    // Redirect setelah pengguna menekan OK
                    window.location.href = '../dashboard.php';
                });
            });
        </script>";
    } else {
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to delete the room.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    // Redirect setelah pengguna menekan OK
                    window.location.href = '../dashboard.php';
                });
            });
        </script>";
    }

    $stmt->close(); // Menutup statement
}

$conn->close(); // Menutup koneksi database
?>
