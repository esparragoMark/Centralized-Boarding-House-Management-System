<?php 
session_start();
include("frontend_includes/header.php");
include("config/config.php");

if (isset($_SESSION['authentication']) && $_SESSION['authentication'] === true) {
  
    if (isset($_SESSION['auth_user']['name'])) {
        $user_name = $_SESSION['auth_user']['name'];
    } else {
        $user_name = "";
    }
} else {
    $user_name = "";
}


// for fetching rating

if(isset($_SESSION['boarding_house_id']))
{
    $boardingHouseId = $_SESSION['boarding_house_id'];

        // Use the variable directly in the SQL query (Not recommended for production without proper sanitization)
    $sql = "SELECT * FROM rating WHERE bh_id = $boardingHouseId ORDER BY time DESC";
    $result = $con->query($sql);

    // Initialize variables for overall rating calculation
    $totalRating = 0;
    $ratingCounts = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
    $totalReviews = 0;

    // Process the result
    while ($row = $result->fetch_assoc()) {
        $rating = $row['rating_count'];
        if (isset($ratingCounts[$rating])) {
            $ratingCounts[$rating]++;
            $totalRating += $rating;
            $totalReviews++;
        }
    }

    // Calculate average rating
    $averageRating = $totalReviews > 0 ? number_format($totalRating / $totalReviews, 1) : 0;
    $ratingPercentages = array();
    foreach ($ratingCounts as $rating => $count) {
        $ratingPercentages[$rating] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
    }

    


}
else{
    echo '<h1 class="text-center">Something Went Wrong!</h1>';
}

?>

<style>
body {
    background-color: #f5f5f5;
    font-family: 'Poppins', sans-serif;

}

.container {
    max-width: 1140px;
}

.con2 {
    max-width: 1300px;
}

.row .profile-data {
    background-color: #08614E;
    border-top-left-radius: 20px;
    border-bottom-left-radius: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    /* Adds a subtle shadow */
}

.row .profile-data .bh-name,
.data {
    color: #fff;
}

.row .rating-section {
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    /* Adds a subtle shadow */
}

.gender-btn,
.map-btn {
    background-color: #fff;
    color: #08614E;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    transition: all 0.3s ease;
    transform: translateY(0);
    /* Default position */
}


.gender-btn:hover,
.map-btn:hover {
    border: 1px solid #fff;
    background-color: #08614E;
    color: #fff;
    /* Ensures the text stays white on hover */
    transform: translateY(-5px);
    /* Moves button up slightly on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.6);
    /* Deepens shadow on hover */
}


.review-btn {
    background-color: #08614E;
    color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    /* Adds a stronger shadow to buttons */
    transition: all 0.3s ease;
    transform: translateY(0);
    /* Default position */
}

.review-btn:hover {
    background-color: #fff;
    border: 1px solid #08614e;
    color: #08614e;
    transform: translateY(-5px);
    /* Moves button up slightly on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.6);
    /* Deepens shadow on hover */
}

.rating-title h4 {
    font-weight: 600;
}

.data {
    font-size: .8rem
}

.bh-name {

    font-weight: 600;
}

.circle-bg {
    background-color: #08614E;
}

.maleroom,
.femaleroom {
    font-weight: 600;
}

.roomnumber {
    font-size: 1.2rem;
    font-weight: 600;
    color: #08614e;
    margin-top: 5px;
}

.gender {
    font-size: .9rem;
    color: #08614e;
}

.roomprice {
    font-size: 1.1rem;
    color: red;
}

.amenities-title {
    margin-top: 10px;
    font-size: .9rem;
    color: #08614E;
}

.ul-li .li {
    font-size: .8rem;
    margin-right: 5px;
}


/* room design */
.room-container {
    padding-bottom: 30px;
    padding-top: 30px;
}

.room-container h2 {
    color: #fff;
}

.room-container .noroom1,
.noroom2 {
    margin-top: 20%;
    font-size: 2rem;
    font-weight: 500;
}

.noroom1 {
    color: #fff;
}

.room-title {
    font-weight: 600;
    color: #08614E;
    margin-bottom: 15px;
}

.room-price {
    font-size: 1.2rem;
    color: red;
}

.amenities-title {
    margin-top: 10px;
    font-size: 1rem;
    color: #08614E;
}

.ul-li {
    list-style: none;
    padding: 0;
    font-size: .8rem;
}

.circle-bg {
    background-color: #08614E;
    color: white;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-shrink: 0; /* Prevents shrinking */
}

