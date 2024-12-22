<?php
// Include necessary files and initiate session
include('header.php');
include('../../config/config.php');
include('../../middleware/middleware.php');

$landlord_id = $_SESSION['auth_landlord']['id'];

$current_data = "SELECT * FROM landlords_acc WHERE landlord_id = '$landlord_id'";
$current_data_run = mysqli_query($con, $current_data);

if (mysqli_num_rows($current_data_run) > 0) {
    $result = mysqli_fetch_assoc($current_data_run);
    
    $current_fullname = $result['fullname'];
    $current_bhName = $result['bh_name'];
    $current_email = $result['email'];
} else {
    echo "No data found!";
}

// Fetch current profile image
$current_profile = "SELECT image FROM profile_image WHERE landlord_id = '$landlord_id'";
$current_profile_run = mysqli_query($con, $current_profile);
$current_image = mysqli_num_rows($current_profile_run) > 0 ? mysqli_fetch_assoc($current_profile_run)['image'] : null;
?>

<div class="container d-flex align-items-center justify-content-center" style="height: 100%;">
    <div class="row w-100 justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6">
            <div class="card border-1 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center">Edit Account</h3>
                    <form action="account_process.php" method="POST">

                        <div class="mb-3 text-center">
                            <?php if ($current_image): ?>
                                <img src="../landlord_uploads/<?php echo htmlspecialchars($current_image); ?>" alt="Profile Image" class="img-fluid rounded-circle mb-2" style="width: 120px; height: 120px;">
                            <?php else: ?>
                                <img src="../assets/images/usergreen_default.png" alt="Default Image" class="img-fluid rounded-circle mb-2" style="width: 120px; height: 120px;">
                            <?php endif; ?>
                        </div>
                        <div class="text-center mb-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadImageModal">
                                Change profile
                            </button>
                        </div>

                        <div class="mb-3 input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your Full Name" value="<?php echo htmlspecialchars($current_fullname); ?>" required>
                        </div>

                        <div class="mb-3 input-group">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                            <input type="text" class="form-control" id="bhName" name="bhName" placeholder="Enter your Boarding House Name" value="<?php echo htmlspecialchars($current_bhName); ?>" required>
                        </div>

                        <div class="mb-3 input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" value="<?php echo htmlspecialchars($current_email); ?>" required>
                        </div>

                        <p class="mb-2" style="color: #08614e" ><i class="fas fa-key me-2"></i>Change Password:</p>
                        <div class="mb-3 input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                        </div>

                        <div class="modal-footer d-flex justify-content-evenly mb-3 mt-4">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()" style="width: 150px">Cancel</button>
                            <button type="submit" name="submit_editProfile" class="btn" style="width: 150px; background-color: #08614e; color: white">Save Changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for uploading profile image -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageModalLabel">Upload New Profile Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="account_process.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="profileImage" class="form-label">Select Image</label>
                        <input type="file" class="form-control" id="profileImage" name="profileImage" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit_imageUpload" class="btn" style="background-color: #08614e; color: white">Upload Image</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
