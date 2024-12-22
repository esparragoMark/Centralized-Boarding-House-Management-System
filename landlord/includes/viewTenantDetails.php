<?php
// Include necessary files and initiate session
include('header.php');
include('../../config/config.php');
include('../../middleware/middleware.php');

$landlord_id = $_SESSION['auth_landlord']['id'];

// Fetch boarding house ID for the landlord
$query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $landlord_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result) {
    $_SESSION['BH-ID'] = $result['bh_id'];
}

$bh_id = isset($_SESSION['BH-ID']) ? $_SESSION['BH-ID'] : 0;

if(isset($_GET['id'])) {
    $tenant_id = $_GET['id'];
    $sql_query = "SELECT * FROM occupants WHERE occupant_id = '$tenant_id' AND bh_id = '$bh_id'";
    $sql_query_run = mysqli_query($con, $sql_query);

    if(mysqli_num_rows($sql_query_run) > 0) {
        $tenant_data = mysqli_fetch_array($sql_query_run);
    } else {
        $_SESSION['message'] = "Tenant does not exist!";
        $_SESSION['message_type'] = "danger";
    }
} else {
    echo "ID not found in the URL";
}
?>

<div class="view-tenant-info-container container my-2">
    <div class="view-tenant-info-card border-0">
        <div class="view-tenant-info-card-body">
            <div class="view-tenant-info-header">
                <button class="back-btn" onclick="goBack()">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </button>
                <h4 class="mb-0">Tenant Information</h4>
            </div>
            <div class="view-tenant-info-details">
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Full Name</span>
                    <p class="tenant-info-value"><?= $tenant_data['fullname'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Gender</span>
                    <p class="tenant-info-value"><?= $tenant_data['gender'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Course/Year/Section</span>
                    <p class="tenant-info-value"><?= $tenant_data['course_year_section'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Address</span>
                    <p class="tenant-info-value"><?= $tenant_data['address'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Contact No.</span>
                    <p class="tenant-info-value"><?= $tenant_data['contact_number'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Guardian Name</span>
                    <p class="tenant-info-value"><?= $tenant_data['guardian_name'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Guardian Contact</span>
                    <p class="tenant-info-value"><?= $tenant_data['guardian_contact'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Date Moving In</span>
                    <p class="tenant-info-value"><?= $tenant_data['date_of_moving_in'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Boarding House</span>
                    <p class="tenant-info-value"><?= $tenant_data['bh_name'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Room Number</span>
                    <p class="tenant-info-value">#<?= $tenant_data['room_number'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Bed Number</span>
                    <p class="tenant-info-value">#<?= $tenant_data['bed_number'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Monthly Rent</span>
                    <p class="tenant-info-value">₱<?= $tenant_data['monthly_rent'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Amount of Payment</span>
                    <p class="tenant-info-value">₱<?= $tenant_data['payment_amount'] ?></p>
                </div>
                <hr>
                <div class="tenant-info-row">
                    <span class="tenant-info-label">Due Date</span>
                    <?php
                    $end_date = htmlspecialchars($tenant_data['end_date']);
                    $is_due_today = (strtotime($end_date) <= strtotime(date('Y-m-d')));
                    $text_color = $is_due_today ? 'red' : 'green'; // Set text color to green if not due today
                    ?>
                    <p class="tenant-info-value" style="color: <?= $text_color; ?>"><?= $end_date ?></p>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
