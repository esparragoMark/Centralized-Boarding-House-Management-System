<?php
ob_start();
include('header.php');
include("../../config/config.php");
include('../../middleware/middleware.php');

$landlord_id = $_SESSION['auth_landlord']['id'];

$query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['BH-ID'] = $row['bh_id'];
    $bh_id = $_SESSION['BH-ID'];
} else {
    $_SESSION['message'] = "Please submit your credentials to continue.";
    $_SESSION['message_type'] = "info";
    header("Location: credential.php");
    exit;
}
ob_end_flush();

// Function to get the count from the database
function getCount($con, $query) {
    $result = mysqli_query($con, $query);
    return $result ? mysqli_num_rows($result) : 0;
}
?>

<div class="container my-4">
    <h3 class="mb-4">Dashboard</h3>

    <div class="row mb-4">
        <span class="mb-2">Tenants Analytics</span>
        <div class="col-sm-12 col-md-4 col-lg-3">
            <div class="card text-center index_card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?php echo getCount($con, "SELECT * FROM occupants WHERE bh_id = '$bh_id'"); ?></h4>
                        <span class="mb-0">Registered Tenants</span>
                    </div>
                    <div class="custom_icon">
                        <i class="fas fa-user-friends" aria-label="Registered Tenants" style="font-size: 3.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12 col-md-4 col-lg-3">
            <div class="card text-center index_card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?php echo getCount($con, "SELECT * FROM occupants WHERE gender = 'Male' AND bh_id = '$bh_id'"); ?></h4>
                        <span class="mb-0">Registered Male</span>
                    </div>
                    <div class="custom_icon">
                        <i class="fas fa-male" aria-label="Registered Male" style="font-size: 3.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12 col-md-4 col-lg-3">
            <div class="card text-center index_card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?php echo getCount($con, "SELECT * FROM occupants WHERE gender = 'Female' AND bh_id = '$bh_id'"); ?></h4>
                        <span class="mb-0">Registered Female</span>
                    </div>
                    <div class="custom_icon">
                        <i class="fas fa-female" aria-label="Registered Female" style="font-size: 3.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12 col-md-4 col-lg-3">
            <div class="card text-center index_card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4>₱<?php 
                            $total_payment_query = "SELECT SUM(total_rent_paid) AS total_sum FROM payment WHERE bh_id = '$bh_id'";
                            $total_payment_run = mysqli_query($con, $total_payment_query);
                            $payment_data = mysqli_fetch_assoc($total_payment_run);
                            echo $payment_data['total_sum'] !== null ? $payment_data['total_sum'] : 0;
                        ?></h4>
                        <span class="mb-0">Total Payment</span>
                    </div>
                    <div class="custom_icon">
                        <i class="fas fa-wallet" aria-label="Total Payment" style="font-size: 3.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <span class="mb-2">Room Analytics</span>
        <div class="col-sm-12 col-md-4 col-lg-3">
            <div class="card text-center index_card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?php echo getCount($con, "SELECT * FROM rooms WHERE bh_fk = '$bh_id'"); ?></h4>
                        <span class="mb-0">Number of Rooms</span>
                    </div>
                    <div class="custom_icon">
                        <i class="fas fa-door-open" aria-label="Number of Rooms" style="font-size: 3.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-3">
            <div class="card text-center index_card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?php echo getCount($con, "SELECT * FROM rooms WHERE vacant_bed > 0 AND bh_fk = '$bh_id'"); ?></h4>
                        <span class="mb-0">Vacant Rooms</span>
                    </div>
                    <div class="custom_icon">
                        <i class="fas fa-door-open" aria-label="Vacant Rooms" style="font-size: 3.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-3">
            <div class="card text-center index_card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?php echo getCount($con, "SELECT * FROM beds WHERE bh_id = '$bh_id'"); ?></h4>
                        <span class="mb-0">Total of Beds</span>
                    </div>
                    <div class="custom_icon">
                        <i class="fas fa-bed" aria-label="Total of Beds" style="font-size: 3.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-3">
            <div class="card text-center index_card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?php echo getCount($con, "SELECT * FROM beds WHERE status = 'available' AND bh_id = '$bh_id'"); ?></h4>
                        <span class="mb-0">Vacant Beds</span>
                    </div>
                    <div class="custom_icon">
                        <i class="fas fa-procedures" aria-label="Vacant Beds" style="font-size: 3.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
