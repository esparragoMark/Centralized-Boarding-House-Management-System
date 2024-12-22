<?php 
session_start();
include("frontend_includes/header.php");
include("config/config.php");
?>

<style>
    body {
        background: white;
        font-family: 'Poppins', sans-serif;
         background: linear-gradient(white, #08614E);
        /* background-image: url('admin/assets/images/Untitled design.png'); 
        background-position: top center; 
        background-repeat: no-repeat; 
        position: relative; */
    }
    .container {
        max-width: 1140px;
    }
    .con2 {
        max-width: 920px;
        padding: 2rem;
        background-color: #e6f7f1; /* Light shade of your main color for contrast */
        border-radius: 10px; /* Optional: adds rounded corners for a softer look */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Optional: adds subtle shadow for depth */
        background-image: url('admin/assets/images/Untitled design.png'); 
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat; 
        position: relative;
    }

    h3{
        color: #08614E;
        font-weight: 700;
    }

    .form-group {
        position: relative;
        margin-bottom: 20px; /* Consistent spacing */
    }
    .form-group i {
        position: absolute;
        left: 15px;
        top: 67%;
        transform: translateY(-50%);
        color: #08614E;
    }

    .form-group label{
        color: #08614E; 
        margin-bottom: 5px;
    }

    .form-control {
        padding-left: 45px;
        height: 50px;
        border-radius: 25px;
        border: 1px solid #ced4da;
        font-size: 1rem; /* Adjust font size for consistency */
    }
    .form-control:focus {
        border-color: #08614E;
        box-shadow: none;
    }

    #total-rent {
        font-size: 1.1rem; 
        margin-top: 15px; 
        padding: 4px 5px; 
    }

    .pay-wrapper {
        display: flex;
        justify-content: space-between; /* Space between the total rent and the pay button */
        align-items: center; /* Center align items vertically */
        margin-top: 20px; /* Space above the pay-wrapper */
        padding: 10px; /* Padding around the pay-wrapper */
        border: 1px solid #08614E; /* Border to define the section */
        border-radius: 10px; /* Rounded corners */
        background-color: #ffffff; /* White background for contrast */
    }

    .pay-wrapper .btn {
        min-width: 100px; /* Minimum width for the button */
    }

    .pay-wrapper a {
        background-color: #08614E;
        color: #fff;
    }

    .pay-wrapper a:hover {
        background-color: #08614E;
        color: #000;
    }

    .carousel-img {
        height: 450px;
        object-fit: cover; /* Ensures the images maintain aspect ratio and fill the height */
        border-radius: 10px;
        
    }

    /* Carousel control icons style */
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5); /* Dark semi-transparent background */
        padding: 10px; /* Add some space around the icons */
        border-radius: 50%; /* Makes the control buttons circular */
    }

    /* Carousel controls hover effect */
    .carousel-control-prev-icon:hover, .carousel-control-next-icon:hover {
        background-color: rgba(0, 0, 0, 0.8); /* Darker background on hover */
    }

    /* Style for the entire carousel container */
    .carousel {
        margin-bottom: 20px;
        border-radius: 5px;
        background-color: #0a8f78;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Optional: adds subtle shadow for depth */
    }

    /* Make the carousel responsive */
    @media (max-width: 768px) {
        .carousel-img {
            height: 300px; /* Smaller height for mobile */
        }
    }

    @media (max-width: 576px) {
        .carousel-img {
            height: 200px; /* Even smaller height for very small screens */
        }
    }

    .back-button {
        border-radius: 5px;
        padding: 10px 15px;
        font-weight: bold;
    }

    .img-wrapper {
        position: relative;
        transition: transform 0.3s;
    }

    .img-wrapper:hover {
        transform: scale(1.05);
    }

    .card {
        transition: box-shadow 0.3s;
    }

    .card:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    }

    .card-body h5 {
        font-weight: 600;
        color: #08614E;
    }
    .modal-content {
    background-color: #08614E; /* Black background for the modal content */
    color: white; /* White text color for better contrast */
    }

    .footer .footer-text{
        color: white;
    }

    .beds-room{
        max-width: 920px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Optional: adds subtle shadow for depth */
        border-radius: 20px; /* Optional: adds rounded corners for a softer look */
        background-color: #ffffff;
        padding-top: 1rem;
        background-image: url('admin/assets/images/Untitled design.png');
        background-size: 1000px 1000px ; 
        background-position:  top center; 
        background-repeat: no-repeat; 
        position: relative; 
    }

    .text-available{
        background-color: #08614e;
        color: white;
        width: 200px;
        padding: .9rem;
        border-radius: 10px;
    }
</style>

