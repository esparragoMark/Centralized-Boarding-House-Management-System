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
} else {
    $_SESSION['message'] = "No boarding house found. Please submit your credentials.";
    $_SESSION['message_type'] = "warning";
    header("Location: credential.php");
    exit();
}

$bh_id = isset($_SESSION['BH-ID']) ? $_SESSION['BH-ID'] : 0;

// Handle search
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Prepare SQL query with single search condition
$sql = "SELECT b.bed_id, b.bed_number, b.status, b.image AS bed_image, r.room_name
        FROM beds b
        JOIN rooms r ON b.room_id = r.room_id
        WHERE r.bh_fk = ?";

$params = [$bh_id];
$types = "i";

// Append search conditions
if (!empty($search)) {
    $sql .= " AND (b.bed_number LIKE ? OR r.room_name LIKE ? OR b.status LIKE ?)";
    $searchParam = '%' . $con->real_escape_string($search) . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= "sss";
}

$stmt = $con->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
ob_end_flush();
?>

<div class="container my-4">
    <h3 class="mb-4">Manage Bed</h3>
    <div class="d-flex justify-content-between align-items-center mb-3"
        style="border: none; padding: 1rem; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <!-- Search Form -->
        <form class="input-group w-50 mng_bed_custom" method="post">
            <div class="input-group-append"
                style="display: flex; align-items: center; justify-content: center; background-color: #08614E; width: 400px; border-radius: 4px">
                <button class="btn  btn-save" type="submit" style="background-color: #08614e; color: white">
                    <i class="fas fa-search" style="color: #ffffff"></i>
                </button>
                <input type="text" name="search" class="form-control" placeholder="Search..."
                    style="border: 1px solid rgba(8, 97, 78, 0.25); color: #08614E"
                    value="<?php echo htmlspecialchars($search); ?>">
            </div>
        </form>
        <button class="btn addbedbtn" data-bs-toggle="modal" data-bs-target="#addBedModal" style="background-color: #08614e; color: white">
            <i class="fas fa-plus"></i> Add Bed
        </button>
    </div>

    <div class="row" id="bed_refresh"
        style="padding-top: 10px; border-radius: 4px;">
        <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4">
            <div class="card card-custom h-60 shadow-sm">
                <div class="card-img-top-container">
                    <img src="../room_bed_uploads/<?php echo htmlspecialchars($row['bed_image']); ?>"
                        class="card-img-top img-fluid" alt="Bed Image">
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="card-title text-truncate" style="color: #08614E; font-weight: 600">Bed No: <span
                                style="margin-left: 10px"><?php echo htmlspecialchars($row['bed_number']); ?></span>
                        </h6>
                        <div class="dropdown">
                            <button class="btn btn-link text-dark p-0" type="button"
                                id="dropdownMenuButton<?= htmlspecialchars($row['bed_id']) ?>" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="dropdownMenuButton<?= htmlspecialchars($row['bed_id']) ?>">
                                <li>
                                    <button class="dropdown-item bed_editBtn" type="button"
                                        data-bed_id="<?php echo htmlspecialchars($row['bed_id']); ?>"
                                        data-bed_number="<?php echo htmlspecialchars($row['bed_number']); ?>"
                                        data-status="<?php echo htmlspecialchars($row['status']); ?>"
                                        data-room_name="<?php echo htmlspecialchars($row['room_name']); ?>"
                                        data-bed_image="<?php echo htmlspecialchars($row['bed_image']); ?>">Edit</button>
                                </li>
                                <li>
                                    <button class="dropdown-item text-danger deleteBedBtn" type="button"
                                        data-bed_id="<?php echo htmlspecialchars($row['bed_id']); ?>">
                                        Delete
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="info-item mb-2">
                        <span class="textColor">Room No.</span> <span
                            style="margin-left: 10px"><?php echo htmlspecialchars($row['room_name']); ?></span>
                    </div>
                    <div class="info-item mb-2">
                        <span class="textColor">Status:</span>
                        <?php
                            if ($row['status'] == 'available') {
                                echo '<span style="margin-left: 10px; background-color: green; padding: 1px 3px; color: white; border-radius: 3px">' . htmlspecialchars($row['status']) . '</span>';
                            } elseif($row['status'] == 'occupied'){
                                echo '<span style="margin-left: 10px; background-color: red; padding: 1px 3px;  color: white; border-radius: 3px">' . htmlspecialchars($row['status']) . '</span>';
                            }
                            else{
                                echo '<span style="margin-left: 10px; background-color: blue; padding: 1px 3px;  color: white; border-radius: 3px">' . htmlspecialchars($row['status']) . '</span>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <p class="text-center">No beds found.</p>
        <?php endif; ?>
    </div>
</div>

 

<!-- ----------------------------------------------------------Modal for Add Bed --------------------------------------------------------------------------------->
<div class="modal fade" id="addBedModal" tabindex="-1" aria-labelledby="addBedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #08614E">
                <h5 class="modal-title" id="addBedModalLabel" style="color: #FFFFFF">Add New Bed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="background-color: #FFFFFF; border-radius: 50%; width: 10px; height: 10px"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem">

                <form id="addBedForm" action="add_bed.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="bedImage" class="form-label">Upload Image</label>
                        <input type="file" class="form-control dropify" id="bedImage" name="bedImage" data-height="200"
                            required>
                    </div>

                    <div class="inputbed_layout" style="display: flex; justify-content: space-around">

                        <div class="mb-2">
                            <label for="roomId" class="form-label">Room No.</label>
                            <select class="form-control" id="roomId" name="roomId" required>
                                <option value="" disabled selected>--Select Room--</option>
                                <?php
                                    // PHP code to fetch available room numbers from the database
                                    $sql = "SELECT room_id, room_name, gender, capacity, vacant_bed , occupied_bed
                                            FROM rooms 
                                            WHERE bh_fk = '$bh_id' 
                                            AND capacity > vacant_bed + occupied_bed ";

                                    $result = $con->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['room_id'] . "'>" . $row['room_name'] . "-" . $row['gender']  . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled >No rooms available</option>";
                                    }
                            
                                ?>
                            </select>
                        </div>

                        <div class="inputbed_layout2">

                            <div class="mb-2">
                                <label for="bedNumber" class="form-label">Bed Number</label>
                                <input type="number" class="form-control" id="bedNumber" name="bedNumber" required>
                            </div>

                            <div class="mb-2">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value=""disabled selected>--Select Status--</option>
                                    <option value="available">available</option>
                                    <option value="occupied">occupied</option>
                                </select>
                            </div>

                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit_addBed" class="btn " style="background-color: #08614e; color: white">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- ----------------------------------------------------------Modal for EditBed --------------------------------------------------------------------------------->
