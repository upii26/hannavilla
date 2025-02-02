<?php
function updatetime()
{
    include "process/config.php";
    $today = date("Y-m-d");

    // Query untuk mengambil data dari tabel `order`
    $queryOrder = "SELECT id_rooms, name, checkin_date, checkout_date, name_rooms, phone FROM `order` WHERE status = 'Booked' AND checkout_date < ?";
    $stmtOrder = $conn->prepare($queryOrder);
    $stmtOrder->bind_param("s", $today);
    $stmtOrder->execute();
    $resultOrder = $stmtOrder->get_result();

    $roomIds = [];
    $ordersToInsert = []; // Array untuk menyimpan data order yang akan dimasukkan ke arship

    while ($row = $resultOrder->fetch_assoc()) {
        $roomIds[] = $row['id_rooms'];
        $ordersToInsert[] = [
            'name' => $row['name'],
            'checkin_date' => $row['checkin_date'],
            'checkout_date' => $row['checkout_date'],
            'name_rooms' => $row['name_rooms'],
            'phone' => $row['phone'],
            'status' => 'Finished' // Status yang akan disimpan di arship
        ];
    }
    $stmtOrder->close();

    // Memperbarui status ruangan
    if (!empty($roomIds)) {
        $roomIdsStr = implode(",", $roomIds); 
        $queryRooms = "UPDATE rooms SET status = 'Available' WHERE status = 'Booked' AND id_rooms IN ($roomIdsStr)";
        $conn->query($queryRooms);
    }

    // Menyimpan data ke tabel arship
    if (!empty($ordersToInsert)) {
        $insertArship = "INSERT INTO arship (name, checkin_date, checkout_date, name_rooms, phone, status) VALUES(?, ?, ?, ?, ?, ?)";
        $stmtArship = $conn->prepare($insertArship);

        foreach ($ordersToInsert as $order) {
            $stmtArship->bind_param("ssssis", $order['name'], $order['checkin_date'], $order['checkout_date'], $order['name_rooms'], $order['phone'], $order['status']);
            $stmtArship->execute(); // Eksekusi insert untuk setiap order
        }

        $stmtArship->close();
    }

    // Mengupdate status di tabel order
    $queryReservations = "UPDATE `order` SET status = 'Available' WHERE status = 'Booked' AND checkout_date < ?";
    $stmtReservations = $conn->prepare($queryReservations);
    $stmtReservations->bind_param("s", $today);
    $stmtReservations->execute();
    $stmtReservations->close();

    // Menghapus data dari tabel order
    $deleteQuery = "DELETE FROM `order` WHERE checkout_date < ?";
    $stmtDelete = $conn->prepare($deleteQuery);
    $stmtDelete->bind_param("s", $today);
    $stmtDelete->execute();
    $stmtDelete->close();
}