<div class="container  beds-room" style="margin-bottom: 2rem;">
    <a class="btn back-button text-center" onclick="window.history.back();" style="background-color: #fff; color: #08614e; margin-bottom: 1rem; border-radius: 50%">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="row justify-content-center">
        <!-- DISPLAY FOR ROOM IMAGES -->
        <div class="col-lg-10 mb-3">
            <div id="roomImagesCarousel" class="carousel slide mb-4 p-1 " data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    if (isset($_SESSION['boarding_house_id']) && isset($_SESSION['room_id'])) {
                        $boardingHouseId = $_SESSION['boarding_house_id'];
                        $room_id = $_SESSION['room_id'];

                        // Fetching room images from the database
                        $get_room_image = "SELECT image FROM rooms WHERE room_id = '$room_id' AND bh_fk = '$boardingHouseId'";
                        $get_room_image_run = mysqli_query($con, $get_room_image);

                        if (mysqli_num_rows($get_room_image_run) > 0) {
                            $row = mysqli_fetch_assoc($get_room_image_run);
                            $images = $row['image']; // Image string from the database

                            // Split image string into an array
                            $imageArray = explode(',', $images);

                            // Loop through images and display in the carousel
                            $isActive = true; // Mark the first image as active
                            foreach ($imageArray as $image) {
                                echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . '">';
                                echo '<img src="landlord/room_bed_uploads/' . trim($image) . '" class="d-block w-100 carousel-img" alt="Room Image" style="height: 400px; object-fit: cover;">';
                                echo '</div>';
                                $isActive = false; // Set active to false after the first image
                            }
                        } else {
                            echo '<h3 class="text-center">No images found for this room.</h3>';
                        }
                    } else {
                        echo '<h3 class="text-center">Please Refresh the Page</h3>';
                    }
                    ?>
                </div>
                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- DISPLAYING THE BEDS -->
        <div class="col-lg-10">
            <div class=" d-flex justify-content-center">
             <h5 class="text-center mt-3 text-available" style="font-weight: 600; margin-bottom: 4rem">Available Beds</h5>
            </div>
            
            <div class="row">
                <?php
                if (isset($_GET['room_id'])) {
                    $room_id = $_GET['room_id'];
                    $_SESSION['room_id'] = $room_id;

                    // Get the boarding house ID from session
                    $bh_id = $_SESSION['boarding_house_id'];

                    $bed_query = "SELECT * FROM beds WHERE room_id = '$room_id' AND status = 'available' AND bh_id = '$bh_id'";
                    $bed_query_run = mysqli_query($con, $bed_query);

                    if (mysqli_num_rows($bed_query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($bed_query_run)) {
                            ?>
                            <div class="col-6 mb-3">
                                <div class="card text-center" style="border: 1px solid #08614E; border-radius: 10px; overflow: hidden;">
                                    <img src="landlord/room_bed_uploads/<?=$row['image']?>" alt="image" style="width: 100%; height: 190px; object-fit: cover;" class="img-wrapper"      data-bs-toggle="modal" data-bs-target="#bedImageModal" data-img-src="landlord/room_bed_uploads/<?=$row['image']?>">
                                    <div class="card-body" style="background-color: #f5f5f5;">
                                        <h5>Bed <?=$row['bed_number']?></h5>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="text-center">No beds available</p>';
                    }
                } else {
                    echo '<p class="text-center">Room ID not found!</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal for displaying full bed image -->
<div class="modal fade" id="bedImageModal" tabindex="-1" aria-labelledby="bedImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="bedImageModalLabel">Bed Image</h5> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" id="bedImage" class="img-fluid" alt="Full Bed Image" style="width: 100%; height: auto">
            </div>
        </div>
    </div>
</div>




<!-- New Container for Booking Form -->
<div class="container con2 booking-form-container shadow-0" style="margin-bottom: 1rem;">
    <?php
    $roomID = $_SESSION['room_id'];

    // GET THE ROOM NUMBER USING ROOM ID
    $room_data_query = "SELECT room_name, monthly_rent FROM rooms WHERE room_id = '$roomID' AND bh_fk = '$bh_id'";
    $room_data_query_run = mysqli_query($con, $room_data_query);
    $roomData = mysqli_fetch_assoc($room_data_query_run);
    
    // GET THE LIST OF AVAILABLE BED
    $bedList_query = "SELECT bed_number FROM beds WHERE room_id = '$roomID' AND status = 'available' AND bh_id = '$bh_id'";
    $bedList_query_run = mysqli_query($con, $bedList_query);

    // GET THE GCASH NUMBER OF THE BH
    $bh_data_query = "SELECT owner_phone, house_name FROM boarding_house_registration WHERE bh_id = '$bh_id'";
    $bh_data_query_run = mysqli_query($con, $bh_data_query);
    $bhData = mysqli_fetch_assoc($bh_data_query_run);
    ?>

    <form action="book_process.php" method="POST" enctype="multipart/form-data">
        <h3 class="text-center mb-5">Booking Form</h3>

        <input type="hidden" name="bh_id" value="<?=$bh_id?>">
        <input type="hidden" name="bh_name" value="<?=$bhData['house_name']?>">
        <input type="hidden" name="room_id" value="<?=$roomID?>">

        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="form-group ">
                    <label for="check-in">Select Check-In Date</label>
                    <span><i class="fas fa-calendar-alt"></i></span> <!-- Check-in icon -->
                    <input type="date" id="check-in" name="check_in" class="form-control" required onchange="calculateRent()">
                </div>
            </div>

            <div class="col-sm-12 col-lg-6">
                <div class="form-group ">
                    <label for="check-out">Select Check-Out Date</label>
                    <span><i class="fas fa-calendar-alt"></i></span> <!-- Check-out icon -->
                    <input type="date" id="check-out" name="check_out" class="form-control" required onchange="calculateRent()">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="form-group ">
                    <label for="room-number">Room Number</label>
                    <span><i class="fas fa-door-open"></i></span> <!-- Room Number icon -->
                    <input type="text" id="room-number" name="room_number" class="form-control" value="<?=$roomData['room_name']?>" readonly>
                </div>
            </div>

            <div class="col-sm-12 col-lg-6">
                <div class="form-group ">
                    <label for="bed-number">Select Bed Number</label>
                    <span><i class="fas fa-bed"></i></span> <!-- Bed Number icon -->
                    <select id="bed-number" name="bed_number" class="form-control" required>
                        <?php
                        if (mysqli_num_rows($bedList_query_run) > 0) {
                            while ($beds = mysqli_fetch_assoc($bedList_query_run)) {
                                echo '<option value="' . htmlspecialchars($beds['bed_number']) . '">' . htmlspecialchars($beds['bed_number']) . '</option>';
                            }
                        } else {
                            echo '<option value="">No Bed Available</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="form-group icon-input">
                    <label for="monthly-rent">Monthly Rent</label>
                    <span><i class="fas fa-money-bill-wave"></i></span> <!-- Monthly Rent icon -->
                    <input type="number" id="monthly-rent" name="monthly_rent" class="form-control" value="<?=$roomData['monthly_rent']?>" readonly required>
                </div>
            </div>

            <div class="col-sm-12 col-lg-6">
                <div class="form-group icon-input">
                    <label for="gcashNum">Gcash Number</label>
                    <span><i class="fas fa-phone"></i></span> <!-- Gcash Number icon -->
                    <input type="text" id="gcashNum-rent" name="gcashNum" class="form-control" value="<?=$bhData['owner_phone']?>" readonly required>
                </div>
            </div>
        </div>

        <!-- FOR PAYMENT AMOUNT -->

        <div class="pay-wrapper">

            <input type="hidden" id="total-rent-input" name="total_rent" value="0.00">
            <div id="total-rent" class="form-group float-end">
                Total Rent: ₱0.00
            </div>

            <!--<a href="#" class="btn" target="_blank">Pay</a>-->
            <div></div>

        </div>
        <hr>

        <!-- FOR PAYMENT EVIDENCE -->
        <div class="form-group">
            <label for="image">Payment Screenshot</label>
            <span><i class="fas fa-image"></i></span> <!-- Payment Screenshot icon -->
            <input type="file" id="image" name="image" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="reference_no">Reference No.</label>
            <span><i class="fas fa-file-alt"></i></span> <!-- Reference No. icon -->
            <input type="text" id="reference_no" name="reference_no" class="form-control" required pattern="\d{13}" placeholder="Enter 13-Digit Reference Number" title="Please enter exactly 13 digits" maxlength="13" inputMode="numeric">
        </div>
        <hr>

        <button type="submit" class="btn btn-custom btn-block" name="btnBook">Book</button>
    </form>
</div> <!-- End of new container for booking form -->



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add click event listener to all bed images
        const bedImages = document.querySelectorAll('.img-wrapper');
        bedImages.forEach(image => {
            image.addEventListener('click', function () {
                const imgSrc = this.dataset.imgSrc; // Get the image source from the data attribute
                const fullImage = document.getElementById('bedImage');
                fullImage.src = imgSrc; // Set the source of the full image in the modal
            });
        });
    });
</script>

<?php 
include("frontend_includes/footer.php");
?>
