<?php

include('header.php');
include('../../config/config.php');
include('../../middleware/middleware.php');

// Get landlord ID from session
$landlord_id = $_SESSION['auth_landlord']['id'];

// Fetch boarding house ID
$query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['BH-ID'] = $row['bh_id'];
}

$bh_id = $_SESSION['BH-ID'];
?>

<div class="container d-flex align-items-center min-vh-100 my-2">
    <div class="row w-100 justify-content-center align-item-center m-0">
        <div class="col-12 col-md-10">
            <div class="card border-1">
                <div class="card-body" style="padding-left: 50px; padding-right: 50px;">
                    <h3 class="mb-5 ">Add Tenant Form</h3>
                    <form action="addTenant_process.php" method="POST">

                        <div class="row">
                            <!-- Personal Information -->
                            <div class="col-12 col-lg-6">

                                <div class="occupantInfo mb-3">
                                    <label for="tenantName" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="tenantName" name="tenantName"
                                        placeholder="e.g. (Mark L. Esparrago)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tenantGender" class="form-label">Gender:</label>
                                    <select class="form-control" id="tenantGender" name="tenantGender" required>
                                        <option value="" disabled selected>--Select Gender--</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tenantCourse" class="form-label">Course/Year/Section:</label>
                                    <input type="text" class="form-control" id="tenantCourse" name="tenantCourse"
                                        placeholder="e.g. (BSCS 4A)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tenantAddress" class="form-label">Address:</label>
                                    <input type="text" class="form-control" id="tenantAddress" name="tenantAddress"
                                        placeholder="e.g. (Tinapian, Baleno, Masbate)" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tenantContact" class="form-label">Contact No.:</label>
                                    <input type="text" class="form-control" id="tenantContact" name="tenantContact"
                                        placeholder="e.g. (09482244276)" required>
                                </div>

                                <div class="mb-3">
                                    <label for="guardian" class="form-label">Guardian:</label>
                                    <input type="text" class="form-control" id="guardian" name="guardian"
                                        placeholder="e.g. (Maria A. Realonda)" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="guardianContact" class="form-label">Contact No.:</label>
                                    <input type="text" class="form-control" id="guardianContact" name="guardianContact"
                                        placeholder="e.g. (09482244276)" required>
                                </div>

                            </div>


                            <!-- Room Information -->
                            <div class="col-12 col-lg-6">
                                <div class="occupantInput mb-3">
                                    <label for="roomNumber" class="form-label">Room No.:</label>
                                    <select class="form-control" id="roomNumber" name="roomNumber" required
                                        onchange="getRoomValue(this.value);">
                                        <option disabled selected>--Select room--</option>
                                        <?php

                                    $sql = "SELECT room_id, room_name, gender FROM rooms WHERE bh_fk = '$bh_id' 
                                            AND vacant_bed > 0 ";

                                    $result = $con->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['room_id'] . "'>" . $row['room_name'] ."-". $row['gender'].  "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>No rooms available</option>";
                                    }
                            
                                ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="bedNumber" class="form-label">Bed No.:</label>
                                    <select class="form-control" id="bedNumber" name="bedNumber" required>
                                        <option>Select a bed</option>
                                    </select>
                                </div>



                                <div class="mb-3">
                                    <label for="monthlyRent" class="form-label">Monthly Rent:</label>
                                    <input type="number" class="form-control" id="monthlyRent" name="monthlyRent"
                                        readonly>
                                </div>


                                <div class="mb-3">
                                    <label for="payment" class="form-label">Enter Payment Amount:</label>
                                    <input type="number" class="form-control" id="payment" name="payment" required>
                                </div>



                                <div class="mb-3">
                                    <label for="dataEnd" class="form-label">Due Date:</label>
                                    <input type="date" class="form-control" id="dataEnd" name="dateEnd" required>
                                </div>
                            </div>

                        </div>


                        <div class="modal-footer d-flex justify-content-evenly mb-3"
                            style="gap: 5px; margin-top: 1.5rem">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()"
                                style="width: 200px">Cancel</button>

                            <button type="submit" name="submit_addTenant" class="btn"
                                style="width: 200px; background-color: #08614e; color: white">Save</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>