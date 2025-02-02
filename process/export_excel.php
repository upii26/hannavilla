<?php
include 'config.php'; // Include database connection

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=arship_data.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Query to fetch data
$query = "SELECT name, checkin_date, checkout_date, name_rooms, phone, status FROM arship";
$result = $conn->query($query);

// Generate Excel content
echo "Name\tCheck-in Date\tCheck-out Date\tRoom Name\tPhone\tStatus\n";
while ($row = $result->fetch_assoc()) {
    echo "{$row['name']}\t{$row['checkin_date']}\t{$row['checkout_date']}\t{$row['name_rooms']}\t{$row['phone']}\t{$row['status']}\n";
}
?>