.room-card {
    transition: transform 0.2s;
}

.room-card:hover {
    transform: translateY(-10px);
}

.btn-primary {
    background-color: #08614E;
    border: none;
}

.btn-primary:hover {
    background-color: #064d3b;
}

.footer {
    color: #fff;
    /* background-color:#08614e; */
}

.room-box {
    background-color: #08614E;
    min-height: 100vh;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    border-radius: 20px;
}

.room-box-male {
    margin-bottom: 2.5rem;
    border-radius: 100px;
}

.room-box-female {
    background-color: #fff;
    border-radius: 100px;
}

.room-box-female h2 {
    color: #08614E;
}

.maleRoomText,
.femaleRoomText {
    display: flex;
    justify-content: center;
}

.maleRoomText .room-title {
    background-color: #fff;
    color: #08614e;
    padding: .7rem;
    border-top-left-radius: 30px;
    border-bottom-right-radius: 30px;
}

.femaleRoomText .room-title {
    background-color: #08614e;
    color: #fff;
    padding: .7rem;
    border-top-left-radius: 30px;
    border-bottom-right-radius: 30px;
}

.footer .footer-text {
    color: #08614e;
}

.top-con{
    margin-top: 4rem;
    margin-bottom: 6rem;
}

.feedback-content{
    padding-left: 15px;
}

@media (max-width: 576px) {
    .room-box-male{
        border-radius: 0px;
        margin-bottom: 0;
        margin-top: 0;
        box-shadow: none;
    }
    .room-box-female{
        border-radius: 0px;
        box-shadow: none;
    }
    .row .profile-data{
        border-radius: 0px;
        min-height: 100vh;
        box-shadow: none;
    }
    .row .rating-section{
        border-radius: 0px;
        min-height: 100vh;
        box-shadow: none;
    }

    .top-con{
        margin: 0;
    }

    .feedback-content{
        padding-left: 0;
    }

}
</style>

