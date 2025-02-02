<?php
session_start(); // Mulai sesi

// Simpan role sebelum menghancurkan sesi
$role = $_SESSION['role'] ?? null; // Mengambil role dari sesi, jika ada

// Hapus semua variabel sesi
$_SESSION = [];


if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

session_destroy();


if ($role === 'admin') {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Logged Out!',
                text: 'You have logged out.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../login.php'; // Redirect ke halaman login
                }
            });
        });
    </script>";
} else {

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Logged Out!',
                text: 'You have logged out.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php'; // Redirect ke halaman login
                }
            });
        });
    </script>";
}
exit();
?>
