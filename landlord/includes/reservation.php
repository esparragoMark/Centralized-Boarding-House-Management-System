<?php
ob_start();
include('header.php');
include('../../middleware/middleware.php');
include('../../config/config.php');

$landlord_id = $_SESSION['auth_landlord']['id'];

// Fetch boarding house ID
$query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['BH-ID'] = $row['bh_id'];
    $bh_id = $_SESSION['BH-ID'];
} else {
    $_SESSION['message'] = "No boarding house found. Please submit your credentials.";
    $_SESSION['message_type'] = "warning";
    header("Location: credential.php");
    exit();
}

// Fetch pending booking data
$reservation_query = "SELECT * FROM booking WHERE bh_id = '$bh_id' AND status = 'pending'";
$reservation_query_run = mysqli_query($con, $reservation_query);

// Fetch rejectd booking data
$rejected_query = "SELECT * FROM booking WHERE bh_id = '$bh_id' AND status = 'rejected'";
$rejected_query_run = mysqli_query($con, $rejected_query);

ob_end_flush();
?>
<div class="container my-4" id="tenant_refresh">

    <!-- row for payment -->
    <div class="row">
        <div class="col-12 col-lg-12">
            <h3 class="mb-4">Reservation</h3>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- id="myTable" -->
                        <table class="table table-hover table-bordered caption-top  table-custom" >
                            <!-- table-group-divider -->
                            <caption>List of Pending Book</caption>
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Contact No.</th>
                                    <th class="text-center">Check In</th>
                                    <th class="text-center">Check Out</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($reservation_query_run) > 0) {
                                    while ($booking_data = mysqli_fetch_assoc($reservation_query_run)) {
                                        // Extract data from the result set
                                        $name = htmlspecialchars($booking_data['fullname']);
                                        $address = htmlspecialchars($booking_data['address']);
                                        $contact_no = htmlspecialchars($booking_data['contact_no']);
                                        $check_in = htmlspecialchars($booking_data['check_in']);
                                        $check_out = htmlspecialchars($booking_data['check_out']);
                                        
                                        // Output the data in table rows
                                        echo "<tr>
                                                <td>$name</td>
                                                <td>$address</td>
                                                <td>$contact_no</td>
                                                <td>$check_in</td>
                                                <td>$check_out</td>
                                                <td>
                                                    <a href='reservation_details.php?id=" . htmlspecialchars($booking_data['booking_id']) . "' class='btn' style='background-color: #08614e; color: white;'>View Details</a>
                                                </td>
                                            </tr>";

                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No Booking Data!</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="container mt-5" id="tenant_refresh">
    <!-- row for payment -->
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- id="myTable" -->
                        <table class="table table-hover table-bordered caption-top  table-custom">
                            <!-- table-group-divider -->
                            <caption>List of Rejected Book</caption>
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Contact No.</th>
                                    <th class="text-center">Check In</th>
                                    <th class="text-center">Check Out</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($rejected_query_run) > 0) {
                                    while ($booking_rejected_data = mysqli_fetch_assoc($rejected_query_run)) {
                                        // Extract data from the result set
                                        $name = htmlspecialchars($booking_rejected_data['fullname']);
                                        $address = htmlspecialchars($booking_rejected_data['address']);
                                        $contact_no = htmlspecialchars($booking_rejected_data['contact_no']);
                                        $check_in = htmlspecialchars($booking_rejected_data['check_in']);
                                        $check_out = htmlspecialchars($booking_rejected_data['check_out']);
                                        
                                        // Output the data in table rows
                                        echo "<tr>
                                                <td>$name</td>
                                                <td>$address</td>
                                                <td>$contact_no</td>
                                                <td>$check_in</td>
                                                <td>$check_out</td>
                                                <td>
                                                    <a href='reservation_rejected_details.php?id=" . htmlspecialchars($booking_rejected_data['booking_id']) . "' class='btn btn-danger'>View Details</a>
                                                </td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No Booking Data!</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include('footer.php'); ?>