<div class="top-con">
    <div class="container con2">
        <div class="row">
            <div class=" col-sm-12 col-lg-7 profile-data">

                <?php
                
                    // Get boarding house ID from session
                    $sql_query_bh = "SELECT * FROM boarding_house_registration WHERE bh_id = '$boardingHouseId'";
                    $sql_query_bh_run = mysqli_query($con, $sql_query_bh );

                    if(mysqli_num_rows($sql_query_bh_run ) > 0){
                        $result = mysqli_fetch_assoc($sql_query_bh_run);
                            ?>
                <div class="row bhroom-p">
                    <div class="col-sm-12 col-lg-6 d-flex justify-content-center mb-2">
                        <!-- Balyuan ang parameter sa image kay iba ina -->
                        <img class="rounded" src="landlord/landlord_uploads/<?=$result['bhImage']?>" alt="image"
                            style="width: 100%; height: 300px">
                    </div>

                    <div class="col-sm-12 col-lg-6 d-flex flex-column justify-content-center">
                        <div class="mb-2">
                            <h5 class="bh-name"><?=$result['house_name']?></h5>
                        </div>
                        <div class="d-flex align-items-center mb-2 ">
                            <i class="fas fa-phone-alt mr-2 text-success"></i>
                            <p class="data"><?=$result['owner_phone']?></p>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-danger"></i>
                            <p class="data">Near at <?=$result['house_location']?></p>
                        </div>


                        <div class="m-0">
                            <button type="button" class="btn btn-link  data" data-bs-toggle="modal"
                                data-bs-target="#termsModal">
                                Terms and Conditions
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="termsModalLabel">Terms & Conditions</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Your terms and conditions text here -->
                                        <textarea class="form-control" rows="4" style="height: 600px;"
                                            disabled><?=$result['terms_and_conditions']?></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="write-review mt-3">
                            <a href="#male-rooms" class="btn gender-btn btn-sm">Male Room</a>
                            <a href="#female-rooms" class="btn gender-btn btn-sm">Female Room</a>
                            <button type="button" class="btn map-btn  btn-sm" onclick="viewMap()">View
                                Map</button>

                        </div>
                    </div>
                </div>



                <!--Google Map -->

                <div id="map-container" class="map-container mt-4">
                    <?php
                    // Get the house name from the result and format it
                    $house_name = $result["house_name"];
                    
                    // Prepare the formatted query string
                    $formatted_house_name = str_replace(' ', '+', $house_name) . ',+Debesmscat';
                    ?>

                    <iframe src="https://www.google.com/maps?q=<?=$formatted_house_name;?>&z=14&output=embed"
                        style="width:100%; height: 400px" id="map"></iframe>
                </div>


                <?php
                    }
                    else{
                        echo "Something went wrong: " . $mysqli->error;
                    }
                ?>

            </div>

            <!-- Rating Section -->
            <div class="col-sm-12 col-lg-5 rating-section">
                <div class="rating-title mt-3">
                    <h4>Rating</h4>
                </div>


                <div class="row">

                    <!-- overall rating -->
                    <div class="col-sm-12 col-lg-4 d-flex flex-column align-items-center text-center mt-5">
                        <p>Overall Rating</p>
                        <h1><?php echo $averageRating; ?></h1>
                        <p class="stars">
                            <?php
                            $fullStars = floor($averageRating);
                            $halfStar = ($averageRating - $fullStars) >= 0.5;
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $fullStars) {
                                    echo '<i class="fas fa-star mr-1 text-warning"></i>';
                                } elseif ($i == $fullStars + 1 && $halfStar) {
                                    echo '<i class="fas fa-star-half-alt mr-1 text-warning"></i>';
                                } else {
                                    echo '<i class="fas fa-star mr-1"></i>';
                                }
                            }
                            ?>
                        </p>
                        <p class="reviews">
                            <span class="review-number"><?php echo $totalReviews; ?></span> Review(s)
                        </p>
                    </div>


                    <!-- rating section -->
                    <div class="col-sm-12 col-lg-8 mt-3">
                        <?php foreach (range(5, 1) as $rating) : ?>
                        <div class="rate-content d-flex justify-content-center align-items-center gap-2">
                            <h5 class="rate-number"><?php echo $rating; ?></h5>
                            <!-- Progress Bar -->
                            <div class="progress mt-2" role="progressbar" aria-label="Example 20px high"
                                aria-valuenow="<?php echo $ratingPercentages[$rating]; ?>" aria-valuemin="0"
                                aria-valuemax="100" style="height: 10px; width: 250px">
                                <div class="progress-bar bg-success"
                                    style="width: <?php echo $ratingPercentages[$rating]; ?>%"></div>
                            </div>
                            <!-- End -->
                            <span>(<?php echo $ratingCounts[$rating]; ?>)</span>
                        </div>
                        <?php endforeach; ?>

                        <!-- Write a Review Button -->
                        <div class="write-review mt-3 text-center">
                            <button type="button" class="btn btn-sm review-btn" data-bs-toggle="modal"
                                data-bs-target="#reviewModal">
                                Write a Review
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <!-- Centered Modal -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Rating Stars -->
                                <h4 class="text-center mt-2 mb-4">
                                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1"
                                        data-rating="1"></i>
                                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2"
                                        data-rating="2"></i>
                                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3"
                                        data-rating="3"></i>
                                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4"
                                        data-rating="4"></i>
                                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5"
                                        data-rating="5"></i>
                                </h4>

                                <!-- User Name Input -->
                                <div class="form-group mb-3">
                                    <input type="hidden" name="user_name" id="user_name" value="<?=$user_name?>"
                                        class="form-control">
                                    <input type="hidden" name="bh_id" id="bh_id" value="<?=$boardingHouseId?>"
                                        class="form-control">
                                </div>

                                <!-- User Review Input -->
                                <div class="form-group mb-3 d-flex justify-content-center">
                                    <textarea name="user_review" id="user_review" class="form-control" rows="4"
                                        placeholder="Type Review Here...."
                                        style="width: 320px; padding-left: 10px; height: 150px"></textarea>
                                </div>


                                <!-- Submit Button -->
                                <div class="form-group text-center mt-4">
                                    <button type="button" class="btn" id="save_review" style="background-color: #08614e; color: white">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- feedback section -->
                <div class="mt-3">
                    <p>Feedback</p>
                    <!-- Scroll Part -->
                    <div class="display-feedback">
                        <?php
                        // Execute the query and fetch results
                        $sql = "SELECT * FROM rating WHERE bh_id = '$boardingHouseId' ORDER BY time DESC";
                        $result = $con->query($sql);

                        if ($result) {
                            // Fetch all results as an associative array
                            $feedbacks = $result->fetch_all(MYSQLI_ASSOC);

                            foreach ($feedbacks as $feedback) {
                                $ratingCount = $feedback['rating_count'];
                                ?>
                        <div class="feedback-content mb-3">
                            <div class="circle circle-bg">
                                <h5><?php echo htmlspecialchars(substr($feedback['user_name'], 0, 1)); ?></h5>
                            </div>
                            <div class="text-content">
                                <p class="name-text">
                                    <?php echo htmlspecialchars($feedback['user_name']); ?>
                                    <!-- Star Rating -->
                                    <span class="ml-2">
                                        <?php
                                                // Display star rating
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $ratingCount) {
                                                        echo '<i class="fas fa-star text-warning"></i>';
                                                    } else {
                                                        echo '<i class="fas fa-star"></i>';
                                                    }
                                                }
                                                ?>
                                    </span>
                                </p>
                                <div class="message-text">
                                    <p><?php echo htmlspecialchars($feedback['user_review']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo "<h1 class='text-center'>No Feedback Available!</h1>";
                        }

                        // Free result set
                        $result->free();
                        ?>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>


