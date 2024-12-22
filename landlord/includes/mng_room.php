<?php
// Include necessary files and initiate session
ob_start();
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

// Store boarding house ID in session if found, else redirect to credential submission
if ($result) {
    $_SESSION['BH-ID'] = $result['bh_id'];
}
else{
    $_SESSION['message'] = "No boarding house found. Please submit your credentials.";
    $_SESSION['message_type'] = "warning";
    header("Location: credential.php");
    exit();
}

$bh_id = isset($_SESSION['BH-ID']) ? $_SESSION['BH-ID'] : 0;

// Handle search functionality
$search = isset($_POST['search']) ? $_POST['search'] : '';

$sql = "SELECT * FROM rooms WHERE bh_fk = ? AND room_name LIKE ?";
$stmt = $con->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($con->error));
}

$search_param = "%$search%";
$stmt->bind_param("is", $bh_id, $search_param);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}
ob_end_flush();
?>

<div class="container my-4">
    <h3 class="mb-4">Manage Room</h3>
    <div class="d-flex justify-content-between align-items-center mb-3"
        style="border: none; padding: 1rem; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <form class="input-group w-50 mng_room_custom" method="post">
            <div class="input-group-append"
                style="display: flex; align-items: center; justify-content: center; background-color: #08614E; width: 400px; border-radius: 4px">
                <button class="btn  btn-save" type="submit" style="background-color: #08614e; color: white">
                    <i class="fas fa-search" style="color: #ffffff"></i>
                </button>
                <input type="text" name="search" class="form-control" placeholder="search room..."
                    style="border: 1px solid rgba(8, 97, 78, 0.25); color: #08614E">
            </div>
        </form>
        <button class="btn " data-bs-toggle="modal" data-bs-target="#addRoomModal"
            style="background-color: #08614e; color: white">
            <i class="fas fa-plus"></i> Add Room
        </button>
    </div>


    <div class="row" id="room_refresh" style="padding-top: 10px; border-radius: 4px">
        <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card card-custom h-60 shadow-sm">
                <div class="card-img-top-container">
                    <?php 
                // Split the comma-separated image list
                $images = explode(',', $row['image']);
                ?>
                    <!-- Loop through each image and display -->
                    <div id="carouselRoomImages<?= htmlspecialchars($row['room_id']) ?>" class="carousel slide"
                        data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($images as $index => $image): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="../room_bed_uploads/<?= htmlspecialchars($image) ?>"
                                    class="card-img-top img-fluid" alt="Room Image">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselRoomImages<?= htmlspecialchars($row['room_id']) ?>"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselRoomImages<?= htmlspecialchars($row['room_id']) ?>"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="card-title text-truncate" style="color: #08614E; font-weight: 600">Room
                            <?= htmlspecialchars($row['room_name']) ?></h6>
                        <div class="dropdown">
                            <button class="btn btn-link text-dark p-0" type="button"
                                id="dropdownMenuButton<?= htmlspecialchars($row['room_id']) ?>"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="dropdownMenuButton<?= htmlspecialchars($row['room_id']) ?>">
                                <li>
                                    <a href="viewRoomDetails.php?id=<?= htmlspecialchars($row['room_id']) ?>"
                                        id="viewDetailBtn">View Details</a>
                                </li>
                                <li>
                                    <button class="dropdown-item editBtn" type="button"
                                        data-room_id="<?= htmlspecialchars($row['room_id']) ?>"
                                        data-room_name="<?= htmlspecialchars($row['room_name']) ?>"
                                        data-gender="<?= htmlspecialchars($row['gender']) ?>"
                                        data-capacity="<?= htmlspecialchars($row['capacity']) ?>"
                                        data-monthly_rent="<?= htmlspecialchars($row['monthly_rent']) ?>"
                                        data-amenities="<?= htmlspecialchars($row['description']) ?>">
                                        Edit
                                    </button>

                                </li>
                                <li>
                                    <button class="dropdown-item text-danger deleteBtn" type="button"
                                        data-room_id="<?= htmlspecialchars($row['room_id']) ?>">
                                        Delete
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="info-item mb-2">
                        <span class="textColor">Gender:</span>
                        <?php
                    $gender = htmlspecialchars($row['gender']);
                    $backgroundColor = ($gender == 'Male') ? 'blue' : '#e61577';
                    ?>
                        <span
                            style="margin-left: 18px; background-color: <?= $backgroundColor ?>; padding: 2px 3px; border-radius: 3px; color: white">
                            <?= $gender ?>
                        </span>
                    </div>
                    <div class="info-item mb-2">
                        <span class="textColor">Capacity:</span> <span
                            style="margin-left: 5px"><?= htmlspecialchars($row['capacity']) ?></span>
                    </div>
                    <div class="info-item mb-2">
                        <span class="textColor">Rent:</span> <span style="margin-left: 18px">₱
                            <?= htmlspecialchars($row['monthly_rent']) ?></span>

                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <div class="col-12">
            <p class="text-center">No rooms found.</p>
        </div>
        <?php endif; ?>
    </div>

