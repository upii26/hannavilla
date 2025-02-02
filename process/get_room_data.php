<?php
include 'config.php';

if (isset($_POST['id'])) {
    $roomId = $_POST['id'];

    
    $query = "SELECT * FROM rooms WHERE id_rooms = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $roomId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $room = $result->fetch_assoc();

           
            $room['images'] = explode(",", $room['image']);

            
            echo json_encode($room);
        } else {
            echo json_encode(['error' => 'Room not found']);
        }

        $stmt->close(); 
    } else {
        echo json_encode(['error' => 'Failed to prepare the SQL statement']);
    }
} else {
    echo json_encode(['error' => 'No room ID provided']);
}


$conn->close();
?>
