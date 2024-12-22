<?php 
session_start();
include("frontend_includes/header.php");
include("config/config.php");

// Check if the user is authenticated
if(isset($_SESSION['authentication'])) {
    $userID = $_SESSION['auth_user']['id'];
} else {
    $_SESSION['message'] = "Please Log in!";
    $_SESSION['message_type'] = "warning";
    header('Location: login.php');
    exit;
}

// Get all bookings for the authenticated user, ordered by booking_id in descending order
$getBooking = "SELECT * FROM booking WHERE user_id = '$userID' ORDER BY booking_id DESC";
$getBooking_run = mysqli_query($con, $getBooking);
?>

<style>
    body {
        background-color: #f5f5f5;
        font-family: 'Poppins', sans-serif; /* Set the new font */
        background-image: url('admin/assets/images/Untitled design.png'); /* Add your background image */
        background-size: cover; /* Cover the entire background */
        background-position: center; /* Center the background image */
        background-repeat: no-repeat; /* Prevent repeating the background image */
        position: relative; /* Position relative for absolute elements */
    }
    .container {
        max-width: 1140px;
        
    }

    .con2{
        max-width: 900px;
        height: 90vh;
        padding: .5rem;
        margin-top: 1rem;
        background-color: #ffffff; /* Light shade of your main color for contrast */
        border-radius: 10px; /* Optional: adds rounded corners for a softer look */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Optional: adds subtle shadow for depth */
        overflow: auto;
    }

    i {
        color: #08614E;
    }

    .drop-holder {
        display: flex;
        flex-direction: column; /* Change to column layout */
        border: 1px solid #08614E;
        border-radius: 3px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Optional: adds subtle shadow for depth */
        cursor: pointer;
        background-color: #fff;
        transition: background-color 0.3s ease-in-out;
        width: 100%; /* Maximize width to 100% of container */
        margin-bottom: 15px; /* Add margin for spacing */
        overflow: hidden
    }

    .drop-holder:hover {
        background-color: #f0f0f0;
    }

    .row.drop {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-in-out; /* Smooth transition using max-height */
        padding: 0; /* Remove padding to align with drop-holder */
    }

    .drop-holder.active .row.drop {
        max-height: 1000px; /* Set a large max-height to ensure it expands */
    }

    button {
        background: none;
        border: none;
        outline: none;
        font-size: 1.25rem;
        cursor: pointer;
    }

    button:focus {
        outline: none;
    }

    button i {
        transition: transform 0.3s ease-in-out;
    }

    .drop-holder.active button i {
        transform: rotate(180deg);
    }

    .modal-header {
        background-color: #fff;
        color: #fff;
    }

    .btn-success, .btn-danger {
        background-color: #08614E;
        border-color: #08614E;
    }

    .btn-success:hover, .btn-danger:hover {
        background-color: #0a7c60;
    }

    /* Modern Heading Styles */
    h5 {
        font-size: 1.5rem; /* Increase size for prominence */
        font-weight: 600; /* Semi-bold */
        color: #08614E; /* Main theme color */
        margin: 0; /* Reset margin */
    }

    h6 {
        font-size: 1rem; /* Slightly larger for emphasis */
        font-weight: 500; /* Medium weight */
        color: #333; /* Dark grey for readability */
        text-transform: uppercase; /* Make text uppercase for modern look */
        letter-spacing: 0.5px; /* Slightly increase letter spacing */
    }

    h2{
        font-weight: 500;
        color: #08614E;
        margin-bottom: 1rem
    }

    /* Additional styles for lists */
    ul.list-unstyled {
        padding-left: 0; /* Remove default padding */
    }

    ul.list-unstyled li {
        font-size: 1rem; /* Set a consistent font size */
        color: #555; /* Dark grey for better readability */
    }

    span{
        font-size: 0.8rem
    }

    .empty-image {
        max-width: 350px;
        height: auto;
        margin: 20px auto;
        display: block;
        opacity: 0.85;
        margin-top: 5rem;
    }

    .footer .footer-text{
        color: #08614e;
    }

</style>

