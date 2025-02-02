<?php
$servername = "localhost";
$database = "anna_base";
$username = "root";
$password = "";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Mengecek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Debugging selama pengembangan, dihapus jika sudah diproduksi
//  echo "Connected successfully";

// Tutup koneksi setelah selesai
// mysqli_close($conn);
?>
