<?php

include('header.php');
include('../../config/config.php');
include('../../middleware/middleware.php');

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    $getBookingData = "SELECT * FROM booking WHERE booking_id = '$booking_id'";
    $getBookingData_run = mysqli_query($con, $getBookingData);

    if (mysqli_num_rows($getBookingData_run) > 0) {
        $result = mysqli_fetch_assoc($getBookingData_run);
    }
} else {
    echo "No ID found!";
}

?>

<style>
    body {
    background-color: #f5f5f5; /* Soft background color */
    font-family: 'Poppins', sans-serif; /* Set font */
}

.container {
    margin-top: 20px;
}

.card {
    border-radius: 1rem; /* Rounded corners for cards */
    overflow: hidden; /* Ensures child elements are rounded */
}

.card-body {
    background-color: #ffffff; /* Card background */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

h5 {
    color: #08614E; /* Consistent theme color for headings */
}

legend {
    font-weight: bold;
    margin-bottom: 10px; /* Space below legends */
}

.form-group p {
    border: 1px solid #ddd; /* Light border around information */
    padding: 10px; /* Padding for better readability */
    border-radius: 0.5rem; /* Rounded edges */
    background-color: #f9f9f9; /* Light background for text */
}

.modal-content {
    border-radius: 1rem; /* Rounded modal */
}

.modal-header {
    border-bottom: none; /* Remove default border */
    background-color: #08614E; /* Modal header color */
    color: white; /* White text in modal header */
}

.modal-body textarea {
    border-radius: 0.5rem; /* Rounded textarea */
    border: 1px solid #ddd; /* Light border for textarea */
}

.btn {
    border-radius: 1rem; /* Rounded buttons */
    padding: 10px 20px; /* Adequate padding */
}

.btn-danger, .btn-success {
    transition: background-color 0.3s; /* Smooth transition */
}

.btn-danger:hover {
    background-color: #c82333; /* Darker red on hover */
}

.btn-success:hover {
    background-color: #218838; /* Darker green on hover */
}

img {
    border-radius: 0.5rem; /* Rounded image corners */
}

textarea {
    resize: none; /* Disable resizing */
}

</style>

<div class="container d-flex align-items-center">
    <div class="row w-100 justify-content-center align-items-center m-0">
        <div class="col-sm-12 col-md-10 col-lg-10">
            <div class="card border-1 shadow">
                <div class="card-body p-4">
                    <form action="reservationConfirmation.php" method="post" id="confirmForm">

                        <input type="hidden" name="bh_name" value="<?= htmlspecialchars($result['bh_name']) ?>">
                        <input type="hidden" name="bh_id" value="<?= htmlspecialchars($result['bh_id']) ?>">
                        <input type="hidden" name="room_id" value="<?= htmlspecialchars($result['room_id']) ?>">
                        <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking_id) ?>">

                        <div class="row mb-3">
                            <!-- Personal Information -->
                            <div class="col-12 col-lg-6 mb-3">
                                <fieldset>
                                    <legend>Personal Information</legend>
                                    <div class="form-group">
                                        <label for="name" style="font-weight: 700;">Name</label>
                                        <p id="name"><?= htmlspecialchars($result['fullname']) ?></p>
                                        <input type="hidden" name="fullname"
                                            value="<?= htmlspecialchars($result['fullname']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="gender" style="font-weight: 700;">Gender</label>
                                        <p id="gender"><?= htmlspecialchars($result['gender']) ?></p>
                                        <input type="hidden" name="gender"
                                            value="<?= htmlspecialchars($result['gender']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="course" style="font-weight: 700;">Course</label>
                                        <p id="course"><?= htmlspecialchars($result['course']) ?></p>
                                        <input type="hidden" name="course"
                                            value="<?= htmlspecialchars($result['course']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="address" style="font-weight: 700;">Address</label>
                                        <p id="address"><?= htmlspecialchars($result['address']) ?></p>
                                        <input type="hidden" name="address"
                                            value="<?= htmlspecialchars($result['address']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_no" style="font-weight: 700;">Contact Number</label>
                                        <p id="contact_no"><?= htmlspecialchars($result['contact_no']) ?></p>
                                        <input type="hidden" name="contact_no"
                                            value="<?= htmlspecialchars($result['contact_no']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_no" style="font-weight: 700;">Guardian Name</label>
                                        <p id="guardian"><?= htmlspecialchars($result['guardian_name']) ?></p>
                                        <input type="hidden" name="guardianName"
                                            value="<?= htmlspecialchars($result['guardian_name']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_no" style="font-weight: 700;">Guardian Name</label>
                                        <p id="guardianContact"><?= htmlspecialchars($result['guardian_contact']) ?></p>
                                        <input type="hidden" name="guardianContact"
                                            value="<?= htmlspecialchars($result['guardian_contact']) ?>">
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Booking Details</legend>
                                    <div class="form-group">
                                        <label for="check_in" style="font-weight: 700;">Check In</label>
                                        <p id="check_in"><?= htmlspecialchars($result['check_in']) ?></p>
                                        <input type="hidden" name="start_date"
                                            value="<?= htmlspecialchars($result['check_in']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="check_out" style="font-weight: 700;">Check Out</label>
                                        <p id="check_out"><?= htmlspecialchars($result['check_out']) ?></p>
                                        <input type="hidden" name="end_date"
                                            value="<?= htmlspecialchars($result['check_out']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="room_no" style="font-weight: 700;">Room Number</label>
                                        <p id="room_no"><?= htmlspecialchars($result['room_no']) ?></p>
                                        <input type="hidden" name="room_no"
                                            value="<?= htmlspecialchars($result['room_no']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="bed_no" style="font-weight: 700;">Bed Number</label>
                                        <p id="bed_no"><?= htmlspecialchars($result['bed_no']) ?></p>
                                        <input type="hidden" name="bed_no"
                                            value="<?= htmlspecialchars($result['bed_no']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="monthly_rent" style="font-weight: 700;">Monthly Rent</label>
                                        <p id="monthly_rent">₱ <?= htmlspecialchars($result['monthly_rent']) ?></p>
                                        <input type="hidden" name="monthly_rent"
                                            value="<?= htmlspecialchars($result['monthly_rent']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_amount" style="font-weight: 700;">Amount of Payment</label>
                                        <p id="payment_amount">₱ <?= htmlspecialchars($result['payment_amount']) ?></p>
                                        <input type="hidden" name="payment_amount"
                                            value="<?= htmlspecialchars($result['payment_amount']) ?>">
                                    </div>
                                </fieldset>
                            </div>

                            <!-- Room Information -->
                            <div class="col-12 col-lg-6 text-center">
                                <img src="../../user_uploads/<?= $result['image']?>" alt="image"
                                    class="img-fluid rounded shadow"
                                    style="width: 65%; height: 450px; border: 1px solid green;">
                                <div class="mt-3">
                                    <p><strong>Reference No.:</strong> <span><?= $result['reference_no']?></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons to trigger modals -->
                        <div class="d-flex justify-content-evenly mb-3" style="gap: 5px; margin-top: 1.5rem">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#rejectModal" style="width: 200px">Reject</button>
                            <button type="button" class="btn " data-bs-toggle="modal"
                                data-bs-target="#confirmModal" style="width: 200px; background-color: #08614e; color: white">Confirm</button>
                        </div>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="reservationConfirmation.php" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel" style="color: white">Reject Reservation</h5>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <div class="modal-body">
                                            <textarea class="form-control" id="rejectReason" name="reject_reason"
                                                rows="4" placeholder="Enter your Message here..."
                                                title="Please enter the reason to continue.." required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="submit_reject"
                                                class="btn btn-sm btn-danger">Reject</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Modal -->
                        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="reservationConfirmation.php" method="post">

                                        <input type="hidden" name="bh_name"
                                            value="<?= htmlspecialchars($result['bh_name']) ?>">
                                        <input type="hidden" name="bh_id"
                                            value="<?= htmlspecialchars($result['bh_id']) ?>">
                                        <input type="hidden" name="room_id"
                                            value="<?= htmlspecialchars($result['room_id']) ?>">
                                        <input type="hidden" name="booking_id"
                                            value="<?= htmlspecialchars($booking_id) ?>">

                                        <input type="hidden" name="fullname"
                                            value="<?= htmlspecialchars($result['fullname']) ?>">
                                        <input type="hidden" name="gender"
                                            value="<?= htmlspecialchars($result['gender']) ?>">
                                        <input type="hidden" name="course"
                                            value="<?= htmlspecialchars($result['course']) ?>">
                                        <input type="hidden" name="address"
                                            value="<?= htmlspecialchars($result['address']) ?>">
                                        <input type="hidden" name="contact_no"
                                            value="<?= htmlspecialchars($result['contact_no']) ?>">

                                        <input type="hidden" name="guardianName"
                                            value="<?= htmlspecialchars($result['guardian_name']) ?>">
                                        <input type="hidden" name="guardianContact"
                                            value="<?= htmlspecialchars($result['guardian_contact']) ?>">

                                        <input type="hidden" name="start_date"
                                            value="<?= htmlspecialchars($result['check_in']) ?>">
                                        <input type="hidden" name="end_date"
                                            value="<?= htmlspecialchars($result['check_out']) ?>">
                                        <input type="hidden" name="room_no"
                                            value="<?= htmlspecialchars($result['room_no']) ?>">
                                        <input type="hidden" name="bed_no"
                                            value="<?= htmlspecialchars($result['bed_no']) ?>">
                                        <input type="hidden" name="monthly_rent"
                                            value="<?= htmlspecialchars($result['monthly_rent']) ?>">
                                        <input type="hidden" name="payment_amount"
                                            value="<?= htmlspecialchars($result['payment_amount']) ?>">


                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmModalLabel" style="color: white">Confirm Reservation</h5>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <div class="modal-body">
                                            <textarea class="form-control" id="confirm_message" name="confirm_message"
                                                rows="4" placeholder="Enter your Message here..."
                                                title="Please enter the message to continue.." required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="submit_confirm"
                                                class="btn btn-sm btn-success">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>