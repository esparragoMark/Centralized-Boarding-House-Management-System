<?php
include('../../config/config.php');

// Get landlord ID from session
$landlord_id = $_SESSION['auth_landlord']['id'];

// Fetch boarding house ID
$query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['BH-ID'] = $row['bh_id'];
}


// Get count of pending bookings
$bh_id = isset($_SESSION['BH-ID']) ? $_SESSION['BH-ID'] : "";

$count_query = "SELECT COUNT(*) as count FROM booking WHERE status = 'pending' AND bh_id = '$bh_id'";
$count_result = mysqli_query($con, $count_query);

if ($count_result) {
    $count_row = mysqli_fetch_assoc($count_result);
    $pending_bookings_count = $count_row['count'];
} else {
    $pending_bookings_count = 0; // Default value if query fails
}

?>

<div class="wrapper">
    <aside id="sidebar">
        <!-- Content for Sidebar -->
        <div class="h-100">
            <div class="sidebar-logo">
                <a href="#">
                    <img src="../assets/images/logo.png" alt="photos">
                </a>
            </div>
            <ul class="sidebar-nav">
               
                <li class="sidebar-label">Main Navigation</li>
                <li class="sidebar-item">
                    <a href="index.php"   class="sidebar-link">
                        <i class="fas fa-tachometer-alt" style="margin-right: 1rem;  font-size: 1.1rem;"></i>
                        Dashboard
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="record.php" class="sidebar-link">
                        <i class="fas fa-users" style="margin-right: 1rem;  font-size: 1.1rem;"></i>
                        Tenants
                    </a>
                </li>
                <hr>
                <li class="sidebar-label">Management</li>
                <li class="sidebar-item">
                    <a href="mng_room.php" class="sidebar-link">
                        <i class="fas fa-home" style="margin-right: 1rem;  font-size: 1.1rem;"></i>
                        Manage Room
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="mng_bed.php" class="sidebar-link"> 
                        <i class="fas fa-bed" style="margin-right: 1rem;  font-size: 1.1rem;"></i>
                        Manage Bed
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="reservation.php" class="sidebar-link" data-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-calendar-alt" style="margin-right: 1rem;  font-size: 1.1rem;"></i>
                        Reservation
                        <span class="badge badge-pill" style="background-color: red;"><?=$pending_bookings_count?></span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="payment.php" class="sidebar-link">
                        <i class="fas fa-file-invoice-dollar" style="margin-right: 1rem;  font-size: 1.1rem;"></i>
                        Payment
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="report.php" class="sidebar-link">
                        <i class="fas fa-file-alt" style="margin-right: 1rem;  font-size: 1.1rem;"></i>
                        Reports
                    </a>
                </li>
                <hr>
                <li class="sidebar-label">BOARDINGHOUSE INFO</li>
                <li class="sidebar-item">
                    <a href="crendentialInfo.php" class="sidebar-link">
                        <i class="fas fa-key" style="margin-right: 1rem;  font-size: 1.1rem;"></i>
                        Credential's Info
                    </a>
                </li>
            </ul>
            <div class="submit-credentials-container">
                <a href="credential.php" class="unique-submit-credentials">
                    <i class="fas fa-upload" style="margin-right: .5rem; "></i>
                    Submit Credentials
                </a>
            </div>
        </div>
    </aside>