<div class="container con2">
    <div class="row justify-content-center align-items-center m-0">
       
        <div class="col-12 col-lg-10 mt-5">
            <!-- <h2>Reservation</h2> -->
            <?php
            // Check if there are any bookings
            if(mysqli_num_rows($getBooking_run) > 0) {
                // Loop through each booking and display the details
                while($booking = mysqli_fetch_array($getBooking_run)) {
                    // Generate unique IDs for the modals
                    $modalIdReject = "messageModalReject" . $booking['booking_id'];
                    $modalIdConfirm = "messageModalConfirm" . $booking['booking_id'];
            ?>
                <div class="drop-holder">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <h5 class="mb-0">Booking ID: <?=$booking['booking_id']?></h5>
                        <button>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="row drop p-4 mb-4">
                        <!-- Personal Information -->
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <h6 class="mb-4">Personal Information</h6>
                            <ul class="list-unstyled">
                                <li style="margin-bottom: 10px;"><i class="fas fa-user"></i><span><?php echo $booking['fullname']; ?></span></li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-male"></i><span><?php echo $booking['gender']; ?></span> </li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-graduation-cap"></i><span> <?php echo $booking['course']; ?></span></li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-map-marker-alt"></i><span><?php echo $booking['address']; ?></span> </li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-phone"></i><span><?php echo $booking['contact_no']; ?></span> </li>
                            </ul>
                        </div>
                        <!-- Room Information -->
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <h6 class="mb-4">Booking Information</h6>
                            <ul class="list-unstyled">
                                <li style="margin-bottom: 10px;"><i class="fas fa-building"></i><span>BH: <?php echo $booking['bh_name']; ?></span> </li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-calendar-alt"></i><span>Check In: <?php echo $booking['check_in']; ?></span> </li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-calendar-alt"></i><span>Check Out: <?php echo $booking['check_out']; ?></span> </li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-door-closed"></i><span>Room: <?php echo $booking['room_no']; ?></span> </li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-bed"></i><span>Bed: <?php echo $booking['bed_no']; ?></span> </li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-money-bill-wave"></i><span>Monthly Rent: ₱<?php echo $booking['monthly_rent']; ?></span> </li>
                                <li style="margin-bottom: 10px;"><i class="fas fa-coins"></i><span>Total Rent: ₱<?php echo $booking['payment_amount']; ?></span> </li>
                            </ul>
                        </div>
                        <!-- Status Information -->
                        <div class="col-lg-4 text-center">
                            <h6 class="mb-4">Status</h6>
                            <div class="d-flex flex-column align-items-center">
                                <?php if($booking['status'] == 'pending'): ?>
                                    <div class="spinner-border text-warning mb-2" role="status"></div>
                                    <h4 class="text-warning"><?php echo ucfirst($booking['status']); ?></h4>
                                <?php elseif($booking['status'] == 'confirmed'): ?>
                                    <i class="fas fa-check-circle text-success mb-2" style="font-size: 2rem;"></i>
                                    <h4 class="text-success"><?php echo ucfirst($booking['status']); ?></h4>
                                    <!-- Confirmation Button -->
                                    <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#<?php echo $modalIdConfirm; ?>">
                                        Message
                                    </button>
                                    <!-- Confirmation Modal -->
                                    <div class="modal fade" id="<?php echo $modalIdConfirm; ?>" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="messageModalLabel"><i class="fas fa-comment-dots"></i> Message</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?php echo $booking['confirm_message']; ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: // rejected status ?>
                                    <i class="fas fa-times-circle text-danger mb-2" style="font-size: 2rem;"></i>
                                    <h4 class="text-danger"><?php echo ucfirst($booking['status']); ?></h4>
                                    <!-- Rejection Button -->
                                    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#<?php echo $modalIdReject; ?>">
                                        Message
                                    </button>
                                    <!-- Rejection Modal -->
                                    <div class="modal fade" id="<?php echo $modalIdReject; ?>" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="messageModalLabel"><i class="fas fa-comment-dots"></i> Message</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?php echo $booking['reject_reason']; ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                   
                </div>
            <?php 
                }
            } else {
                echo '
                    <div class="text-center text-muted py-4">
                    <img src="No_Record2.png" alt="empty" class="empty-image" style="width: 500px; height: auto">
                    </div>';
            }
            ?>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle the dropdown functionality
    document.querySelectorAll('.drop-holder').forEach(item => {
        item.addEventListener('click', event => {
            item.classList.toggle('active');
        });
    });
</script>

<?php include("frontend_includes/footer.php"); ?>
