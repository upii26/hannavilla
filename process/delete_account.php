<?php
include "config.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'to delete this account!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete_account.php?confirm=true&id=$id';
                } else {
                    window.location.href = '../dashboard.php';
                }
            });
        });
    </script>";

   
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
   
        $sql = "DELETE FROM users WHERE id=$id";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The account has been deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../dashboard.php';
                        }
                    });
                });
            </script>";
        } else {
            echo "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete the account.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../dashboard.php';
                        }
                    });
                });
            </script>";
        }
    }
}
?>
