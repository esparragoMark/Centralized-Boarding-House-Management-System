<?php
ob_start();
include("header.php");
include("../../config/config.php");
include('../../middleware/middleware.php');


// Check if session variable is set and retrieve landlord ID
if (!isset($_SESSION['auth_landlord']['id'])) {
    $_SESSION['message'] = "Landlord ID is missing. Please log in again.";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}

$landlord_id = $_SESSION['auth_landlord']['id'];

// Escape special characters in landlord_id
$landlord_id = $con->real_escape_string($landlord_id);

// Fetch boarding house registration details
$query = "SELECT bh_id, house_name FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = $con->query($query);

// Check for query execution errors
if (!$result) {
    die("Query failed: " . $con->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['BH-ID'] = $row['bh_id'];
    $_SESSION['BH-NAME'] = $row['house_name'];

    $bh_id = $_SESSION['BH-ID'];
    $bh_name = $_SESSION['BH-NAME'];

    // Escape special characters in bh_name and bh_id
    $bh_name = $con->real_escape_string($bh_name);
    $bh_id = $con->real_escape_string($bh_id);

    // Fetch data from the database
    $sql = "SELECT * FROM occupants WHERE bh_name = '$bh_name' AND bh_id = '$bh_id'";
    $result = $con->query($sql);

    // Check for query execution errors
    if (!$result) {
        die("Query failed: " . $con->error);
    }

    if ($result->num_rows > 0) {
        $occupants = [];
        while ($row = $result->fetch_assoc()) {
            $occupants[] = $row;
        }
    } else {
        $occupants = [];
    }

    // Fetch data from the payment table
    $payment_list = "SELECT * FROM payment WHERE bh_id = '$bh_id'";
    $payment_list_run = $con->query($payment_list);

    // Check for query execution errors
    if (!$payment_list_run) {
        die("Query failed: " . $con->error);
    }

    if ($payment_list_run->num_rows > 0) {
        $payment_result = [];
        while ($payment_row = $payment_list_run->fetch_assoc()) {
            $payment_result[] = $payment_row;
        }
    } else {
        $payment_result = [];
    }

} else {
    $_SESSION['message'] = "No boarding house found. Please submit your credentials.";
    $_SESSION['message_type'] = "warning";
    header("Location: credential.php");
    exit();
}

// Close the connection and flush output buffer
$con->close();
ob_end_flush();
?>

<div class="container my-4" id="tenant_refresh">

    <!-- row for payment -->
    <div class="row">
        <div class="col-12 col-lg-12">
            <h3 class="mb-4">Payment</h3>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table  table-hover   caption-top table-custom">
                            <!-- table-group-divider -->
                            <caption>List of Occupants</caption>
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Gender</th>
                                    <th class="text-center">Room Number</th>
                                    <th class="text-center">Bed Number</th>
                                    <th class="text-center">Monthly Rent</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($occupants as $occupant): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($occupant['fullname']); ?></td>
                                    <td><?php echo htmlspecialchars($occupant['gender']); ?></td>
                                    <td><?php echo htmlspecialchars($occupant['room_number']); ?></td>
                                    <td><?php echo htmlspecialchars($occupant['bed_number']); ?></td>
                                    <td><?php echo '₱' . number_format($occupant['monthly_rent'], 2); ?></td>

                                    <td class="">
                                        <button type="button" style="background-color: #08614e; color: white" class="btn btn-sm payment_btn"
                                            data-occupant_id="<?= htmlspecialchars($occupant['occupant_id']) ?>"
                                            data-fullname="<?= htmlspecialchars($occupant['fullname']) ?>"
                                            data-room_number="<?= htmlspecialchars($occupant['room_number']) ?>"
                                            data-bed_number="<?= htmlspecialchars($occupant['bed_number']) ?>"
                                            data-monthly_rent="<?= htmlspecialchars($occupant['monthly_rent']) ?>">
                                            Pay
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- row for payment history -->
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card border-0">
                <div class="card-body">

                    <div class="d-flex justify-content-center align-items-center mb-2">
                        <h4 class="">Payment History</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table  table-hover   table-custom">
                            <!-- table-group-divider -->
                            <!-- <caption>History</caption> -->
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">Transaction Process</th>
                                    <th class="text-center">Tenant Name</th>
                                    <th class="text-center">Amount of Rent Paid</th>
                                    <th class="text-center">Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payment_result as $paymentResult): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($paymentResult['payment_date']); ?></td>
                                    <td><?php echo htmlspecialchars($paymentResult['tenant_name']); ?></td>
                                    <td><?php echo '₱' . number_format($paymentResult['total_rent_paid'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($paymentResult['due_date']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Payment modal -->
<div class="modal fade" id="payment" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #08614E">
                <h5 class="modal-title" id="paymentModalLabel" style="color: #FFFFFF">Process Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="background-color: #FFFFFF; border-radius: 50%; width: 10px; height: 10px"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem">

                <form id="paymentForm" action="process_payment.php" method="POST">
                    <input type="hidden" id="occupantId" name="occupantID">
                    <input type="hidden" id="monthlyRent" name="monthlyRent">
                    <div class="mb-3">
                        <label for="occupantName" class="form-label">Occupant Name</label>
                        <input type="text" class="form-control" id="occupantName" name="occupantName" readonly>
                    </div>
                    <div class="mb-3 paymentModal d-flex justify-content-evenly">
                        <div>
                            <label for="">Room No. :</label>
                            <strong>#<span id="occupant_room_num"></span></strong>
                        </div>
                        <div>
                            <label for="">Bed No. :</label>
                            <strong>#<span id="occupant_bed_num"></span></strong>
                        </div>
                        <div>
                            <label for="">Monthly Rent :</label>
                            <strong>₱<span id="occupant_rent"></span></strong>
                        </div>
                    </div>

                    <hr>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="dueDate" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="paymentDate" name="dueDate" required>
                    </div>

                    <input type="hidden" id="occupantId" name="occupantId">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit_payment" class="btn btn-success">Process Payment</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
