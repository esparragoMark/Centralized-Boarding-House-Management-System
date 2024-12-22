<?php
ob_start();
// Include necessary files and initiate session
include('header.php');
include('../../config/config.php');
include('../../functionCode/function.php');
include('../../middleware/middleware.php');

$room_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle image deletion request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image'])) {
    $imageToDelete = $_POST['delete_image'];
    
    // Fetch current images
    $query = "SELECT image FROM rooms WHERE room_id = $room_id";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $room = mysqli_fetch_assoc($result);
        $images = explode(',', $room['image']);
        
        // Check if the image exists in the array
        if (($key = array_search($imageToDelete, $images)) !== false) {
            // Remove the image from the array
            unset($images[$key]);
            $updatedImages = implode(',', $images);
            
            // Update the database
            $updateQuery = "UPDATE rooms SET image = '$updatedImages' WHERE room_id = $room_id";
            if (mysqli_query($con, $updateQuery)) {
                // Delete the image file from the server
                $filePath = '../room_bed_uploads/' . $imageToDelete;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                
                $_SESSION['message'] = "Deleted successfully.";
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = "Failed to update";
                $_SESSION['message_type'] = 'danger';
            }
        } else {
            $_SESSION['message'] = "Image not found.";
            $_SESSION['message_type'] = 'warning';
        }
    } else {
        $_SESSION['message'] = "Room not found.";
        $_SESSION['message_type'] = 'danger';
    }
    
    // Redirect to avoid form resubmission
    header("Location: viewRoomDetails.php?id=$room_id");
    exit();
}

// Handle image upload request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['roomImages'])) {
    $uploadDir = '../room_bed_uploads/';
    $imageNames = [];

    foreach ($_FILES['roomImages']['name'] as $key => $imageName) {
        if ($_FILES['roomImages']['error'][$key] == UPLOAD_ERR_OK) {
            // Call your multiUploadFile function to handle the upload
            $uploadedFileName = multiUploadFile('roomImages', $key, $uploadDir);
            if ($uploadedFileName) {
                $imageNames[] = $uploadedFileName; // Store the uploaded image name
            }
        }
    }

    // Update room images in the database
    if (!empty($imageNames)) {
        // Fetch current images
        $query = "SELECT image FROM rooms WHERE room_id = $room_id";
        $result = mysqli_query($con, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $room = mysqli_fetch_assoc($result);
            $currentImages = explode(',', $room['image']);
            $allImages = array_merge($currentImages, $imageNames);
            $updatedImages = implode(',', $allImages);
            
            // Update the database
            $updateQuery = "UPDATE rooms SET image = '$updatedImages' WHERE room_id = $room_id";
            if (mysqli_query($con, $updateQuery)) {
                $_SESSION['message'] = "Uploaded";
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = "Failed to update room images.";
                $_SESSION['message_type'] = 'danger';
            }
        }
    }

    // Redirect to avoid form resubmission
    header("Location: viewRoomDetails.php?id=$room_id");
    exit();
}

// Fetch room details
$query = "SELECT * FROM rooms WHERE room_id = $room_id";
$room_result = mysqli_query($con, $query);

// Check if query was successful
if (!$room_result) {
    die("Error fetching room details: " . mysqli_error($con));
}

$room = mysqli_fetch_assoc($room_result);

// Fetch bed details
$bed_query = "SELECT * FROM beds WHERE room_id = $room_id";
$beds_result = mysqli_query($con, $bed_query);

// Check if query was successful
if (!$beds_result) {
    die("Error fetching bed details: " . mysqli_error($con));
}

ob_end_flush();
?>


