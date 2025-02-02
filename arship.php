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
    exit;
}
$arship = "SELECT * FROM arship";
$result_arship = $conn->query($arship);

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
                        <li class="nav-item">
                            <a href="dashboard.php">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a data-bs-toggle="collapse" href="#ars" class="collapsed" aria-expanded="false">
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
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                    aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span>
                                        <span class="fw-bold"><?php echo $_SESSION['username']; ?></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="u-text">
                                                    <h4><?php echo $_SESSION['username']; ?></h4>
                                                    <p class="text-muted"><?php echo $_SESSION['email']; ?></p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
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
                            <h3 class="fw-bold mb-3">Arship</h3>
                            <h6 class="mb-2 fw-bold" style="color:#E3BD34;">Arship Dashboard</h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col px-5">
                        <div class="card card-round ">
                            <div class="card-header">
                                <div class="card-head-row card-tools-still-right">
                                    <div class="card-title">Data Rooms
                                    </div>
                                    <div class="card-tools">
                                        <a href="process/export_excel.php" class="btn btn-label-success btn-round btn-sm me-2">
                                            <span class="btn-label">
                                            <i class="fa fa-file-excel"></i>
                                            </span>
                                            Export
                                        </a>

                                        <a href="javascript:void(0)" onclick="printTable()" class="btn btn-label-info btn-round btn-sm">
                                            <span class="btn-label">
                                                <i class="fa fa-print"></i>
                                            </span>
                                            Print
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 bg-white">
                            <div class="table-responsive">
                                <!-- Table -->
                                <table class="table align-items-center mb-0" id="roomsTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Check In</th>
                                            <th scope="col">Check Out</th>
                                            <th scope="col">Name Rooms</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result_arship as $data) { ?>
                                            <tr>
                                                <td><?php echo $data['name']; ?></td>
                                                <td><?php echo $data['checkin_date']; ?></td>
                                                <td><?php echo $data['checkout_date']; ?></td>
                                                <td><?php echo $data['name_rooms']; ?></td>
                                                <td><?php echo $data['phone']; ?></td>
                                                <td><?php echo $data['status']; ?></td>
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
    <!--   Core JS Files   -->

    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#roomsTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "lengthMenu": [5, 10, 25]
            });
        });
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('#roomsTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(
                        value) > -1);
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            // Export table to Excel
            function exportTableToExcel() {
                let table = document.getElementById("roomsTable");
                let rows = table.rows;
                let csvContent = "";

                // Loop through the rows
                for (let i = 0; i < rows.length; i++) {
                    let cells = rows[i].cells;
                    let rowContent = "";

                    // Loop through the columns
                    for (let j = 0; j < cells.length; j++) {
                        rowContent += cells[j].innerText + (j === cells.length - 1 ? "" : ",");
                    }

                    csvContent += rowContent + "\n";
                }

                // Create a hidden link element
                let link = document.createElement("a");
                link.href = "data:text/csv;charset=utf-8," + encodeURIComponent(csvContent);
                link.download = "rooms_data.csv";
                link.click();
            }

            // Print the table
            function printTable() {
                const table = document.getElementById('roomsTable');
                if (table) {
                    const printContents = table.outerHTML;
                    const originalContents = document.body.innerHTML;

                    document.body.innerHTML = "<table>" + printContents + "</table>";
                    window.print();
                    document.body.innerHTML = originalContents;
                    window.location.reload();
                } else {
                    console.error('Table with ID "roomsTable" not found.');
                }
            }

            // Bind actions to buttons
            const exportButton = document.querySelector('a[onclick="exportTableToExcel()"]');
            if (exportButton) {
                exportButton.onclick = exportTableToExcel;
            }

            const printButton = document.querySelector('a[onclick="printTable()"]');
            if (printButton) {
                printButton.onclick = printTable;
            }
        });
    </script>

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
</body>

</html>