</div>

<!---------------------------------------------------------------------- Modal for Add Room-------------------------------------------------------------------------------------- -->
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #08614E">
                <h5 class="modal-title" id="addRoomModalLabel" style="color: #FFFFFF">Add New Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="background-color: #FFFFFF; border-radius: 50%; width: 10px; height: 10px"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem">
                <form id="addRoomForm" action="add_room.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="roomImage" class="form-label">Upload Image</label>
                        <input type="file" class="form-control dropify" id="roomImage" name="roomImage[]"
                            data-height="200" multiple required>
                    </div>

                    <div class="inputFlex">
                        <div class="mb-2">
                            <label for="roomName" class="form-label">Room No.</label>
                            <input type="number" class="form-control" id="roomName" name="roomName" required>
                        </div>
                        <div class="mb-2">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required style="width: 220.2px">
                                <option value="" disabled selected>--Select Gender--</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="inputFlex">
                        <div class="mb-2">
                            <label for="capacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" required>
                        </div>
                        <div class="mb-2">
                            <label for="monthly_rent" class="form-label">Monthly Rent</label>
                            <input type="number" class="form-control" id="monthly_rent" name="monthly_rent" required>
                        </div>
                    </div>

                    <!-- Amenities Section -->
                    <div class="mb-2">
                        <label for="amenities" class="form-label">Amenities</label><br>
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="WiFi"> WiFi</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Parking"> Parking</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Shared Bathroom"> Shared
                                    Bathroom</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="CR Inside"> CR
                                    Inside</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Bunk Beds"> Bunk
                                    Beds</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Kitchen Access"> Kitchen
                                    Access</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Laundry Area"> Laundry
                                    Area</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Fan"> Fan</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="24/7 Water Supply"> 24/7 Water
                                    Supply</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Electricity"> 24/7
                                    Electricity</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="CCTV"> CCTV</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Study Area"> Study
                                    Area</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Single Bed"> Single
                                    Bed</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Double Bed"> Double
                                    Bed</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Balcony"> Balcony</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Common Area"> Common
                                    Area</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="TV"> TV</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Air Conditioning"> Air
                                    Conditioning</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Refrigerator">
                                    Refrigerator</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities[]" value="Heater"> Heater</label><br>
                            </div>
                        </div>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn " style="background-color: #08614e; color: white">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!---------------------------------------------------------------------- Modal for Edit Room-------------------------------------------------------------------------------------- -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #08614E">
                <h5 class="modal-title" id="addRoomModalLabel" style="color: #FFFFFF">Edit Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="background-color: #FFFFFF; border-radius: 50%; width: 10px; height: 10px"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem">

                <form id="editRoomForm" action="edit_room.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editRoomId" name="roomId">
                    <div class="inputFlex">
                        <div class="mb-2">
                            <label for="editRoomName" class="form-label">Room No.</label>
                            <input type="number" class="form-control" id="editRoomName" name="roomName" required>
                        </div>
                        <div class="mb-2">
                            <label for="editGender" class="form-label">Gender</label>
                            <select class="form-control" id="editGender" name="gender" required style="width: 220.2px">
                                <option value="" disabled>--Select Gender--</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="inputFlex">
                        <div class="mb-2">
                            <label for="editCapacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="editCapacity" name="capacity" required>
                        </div>
                        <div class="mb-2">
                            <label for="editMonthlyRent" class="form-label">Monthly Rent</label>
                            <input type="number" class="form-control" id="editMonthlyRent" name="monthlyRent" required>
                        </div>
                    </div>

                    <!-- Description replaced with amenities checkboxes -->
                    <div class="mb-2">
                        <label for="amenities" class="form-label">Amenities</label><br>
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="WiFi"> WiFi</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Parking"> Parking</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Air Conditioning"> Air
                                    Conditioning</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Laundry Area"> Laundry
                                    Area</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="TV"> TV</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Kitchen Access"> Kitchen
                                    Access</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="CR Inside"> CR
                                    Inside</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Shared Bathroom"> Shared
                                    Bathroom</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Bunk Beds"> Bunk
                                    Beds</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Single Bed"> Single
                                    Bed</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Double Bed"> Double
                                    Bed</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Balcony"> Balcony</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Common Area"> Common
                                    Area</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Fan"> Fan</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="24/7 Water Supply"> 24/7 Water
                                    Supply</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Electricity"> 24/7
                                    Electricity</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="CCTV"> CCTV</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Study Area"> Study
                                    Area</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Refrigerator">
                                    Refrigerator</label><br>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <label><input type="checkbox" name="amenities2[]" value="Heater"> Heater</label><br>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update" class="btn "style="background-color: #08614e; color: white">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<?php 
// Close database connections
$stmt->close();
$con->close();
include('footer.php');
?>