<div class="container my-4">
    <div class="custom-card border-0 shadow-sm rounded">
        <div class="custom-card-body p-4">
            <div class="row">
                <!-- Room Information Section -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="custom-room-info p-3">
                        <div class="d-flex align-items-center mb-3">
                            <!-- <button class="btn btn-light btn-sm me-2" onclick="goBack()">
                                <i class="fa fa-arrow-left"></i> Back
                            </button> -->
                            <h4 class="mb-0">Room Details</h4>
                        </div>

                        <!-- Room Images Carousel -->
                        <div id="carouselRoomImages" class="carousel slide rounded overflow-hidden"
                            data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php 
                                    // Split room images stored as comma-separated values
                                    $roomImages = explode(',', $room['image']);
                                    foreach ($roomImages as $index => $roomImage): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="../room_bed_uploads/<?= htmlspecialchars($roomImage) ?>"
                                        class="d-block w-100 room-image" alt="Room Image">
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselRoomImages"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselRoomImages"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                        <!-- Room Details -->
                        <div class="custom-room-details mt-4">
                            <hr>
                            <p class="d-flex justify-content-between">
                                <strong>Room Number:</strong> 
                                <span>#<?= htmlspecialchars($room['room_name']); ?></span>
                            </p>
                            <hr>
                            <p class="d-flex justify-content-between">
                                <strong>Gender:</strong> 
                                <span><?= htmlspecialchars($room['gender']); ?></span>
                            </p>
                            <hr>
                            <p class="d-flex justify-content-between">
                                <strong>Capacity:</strong> 
                                <span><?= htmlspecialchars($room['capacity']); ?></span>
                            </p>
                            <hr>
                            <p class="d-flex justify-content-between">
                                <strong>Monthly Rent:</strong>
                                <span>₱<?= htmlspecialchars($room['monthly_rent']); ?></span>
                            </p>
                            <hr>
                            <p class="d-flex justify-content-between">
                                <strong>Vacant Beds:</strong> 
                                <span><?= htmlspecialchars($room['vacant_bed']); ?></span>
                            </p>
                            <hr>

                            <!-- Display the amenities in a responsive grid format -->
                            <p class="mb-2"><strong>Amenities:</strong></p>
                            <div class="row">
                                <?php 
                                // Convert the amenities string back to an array
                                $amenities = explode(', ', $room['description']);
                                foreach ($amenities as $amenity): ?>
                                <div class="col-sm-12 col-lg-6 mb-2">
                                    <i class="fas fa-check text-success"></i> <?= htmlspecialchars($amenity); ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Bed Information Section -->
                <div class="col-md-6">
                    <div class="custom-bed-info custom-card">
                        <div class="custom-card-header mb-3">
                            <!-- <h5 class="custom-card-title">Bed Details</h5> -->
                        </div>
                        <div class="custom-card-body">
                            <div class="custom-bed-list">
                                <?php while ($bed = mysqli_fetch_assoc($beds_result)): ?>
                                <div class="custom-bed-item d-flex align-items-center mb-3 p-3 rounded border">
                                    <div class="custom-bed-image me-3">
                                        <img src="../room_bed_uploads/<?= htmlspecialchars($bed['image']); ?>"
                                            alt="Bed Photo" class="bed-image rounded">
                                    </div>
                                    <div class="custom-bed-details">
                                        <p><strong>Bed Number:</strong>
                                            <span>#<?= htmlspecialchars($bed['bed_number']); ?></span>
                                        </p>
                                        <p><strong>Status:</strong>
                                            <?php
                                                    $status = htmlspecialchars($bed['status']);
                                                    $backgroundColor = ($status == 'available') ? 'green' : (($status == 'occupied') ? 'red' : 'blue');
                                                ?>
                                            <span class="badge"
                                                style="background-color: <?= $backgroundColor ?>; color: white;">
                                                <?= ucfirst($status); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Images Management Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <hr>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-sm  mb-3" data-bs-toggle="modal"
                            data-bs-target="#uploadModal" style="background-color: #08614e; color: white">
                            Add Images
                        </button>
                    </div>

                    <div class="row manage-images">
                        <?php foreach ($roomImages as $roomImage): ?>
                        <div class="col-md-3 col-sm-4 col-lg-2 mb-4">
                            <div class="position-relative">
                                <img src="../room_bed_uploads/<?= htmlspecialchars($roomImage) ?>" alt="Room Image"
                                    class="img-fluid rounded">
                                <button class="btn btn-sm position-absolute top-1 end-2 delete-image-btn"
                                    data-image="<?= htmlspecialchars($roomImage); ?>" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    <i class="fa fa-times"></i>

                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this image?
                    <input type="hidden" name="delete_image" id="delete_image" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Adding image -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Room Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="roomImages" class="form-label">Select Images</label>
                        <input type="file" name="roomImages[]" id="roomImages" class="form-control dropify" multiple
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include('footer.php'); ?>