<!-- =============================================================================================================== -->

<div class="room-box room-box-male">
    <!-- Male room container -->
    <div class="container room-container" id="male-rooms">
        <div class="maleRoomText">
            <h2 class="mb-5 text-center  room-title">Male Room</h2>
        </div>

        <div class="row">
            <?php
                // Query to get all rooms for the specified boarding house
                $room_query = "SELECT * FROM rooms WHERE gender = 'Male' AND vacant_bed > 0 AND bh_fk = '$boardingHouseId'";
                $room_query_run = mysqli_query($con, $room_query);

                if (mysqli_num_rows($room_query_run) > 0) {
                    foreach ($room_query_run as $room) {
                        $image_array = explode(',', $room['image']); 
                        $first_image = $image_array[0]; 
                        $amenities_array = explode(',', $room['description']); 
                        ?>
            <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                <div class="card room-card shadow-sm">
                    <img src="landlord/room_bed_uploads/<?=$first_image?>" alt="Room Image" class="card-img-top"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="room-title">Room No. <?=$room['room_name']?></h6>
                        <span class="room-price">PHP <?=$room['monthly_rent']?></span><br>
                        <span class="amenities-title">Amenities:</span>
                        <ul class="ul-li">
                            <?php foreach ($amenities_array as $amenity) { ?>
                            <li><i class="fas fa-check-square text-success"></i> <?=$amenity?></li>
                            <?php } ?>
                        </ul>
                        <div class="text-center mt-3">
                            <a href="book.php?room_id=<?=$room['room_id']?>" class="btn btn-primary"
                                style="width: 100%;">Book</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo '<p class="text-center noroom1">No Rooms Available!</p>';
                }
                ?>
        </div>
    </div>
</div>

<div class="room-box room-box-female">
    <!-- Female room container -->
    <div class="container room-container" id="female-rooms">
        <div class="femaleRoomText">
            <h2 class="mb-5 text-center room-title">Female Room</h2>
        </div>
        <div class="row">
            <?php
                $room_query_female = "SELECT * FROM rooms WHERE gender = 'Female' AND vacant_bed > 0 AND bh_fk = '$boardingHouseId'";
                $room_query_female_run = mysqli_query($con, $room_query_female);

                if (mysqli_num_rows($room_query_female_run) > 0) {
                    foreach ($room_query_female_run as $female_room) {
                        $image_array = explode(',', $female_room['image']); 
                        $first_image = $image_array[0]; 
                        $amenities_array = explode(',', $female_room['description']); 
                        ?>
            <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                <div class="card room-card shadow-sm">
                    <img src="landlord/room_bed_uploads/<?=$first_image?>" alt="Room Image" class="card-img-top"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="room-title">Room No. <?=$female_room['room_name']?></h6>
                        <span class="room-price">PHP <?=$female_room['monthly_rent']?></span><br>
                        <span class="amenities-title">Amenities:</span>
                        <ul class="ul-li">
                            <?php foreach ($amenities_array as $amenity) { ?>
                            <li><i class="fas fa-check-square text-success"></i> <?=$amenity?></li>
                            <?php } ?>
                        </ul>
                        <div class="text-center mt-3">
                            <a href="book.php?room_id=<?=$female_room['room_id']?>" class="btn btn-primary"
                                style="width: 100%;">Book</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo '<p class="text-center noroom2 ">No Rooms Available!</p>';
                }
                ?>
        </div>
    </div>

</div>




<?php include("frontend_includes/footer.php"); ?>