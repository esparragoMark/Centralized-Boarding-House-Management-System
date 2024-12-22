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

<!-- id="tenant_refresh -->
<div class="container my-4"> 
    <h3 class="mb-4">Record</h3>
    <div class="card border-0">
        <div class="card-body" >
            <div class="d-flex justify-content-between align-items-center flex-end mb-4  btn-custom-spacing">

                <div></div>
                <div>
                    <!-- <button class="btn btn-outline-success" onclick="window.location.href='add_record.php'">
                        <i class="fas fa-upload"></i> Upload CSV
                    </button> -->
                    <button class="btn  ml-2" onclick="window.location.href='add_Tenant.php';" style="background-color: #08614e; color: white">
                        <i class="fas fa-plus"></i> Add Tenant
                    </button>
                </div>

            </div>
            <div class="table-responsive" id="tenant_refresh">
                <table id="myTable" class="table table-bordered  table-hover table-sm  caption-top table-custom">
                    <!-- table-group-divider -->
                    <caption>List of Occupants</caption>
                    <thead class="table-secondary">
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Course/Year/Section</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Contact No.</th>
                            <th class="text-center">Room No.</th>
                            <th class="text-center">Bed No.</th>
                            <th class="text-center">Payment Amount</th>
                            <th class="text-center">Due Date</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($occupants as $occupant): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($occupant['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['gender']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['course_year_section']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['address']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['contact_number']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['room_number']); ?></td>
                            <td><?php echo htmlspecialchars($occupant['bed_number']); ?></td>
                            <td><?php echo '₱' . number_format($occupant['payment_amount'], 2); ?></td>
                            <td style="color: <?php echo (strtotime($occupant['end_date']) <= strtotime(date('Y-m-d'))) ? 'red' : 'green'; ?>">
                                <?php echo htmlspecialchars($occupant['end_date']); ?>
                                <?php if (strtotime($occupant['end_date']) <= strtotime(date('Y-m-d'))) : ?>
                                    <i class="fas fa-exclamation-circle" style="color: red;"></i>
                                <?php else : ?>
                                    <i class="fas fa-check-circle" style="color: green;"></i>
                                <?php endif; ?>
                            </td>

                            <td class="table-buttons">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="location.href='viewTenantDetails.php?id=<?= urlencode($occupant['occupant_id']) ?>'">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm"
                                    onclick="location.href='edit_Tenant.php?id=<?= urlencode($occupant['occupant_id']) ?>'">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm deleteTenant"
                                    data-occupant_id="<?= htmlspecialchars($occupant['occupant_id']) ?>">
                                    <i class="fas fa-trash-alt"></i>
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

<?php include('footer.php'); ?>
