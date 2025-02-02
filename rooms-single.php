<?php
include "process/config.php";

if (isset($_GET['id'])) {
    $room_id = $_GET['id'];

    $admin = "SELECT * FROM rooms WHERE id_rooms = $room_id";
    $result = $conn->query($admin);

    // Fetch the room data
    if ($room = $result->fetch_assoc()) {
     
        $roomImages = explode(',', $room['image']);
    } else {
        echo "Room not found.";
    }
} else {
    echo "Room ID not specified.";
}


include "navbar.php";
?>

<body>

    <div class="hero-wrap" style="background-image: url('images/2173.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
                <div class="col-md-9 ftco-animate text-center d-flex align-items-end justify-content-center">
                    <div class="text">
                        <p class="breadcrumbs mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
                            <span class="mr-2"><a href="index.html">Home</a></span> <span class="mr-2"><a
                                    href="rooms.html">Room</a></span> <span>Room Details</span>
                        </p>
                        <h1 class="mb-4 bread">Room Details</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-12 ftco-animate">
                            <h2 class="mb-4"><?php echo ($room['name']); ?></h2>
                            <div class="single-slider owl-carousel">
                                <?php if (isset($roomImages) && !empty($roomImages)): ?>
                                    <?php foreach ($roomImages as $image): ?>
                                        <div class="item">
                                            <div class="room-img" style="background-image: url('<?php echo $image; ?>');">
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="item">
                                        <div class="room-img" style="background-image: url('path/to/default-image.jpg');">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12 room-single mt-4 mb-5 ftco-animate">
                            <div class="row">
                                <!-- Room Details Section -->
                                <div class="col-md-6">
                                    <h4>View Details</h4>
                                    <div class="d-md-flex mt-5 mb-5">
                                        <ul class="list">
                                            <li><span>Max:</span> <?php echo $room['person'] ?> Persons</li>
                                            <li><span>Size:</span> <?php echo $room['size'] ?></li>
                                        </ul>
                                        <ul class="list ml-md-5">
                                            <li><span>Price:</span> <?php echo $room['price'] ?></li>
                                            <li><span>Bed:</span> <?php echo $room['bed'] ?></li>
                                        </ul>
                                        <ul class="list ml-md-5">
                                            <li><span>Status:</span> <?php echo $room['status'] ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Booking Form Section -->
                                <div class="col-md-6">
                                    <h4>Book This Room</h4>
                                    <form id="bookingForm" action="process/order_room.php" method="post">
                                        <div class="form-group">
                                            <input type="text" id="id" name="id" class="form-control"
                                                value="<?php echo $room['id_rooms']; ?>" hidden>
                                            <div class="form-group">
                                                <label for="room_name">Room Name:</label>
                                                <input type="text" id="room_name" name="room_name" class="form-control"
                                                    value="<?php echo $room['name']; ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name:</label>
                                                <input type="text" id="name" name="name" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Email:</label>
                                                <input type="email" id="email" name="email" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="checkin_date">Check-In Date:</label>
                                                <input type="date" id="checkin_date" name="checkin_date"
                                                    class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="checkout_date">Check-Out Date:</label>
                                                <input type="date" id="checkout_date" name="checkout_date"
                                                    class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Phone Number:</label>
                                                <input type="text" id="phone" name="phone" class="form-control" required>
                                            </div>
                                            <input type="hidden" id="status" value="<?php echo $room['status']; ?>">
                                            <div class="justify-content-end d-flex">
                                                <button type="button" class="btn btn-primary" onclick="checkLoginAndSubmit()">Book Now</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function checkLoginAndSubmit() {
            <?php if (!isset($_SESSION['username'])): ?>
                // If the user is not logged in, prompt them to log in.
                Swal.fire({
                    title: 'Login Required',
                    text: 'You must log in to book a room.',
                    icon: 'warning',
                    confirmButtonText: 'Login',
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.php'; // Redirect to your login page
                    }
                });
            <?php else: ?>
                // Check the room's booking status
                var status = document.getElementById('status').value;

                if (status === "Booked") {
                    // Show warning if the room is already booked
                    Swal.fire({
                        title: 'Room Already Booked!',
                        text: 'This room is already booked. Please choose another room.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                } else {
                    // Submit the form if the room is available
                    document.getElementById('bookingForm').submit();
                }
            <?php endif; ?>
        }
    </script>
    <?php include "footer.php" ?>

</body>

</html>