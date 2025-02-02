<?php

include('process/config.php');
include('process/checkoutdate.php');
session_start();
updatetime();

if (!isset($_SESSION['username'])) {
    echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Warning!',
                    text: 'You must login first.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.php'; 
                    }
                });
            });
        </script>";
    exit; // It is a good practice to exit after outputting a redirect script
}


$sql = "SELECT COUNT(*) as total_customers FROM users WHERE role = 'customer'";
$result_query = $conn->query($sql);


if ($result_query->num_rows > 0) {

    $row = $result_query->fetch_assoc();
    $result = $row['total_customers'];
} else {
    $result = "0";
}

$sql2 = "SELECT COUNT(*) as total_customers FROM users WHERE role = 'admin'";
$result_query2 = $conn->query($sql2);


if ($result_query2->num_rows > 0) {
    $row = $result_query2->fetch_assoc();
    $result2 = $row['total_customers'];
} else {
    $result2 = "0";
}

$count_rooms = "SELECT COUNT(*) as total_rooms FROM rooms";
$result_crooms = $conn->query($count_rooms);

if ($result_crooms) { // Check if the query was successful
    $row = $result_crooms->fetch_assoc();
    $total_rooms  = $row['total_rooms'];
} else {
    // Handle query error
    echo "Error: " . $conn->error;
    $total_rooms  = 0; // Set rooms to 0 on error
}

$count_available = "SELECT COUNT(*) as available_rooms FROM rooms WHERE status = 'Available'";
$result_available = $conn->query($count_available);

if ($result_available) { // Check if the query was successful
    $row = $result_available->fetch_assoc();
    $available_rooms  = $row['available_rooms'];
} else {
    // Handle query error
    echo "Error: " . $conn->error;
    $available_rooms  = 0; // Set rooms to 0 on error
}

$count_booked = "SELECT COUNT(*) as booked_rooms FROM rooms WHERE status = 'Booked'";
$result_booked = $conn->query($count_booked);

if ($result_booked) { // Check if the query was successful
    $row = $result_booked->fetch_assoc();
    $result_booked  = $row['booked_rooms'];
} else {
    // Handle query error
    echo "Error: " . $conn->error;
    $available_rooms  = 0; // Set rooms to 0 on error
}

$admin = "SELECT * FROM users WHERE role = 'admin'";
$result_admin = $conn->query($admin);

$customer = "SELECT * FROM users WHERE role = 'customer'";
$result_customer = $conn->query($customer);

$rooms = "SELECT * FROM rooms";
$result_rooms = $conn->query($rooms);

$orders = "SELECT * FROM `order`";
$result_order = $conn->query($orders);

// SQL query to get the count of orders per month
$sumroder = "SELECT MONTH(checkin_date) AS month, COUNT(id) AS order_count FROM arship GROUP BY MONTH(checkin_date) ORDER BY MONTH(checkin_date);";
$result_sumroder = $conn->query($sumroder);

// Prepare the data for JavaScript
$orders_per_month = [];
if ($result_sumroder->num_rows > 0) {
    while ($row = $result_sumroder->fetch_assoc()) {
        $orders_per_month[] = $row;
    }
}

$sumroder = "SELECT MONTHNAME(checkin_date) AS month, COUNT(id_rooms) AS order_count 
             FROM `order` 
             GROUP BY MONTH(checkin_date), MONTHNAME(checkin_date) 
             ORDER BY MIN(MONTH(checkin_date));";
$result_sumroder = $conn->query($sumroder);

// Initialize an empty string to store the output
$orderSummary = "";