<div class="modal fade" id="editBedModal" tabindex="-1" aria-labelledby="addBedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #08614E">
                <h5 class="modal-title" id="addBedModalLabel" style="color: #FFFFFF">Edit Bed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="background-color: #FFFFFF; border-radius: 50%; width: 10px; height: 10px"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem">

                <form id="addBedForm" action="edit_bed.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editBedId" name="bedId">
                    <div class="mb-2">
                        <!-- Current image  -->
                        <label for="editbedImage" class="form-label">Current Image</label>
                        <div id="currentImageContainer" class="mb-3">
                            <img id="currentBedImage" src="" alt="Current Room Image"
                                style="max-width: 15%; height: auto;">
                        </div>

                        <label for="bedImage" class="form-label">Upload Image</label>
                        <input type="file" class="form-control dropify" id="bedImage" name="bedImage" data-height="200">
                    </div>

                    <div class="inputbed_layout" style="display: flex; justify-content: space-around">

                        <div class="mb-2">
                            <label for="roomId" class="form-label">Room No.</label>
                            <select class="form-control" id="editRoomId" name="roomId">
                                <option value="" disabled selected>--Select Room--</option>
                                <?php
                                    // PHP code to fetch available room numbers from the database
                                    $sql = "SELECT room_id, room_name,gender, capacity, vacant_bed , occupied_bed
                                            FROM rooms 
                                            WHERE bh_fk = '$bh_id' 
                                            AND capacity > vacant_bed + occupied_bed ";

                                    $result = $con->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['room_id'] . "'>" . $row['room_name'] ."-" . $row['gender'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled >No rooms available</option>";
                                    }
                            
                                ?>
                            </select>

                            <p style="font-size: 11px; margin-top: 3px">Current No: <span id="currentRoomNumber"></span>
                            </p>
                            <input type="hidden" id="current_room_name" name="currentRoomName">
                        </div>

                        <div class="inputbed_layout2">

                            <div class="mb-2">
                                <label for="bedNumber" class="form-label">Bed Number</label>
                                <input type="number" class="form-control" id="editBedNumber" name="bedNumber" required>
                            </div>

                            <div class="mb-2">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="editStatus" name="status" required>
                                    <option value="" disabled selected>--Select Status--</option>
                                    <option value="available">available</option>
                                    <option value="occupied">occupied</option>
                                    <option value="booked">booked</option>
                                </select>
                            </div>

                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit_editBed" class="btn" style="background-color: #08614e; color: white">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<?php 
// Close database connections
$con->close();
include('footer.php');
?>