// Check if there are results and build the output string
if ($result_sumroder->num_rows > 0) {
    while ($row = $result_sumroder->fetch_assoc()) {
        $orderSummary .= "<p><strong>" . $row['month'] . ":</strong> " . $row['order_count'] . " Orders Rooms</p>";
    }
} else {
    $orderSummary = "<p>No orders found.</p>";
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>HANNA Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="images/logo.png" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/style.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header">
                    <a href="dashboard.php" class="logo">
                        <img src="images/logo.png" alt="navbar brand" class="navbar-brand" height="50" /> <span
                            style="color:#E3BD34;">HANNA</span>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item active">
                            <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="arship.php">
                                <i class="fas fa-box"></i>
                                <p>Arship</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                                height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <!-- <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div> -->
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                    aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <!-- <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul> -->
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <!-- <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" /> -->
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span>
                                        <span class="fw-bold"><?php echo $_SESSION['username']; ?></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                    <!-- <img src="assets/img/profile.jpg" alt="image profile"
                                                        class="avatar-img rounded" /> -->
                                                </div>
                                                <div class="u-text">
                                                    <h4><?php echo $_SESSION['username']; ?></h4>
                                                    <p class="text-muted"><?php echo $_SESSION['email']; ?></p>
                                                    <!-- <a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View
                                                        Profile</a> -->
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <!-- <a class="dropdown-item" href="#">My Profile</a>
                                            <a class="dropdown-item" href="#">My Balance</a>
                                            <a class="dropdown-item" href="#">Inbox</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Account Setting</a>
                                            <div class="dropdown-divider"></div> -->
                                            <a class="dropdown-item" href="process/logout.php">Logout</a>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Dashboard</h3>
                            <h6 class="mb-2 fw-bold" style="color:#E3BD34;">HANNA Dashboard</h6>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0">
                            <button type="button" class="btn btn-danger btn-round" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Add User</button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="process/add_admin.php" method="POST">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Username</label>
                                                    <input type="text" name="username" class="form-control"
                                                        id="recipient-name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        id="recipient-name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Password</label>
                                                    <input type="password" name="password" class="form-control"
                                                        id="recipient-name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Phone</label>
                                                    <input type="text" class="form-control" name="phone"
                                                        id="recipient-name">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submiit" name="submit" class="btn btn-primary">Add
                                                        User</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">customer Accoount</p>
                                                <h4 class="card-title"><?php echo $result; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                                <i class="fas fa-user-check"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Admin Account</p>
                                                <h4 class="card-title"><?php echo $result2; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                                <i class="fas fa-luggage-cart"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Room</p>
                                                <h4 class="card-title"><?php echo $total_rooms; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                <i class="far fa-check-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Rooms Available</p>
                                                <h4 class="card-title"><?php echo $available_rooms; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                <i class="far fa-check-circle"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Rooms Booked</p>
                                                <h4 class="card-title"><?php echo $result_booked; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Order Statistics</div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container" style="min-height: 375px">
                                        <canvas id="statisticsorder"></canvas>
                                    </div>
                                    <div id="chartoder"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-primary card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Daily Order</div>
                                        <div class="card-tools">
                                        </div>
                                    </div>
                                    <div class="card-category">This Month</div>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <p> <?php echo $orderSummary ?></p>
                                    </div>
                                    <div class="pull-in">
                                        <canvas id="dailySalesChart"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-round">
                                <div class="card-body">
                                    <div class="card-head-row card-tools-still-right">
                                        <div class="card-title">Account Admin</div>
                                        <div class="ms-5">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Search..." />
                                        </div>
                                    </div>
                                    <div class="card-list py-4" id="adminList">
                                        <?php foreach ($result_admin as $admin) { ?>
                                            <div class="item-list admin-item"
                                                data-username="<?php echo $admin['username']; ?>"
                                                data-email="<?php echo $admin['email']; ?>"
                                                data-phone="<?php echo $admin['phone']; ?>"
                                                data-id="<?php echo $admin['id']; ?>">
                                                <div class="info-user ms-3">
                                                    <div class="username"><?php echo $admin['username']; ?></div>
                                                    <div class="status"><?php echo $admin['email']; ?></div>
                                                </div>
                                                <div class="info-user ms-3">
                                                    <div class="username">Phone</div>
                                                    <div class="status"><?php echo $admin['phone']; ?></div>
                                                </div>
                                                <a href="process/delete_account.php?id=<?php echo $admin['id']; ?>">
                                                    <button class="btn btn-icon btn-link btn-danger op-8">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div id="pagination">
                                        <!-- Pagination buttons will be dynamically added here -->
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="card card-round">
                                        <div class="card-body">
                                            <div class="card-head-row card-tools-still-right">
                                                <div class="card-title">Account Customer</div>
                                                <div class="ms-5">
                                                    <input type="text" id="searchInputCustomer" class="form-control"
                                                        placeholder="Search..." />
                                                </div>
                                            </div>
                                            <div class="card-list py-4" id="customerList">
                                                <?php foreach ($result_customer as $customer) { ?>
                                                    <div class="item-list customer-item"
                                                        data-username="<?php echo $customer['username']; ?>"
                                                        data-email="<?php echo $customer['email']; ?>"
                                                        data-phone="<?php echo $customer['phone']; ?>"
                                                        data-id="<?php echo $customer['id']; ?>">
                                                        <div class="info-user ms-3">
                                                            <div class="username"><?php echo $customer['username']; ?></div>
                                                            <div class="status"><?php echo $customer['email']; ?></div>
                                                        </div>
                                                        <div class="info-user ms-3">
                                                            <div class="username">Phone</div>
                                                            <div class="status"><?php echo $customer['phone']; ?></div>
                                                        </div>
                                                        <a
                                                            href="process/delete_account.php?id=<?php echo $customer['id']; ?>">
                                                            <button class="btn btn-icon btn-link btn-danger op-8">
                                                                <i class="fas fa-ban"></i>
                                                            </button>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div id="paginationCustomer">
                                                <!-- Pagination buttons will be dynamically added here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row card-tools-still-right">
                                        <div class="card-title">Data Rooms</div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <button class="btn btn-icon btn-clean me-0" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <!-- Add Roms button -->
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#addRomsModal">Add Roms</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal for Add Roms -->
                                        <div class="modal fade" id="addRomsModal" tabindex="-1"
                                            aria-labelledby="addRomsModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addRomsModalLabel">Add Roms</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="add_rooms.php" method="POST"
                                                        enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <!-- Your form or content goes here -->
                                                            <div class=" mb-3">
                                                                <label for="name" class="form-label">Rooms Name</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    id="name">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="person" class="form-label">Max
                                                                    Person</label>
                                                                <input type="text" name="person" class="form-control"
                                                                    id="person">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="size" class="form-label">Size</label>
                                                                <input type="text" name="size" class="form-control"
                                                                    id="size">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="price" class="form-label">Price
                                                                    Rooms</label>
                                                                <input type="text" name="price" class="form-control"
                                                                    id="price">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="bed" class="form-label">Bed</label>
                                                                <input type="number" name="bed" class="form-control"
                                                                    id="bed">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="images" class="form-label">Image
                                                                    Rooms</label>
                                                                <input type="file" name="images[]" class="form-control"
                                                                    id="images" multiple>
                                                            </div>
                                                            <div id="image-preview" class="mb-3"></div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="submit"
                                                                    class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <!-- Projects table -->
                                    <table class="table align-items-center mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Max Person</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Bed</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result_rooms as $rooms) { ?>
                                                <tr>
                                                    <td scope="col"><?php echo $rooms['name']; ?></td>
                                                    <td scope="col"><?php echo $rooms['person']; ?></td>
                                                    <td scope="col"><?php echo $rooms['size']; ?></td>
                                                    <td scope="col"><?php echo $rooms['price']; ?></td>
                                                    <td scope="col"><?php echo $rooms['bed']; ?></td>
                                                    <td scope="col"><?php echo $rooms['status']; ?></td>
                                                    <td scope="col">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-icon btn-link btn-danger op-8"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                                            onclick="loadRoomData(<?php echo $rooms['id_rooms']; ?>)">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <!-- Modal for Editing Room -->
                                                        <div class="modal fade" id="editModal" tabindex="-1"
                                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog text-start">
                                                                <div class="modal-content">
                                                                    <form id="editRoomForm" action="edit_room.php"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel">Edit
                                                                                Room</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <input type="hidden" id="roomId" name="roomId">
                                                                            <div class="mb-3">
                                                                                <label for="editName"
                                                                                    class="form-label">Room Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="editName" name="name" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="editPerson"
                                                                                    class="form-label">Person</label>
                                                                                <input type="number" class="form-control"
                                                                                    id="editPerson" name="person" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="editSize"
                                                                                    class="form-label">Size</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="editSize" name="size" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="editPrice"
                                                                                    class="form-label">Price</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="editPrice" name="price" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="editBed"
                                                                                    class="form-label">Number of
                                                                                    Mattresses</label>
                                                                                <input type="number" class="form-control"
                                                                                    id="editBed" name="bed" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="editImages"
                                                                                    class="form-label">Room Images</label>
                                                                                <input type="file" class="form-control"
                                                                                    id="editImages" name="images[]"
                                                                                    value="<?php echo $room['image']; ?>"
                                                                                    multiple>
                                                                                <!-- Menampilkan gambar yang ada -->
                                                                                <div id="currentImages" class="mt-2">
                                                                                    <?php
                                                                                    if (!empty($room['image'])) {
                                                                                        $images = explode(',', $room['image']); // Memisahkan gambar yang dipisah oleh koma
                                                                                        foreach ($images as $image) {
                                                                                            echo "<img src='$image' width='100' class='me-2 mb-2' />";
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                                <input type="hidden" id="currentImageValues"
                                                                                    name="current_images" value="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Save
                                                                                changes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <a href="process/delete_rooms.php?id=<?php echo $rooms['id_rooms']; ?>"
                                                            class="btn btn-icon btn-link btn-danger op-8">
                                                            <i class="fas fa-ban"></i>
                                                        </a>

                                                        <a href="javascript:void(0);"
                                                            class="btn btn-icon btn-link btn-danger op-8"
                                                            data-bs-toggle="modal" data-bs-target="#roomDetailModal"
                                                            onclick="loadRoomDetailsWithSlider(<?php echo $rooms['id_rooms']; ?>)">
                                                            <i class="fas fa-info"></i>
                                                        </a>

                                                        <!-- Modal untuk menampilkan detail dan gambar slider -->
                                                        <div class="modal fade" id="roomDetailModal" tabindex="-1"
                                                            aria-labelledby="roomDetailModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-md">
                                                                <div class="modal-content text-start">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="roomDetailModalLabel">
                                                                            Room Details</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div id="roomImages" class="carousel slide"
                                                                            data-bs-ride="carousel">
                                                                            <div class="carousel-inner" id="carouselImages">
                                                                                <!-- Gambar akan ditambahkan di sini -->
                                                                            </div>
                                                                            <button class="carousel-control-prev"
                                                                                type="button" data-bs-target="#roomImages"
                                                                                data-bs-slide="prev">
                                                                                <span class="carousel-control-prev-icon"
                                                                                    aria-hidden="true"></span>
                                                                                <span
                                                                                    class="visually-hidden">Previous</span>
                                                                            </button>
                                                                            <button class="carousel-control-next"
                                                                                type="button" data-bs-target="#roomImages"
                                                                                data-bs-slide="next">
                                                                                <span class="carousel-control-next-icon"
                                                                                    aria-hidden="true"></span>
                                                                                <span class="visually-hidden">Next</span>
                                                                            </button>
                                                                        </div>
                                                                        <div id="roomDetails" class="mt-3">
                                                                            <!-- Detail ruangan akan ditampilkan di sini -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm border-light">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <div class="card-title px-5 mt-3 mb-4">Data Order</div>
                                <table class="table align-items-center mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Check IN</th>
                                            <th scope="col">Check Out</th>
                                            <th scope="col">Rooms</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result_order as $order) { ?>
                                            <tr>
                                                <td scope="col"><?php echo $order['name']; ?></td>
                                                <td scope="col"><?php echo $order['checkin_date']; ?></td>
                                                <td scope="col"><?php echo $order['checkout_date']; ?></td>
                                                <td scope="col"><?php echo $order['name_rooms']; ?></td>
                                                <td scope="col"><?php echo $order['phone']; ?></td>
                                                <td scope="col"><?php echo $order['status']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/java.min.js"></script>


    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>



    <script>
        $(document).ready(function() {
            // Variables
            const itemsPerPage = 5; // Set how many items you want per page
            const adminItems = $('.admin-item'); // Get all admin items
            const totalPages = Math.ceil(adminItems.length / itemsPerPage);
            let currentPage = 1;

            // Function to show items based on current page
            function showItems(page) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;

                adminItems.hide();
                adminItems.slice(start, end).show();
            }

            // Function to create pagination buttons
            function createPagination() {
                $('#pagination').empty();
                for (let i = 1; i <= totalPages; i++) {
                    $('#pagination').append(
                        `<button class="btn btn-secondary m-1 pagination-btn" data-page="${i}">${i}</button>`);
                }

                // Add click event to pagination buttons
                $('.pagination-btn').on('click', function() {
                    currentPage = $(this).data('page');
                    showItems(currentPage);
                });
            }

            // Function to search admin items
            $('#searchInput').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();

                adminItems.each(function() {
                    const username = $(this).data('username').toLowerCase();
                    const email = $(this).data('email').toLowerCase();
                    const phone = $(this).data('phone').toLowerCase();

                    if (username.includes(searchTerm) || email.includes(searchTerm) || phone
                        .includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // If search is active, hide pagination
                if (searchTerm.length > 0) {
                    $('#pagination').hide();
                } else {
                    $('#pagination').show();
                    showItems(currentPage);
                }
            });



            // Initialize pagination and show first page items
            createPagination();
            showItems(currentPage);
        });

        $(document).ready(function() {
            // Variables
            const itemsPerPageCustomer = 5; // Set how many items you want per page
            const customerItems = $('.customer-item'); // Get all customer items
            const totalPagesCustomer = Math.ceil(customerItems.length / itemsPerPageCustomer);
            let currentPageCustomer = 1;

            // Function to show items based on current page
            function showItemsCustomer(page) {
                const start = (page - 1) * itemsPerPageCustomer;
                const end = start + itemsPerPageCustomer;

                customerItems.hide();
                customerItems.slice(start, end).show();
            }

            // Function to create pagination buttons
            function createPaginationCustomer() {
                $('#paginationCustomer').empty();
                for (let i = 1; i <= totalPagesCustomer; i++) {
                    $('#paginationCustomer').append(
                        `<button class="btn btn-secondary m-1 pagination-btn-customer" data-page="${i}">${i}</button>`
                    );
                }

                // Add click event to pagination buttons
                $('.pagination-btn-customer').on('click', function() {
                    currentPageCustomer = $(this).data('page');
                    showItemsCustomer(currentPageCustomer);
                });
            }

            // Function to search customer items
            $('#searchInputCustomer').on('keyup', function() {
                const searchTermCustomer = $(this).val().toLowerCase();

                customerItems.each(function() {
                    const username = $(this).data('username').toLowerCase();
                    const email = $(this).data('email').toLowerCase();
                    const phone = $(this).data('phone').toLowerCase();

                    if (username.includes(searchTermCustomer) || email.includes(
                            searchTermCustomer) || phone.includes(searchTermCustomer)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // If search is active, hide pagination
                if (searchTermCustomer.length > 0) {
                    $('#paginationCustomer').hide();
                } else {
                    $('#paginationCustomer').show();
                    showItemsCustomer(currentPageCustomer);
                }
            });

            // Initialize pagination and show first page items
            createPaginationCustomer();
            showItemsCustomer(currentPageCustomer);
        });
    </script>


    <script>
        document.getElementById('images').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('image-preview');
            imagePreview.innerHTML = ''; // Kosongkan preview sebelumnya

            const files = event.target.files; // Ambil file yang diupload
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader(); // Membaca file

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result; // Gambar dari FileReader
                    img.style.width = '100px'; // Set ukuran gambar
                    img.style.margin = '5px'; // Margin antar gambar
                    imagePreview.appendChild(img); // Tambahkan gambar ke preview
                }

                reader.readAsDataURL(file); // Membaca file sebagai URL data
            }
        });


        function loadRoomData(roomId) {
            // AJAX request to get room data by ID
            $.ajax({
                url: 'process/get_room_data.php',
                type: 'POST',
                data: {
                    id: roomId
                },
                dataType: 'json',
                success: function(response) {
                    // Fill the form with the room data
                    $('#roomId').val(response.id);
                    $('#editName').val(response.name);
                    $('#editPerson').val(response.person);
                    $('#editSize').val(response.size);
                    $('#editPrice').val(response.price);
                    $('#editBed').val(response.bed);

                    // Display current images without adding 'process/'
                    let imagesHtml = '';
                    response.images.forEach(function(image) {
                        imagesHtml +=
                            `<img src="${image}" width="100" class="me-2" />`; // Pastikan tidak menambah 'process/'
                    });
                    $('#currentImages').html(imagesHtml);

                    // Store current images in hidden input
                    $('#currentImageValues').val(response.image); // Menyimpan semua nilai gambar yang ada
                }
            });
        }

        function loadRoomDetailsWithSlider(roomId) {
            $.ajax({
                url: 'process/get_room_data.php',
                type: 'POST',
                data: {
                    id: roomId
                },
                dataType: 'json',
                success: function(response) {
                    if (!response.error) {
                        // Menampilkan detail ruangan
                        $('#roomDetails').html(`
                    <p><strong>Name:</strong> ${response.name}</p>
                    <p><strong>Person:</strong> ${response.person}</p>
                    <p><strong>Size:</strong> ${response.size}</p>
                    <p><strong>Price:</strong> ${response.price}</p>
                    <p><strong>Bed:</strong> ${response.bed}</p>
                `);

                        // Menampilkan gambar dalam slider
                        let carouselImages = '';
                        response.images.forEach(function(image, index) {
                            carouselImages += `
                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                            <img src="${image}" class="d-block w-100" alt="Room Image">
                        </div>
                    `;
                        });
                        $('#carouselImages').html(carouselImages);

                        // Tampilkan modal
                        $('#roomDetailModal').modal('show');
                    } else {
                        alert(response.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error: ', textStatus, errorThrown);
                }
            });
        }


        $(document).ready(function() {
            // Inisialisasi DataTables
            $('.table').DataTable({
                pageLength: 5, // Tampilkan 5 data per halaman
                lengthMenu: [5, 10, 25, 50], // Opsi jumlah data per halaman
                language: {
                    lengthMenu: "Show _MENU_ ",
                    zeroRecords: "Tidak ada entri ditemukan",
                    info: "Show Page _PAGE_ or _PAGES_",
                    infoEmpty: "No Romms Available",
                    search: "Search:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",

                    }
                }
            });
        });
    </script>

    <script>
        // Pass the PHP data to JavaScript
        const ordersData = <?php echo json_encode($orders_per_month); ?>;

        // Prepare data for the chart


        // Initialize the chart
        document.addEventListener("DOMContentLoaded", function() {
            // Define labels and data for the chart
            // const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July']; // Replace with your data

            const labels = ordersData.map(item => `Month ${item.month}`);
            const data = ordersData.map(item => item.order_count);
            const ctx = document.getElementById('statisticsorder').getContext('2d');

            new Chart(ctx, {
                type: 'line', // Line chart type
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Orders per Month',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        tension: 0.4 // Add curve to the line
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Orders'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        });

        var dailySalesChart = document.getElementById('dailySalesChart').getContext('2d');

        var myDailySalesChart = new Chart(dailySalesChart, {
            type: 'line',
            data: {
                labels: ["January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September"
                ],
                datasets: [{
                    label: "Sales Analytics",
                    fill: !0,
                    backgroundColor: "rgba(255,255,255,0.2)",
                    borderColor: "#fff",
                    borderCapStyle: "butt",
                    borderDash: [],
                    borderDashOffset: 0,
                    pointBorderColor: "#fff",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "#fff",
                    pointHoverBorderWidth: 1,
                    pointRadius: 1,
                    pointHitRadius: 5,
                    data: [65, 59, 80, 81, 56, 55, 40, 35, 30]
                }]
            },
            options: {
                maintainAspectRatio: !1,
                legend: {
                    display: !1
                },
                animation: {
                    easing: "easeInOutBack"
                },
                scales: {
                    yAxes: [{
                        display: !1,
                        ticks: {
                            fontColor: "rgba(0,0,0,0.5)",
                            fontStyle: "bold",
                            beginAtZero: !0,
                            maxTicksLimit: 10,
                            padding: 0
                        },
                        gridLines: {
                            drawTicks: !1,
                            display: !1
                        }
                    }],
                    xAxes: [{
                        display: !1,
                        gridLines: {
                            zeroLineColor: "transparent"
                        },
                        ticks: {
                            padding: -20,
                            fontColor: "rgba(255,255,255,0.2)",
                            fontStyle: "bold"
                        }
                    }]
                }
            }
        });
    </script>

</body>

</html>