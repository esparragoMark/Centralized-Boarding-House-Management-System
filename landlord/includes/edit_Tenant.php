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
    <div class="row w-100 justify-content-center align-item-center">
        <div class="col-12 col-md-10">

            <?php

                if(isset($_GET['id']))
                {

                    $id = $_GET['id'];

                    $get_all_data = "SELECT * FROM occupants WHERE occupant_id = '$id' AND bh_id = '$bh_id'";
                    $get_all_data_run = mysqli_query($con, $get_all_data);

                    if(mysqli_num_rows($get_all_data_run) > 0)
                    {
                        $data_result = mysqli_fetch_array($get_all_data_run);

                        ?>
            <div class="card border-1">
                <div class="card-body" style="padding-left: 50px; padding-right: 50px;">
                    <h3 class="mb-5 ">Edit Tenant</h3>
                    <form action="editTenant_process.php" method="POST">
                        <input type="hidden" name="currentId" value="<?=$id?>">
                        <div class="row">
                            <!-- for occupant information  -->
                            <div class="col-12 col-lg-5">

                                <div class="occupantInfo mb-3">
                                    <label for="tenantName" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="tenantName" name="tenantName"
                                        value="<?=$data_result['fullname']?>" placeholder="e.g. (Mark L. Esparrago)"
                                        required>
                                </div>
                                

                                <div class="mb-3">
                                    <label for="tenantGender" class="form-label">Gender:</label>
                                    <select class="form-control" id="tenantGender" name="tenantGender" required>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                

                                <div class="occupantInfo mb-3">
                                    <label for="course/year/section" class="form-label">Course/Year/Section:</label>
                                    <input type="text" class="form-control" id="course/year/section"
                                        name="course/year/section" value="<?=$data_result['course_year_section']?>"
                                        placeholder="e.g. (Mark L. Esparrago)" required>
                                </div>
                                

                                <div class="mb-3">
                                    <label for="tenantAddress" class="form-label">Address:</label>
                                    <input type="text" class="form-control" id="tenantAddress" name="tenantAddress"
                                        value="<?=$data_result['address']?>"
                                        placeholder="e.g. (Tinapian, Baleno, Masbate)" required>
                                </div>
                                

                                <div class="mb-3">
                                    <label for="tenantContact" class="form-label">Contact No.:</label>
                                    <input type="text" class="form-control" id="tenantContact" name="tenantContact"
                                        value="<?=$data_result['contact_number']?>" placeholder="e.g. (09482244276)"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="guardian" class="form-label">Guardian:</label>
                                    <input type="text" class="form-control" id="guardian" name="guardian"
                                        value="<?=$data_result['guardian_name']?>" placeholder="e.g. (Maria A.Relonda)"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="guardianContact" class="form-label">Guardian Contact:</label>
                                    <input type="text" class="form-control" id="guardianContact" name="guardianContact"
                                        value="<?=$data_result['guardian_contact']?>" placeholder="e.g. (Maria A.Relonda)"
                                        required>
                                </div>

                            </div>


                            <!-- for current value -->

                            <div class="col-12 col-lg-7">

                                <div class="row">

                                    <div class="col-12 col-lg-6">
                                        <hr>
                                        <strong>Current Data</strong>
                                        <hr>
                                        <div class="mb-3">
                                            <label for="currentroom" class="form-label">Room No.:</label>
                                            <input type="text" class="form-control" id="currentroom" name="currentroom"
                                                value="<?=$data_result['room_number']?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="currentbed" class="form-label">Bed No.:</label>
                                            <input type="text" class="form-control" id="currentbed" name="currentbed"
                                                value="<?=$data_result['bed_number']?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="currentrent" class="form-label">Monthly Rent:</label>
                                            <input type="text" class="form-control" id="currentrent" name="currentrent"
                                                value="<?=$data_result['monthly_rent']?>" readonly>
                                        </div>

                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <hr>
                                        <strong>Want to Update Room or Bed?</strong>
                                        <hr>
                                        <div class="occupantInput mb-3">
                                            <label for="roomNumber" class="form-label">Select Room No.:</label>
                                            <select class="form-control" id="roomNumber" name="roomNumber"
                                                onchange="getRoomValue(this.value);">
                                                <option>Select a room</option>
                                                <?php
                    
                                                                $sql = "SELECT room_id, room_name, gender FROM rooms WHERE bh_fk = '$bh_id' 
                                                                                    AND vacant_bed > 0 ";
                    
                                                                $result = $con->query($sql);
                                                                            
                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {
                                                                             echo "<option value='" . $row['room_id'] . "'>" . $row['room_name'] ."-".$row['gender']. "</option>";
                                                                                }
                                                                    } else {
                                                                            echo "<option value=''>No rooms available</option>";
                                                                            }
                                                                    
                                                        ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bedNumber" class="form-label"> Select Bed No.:</label>
                                            <select class="form-control" id="bedNumber" name="bedNumber">
                                                <option>Select a bed</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="monthlyRent" class="form-label">Monthly Rent:</label>
                                            <input type="number" class="form-control" id="monthlyRent"
                                                name="monthlyRent" readonly>
                                        </div>


                                    </div>

                                </div>

                                <hr>
                                <div class="mb-3">
                                    <label for="payment" class="form-label">Payment Amount</label>
                                    <input type="number" class="form-control" id="payment" name="payment"  value="<?=$data_result['payment_amount']?>">
                                </div>

                                <div class="mb-3">
                                    <label for="enddate" class="form-label">Due Date:</label>
                                    <input type="date" class="form-control" id="enddate" name="enddate"  value="<?=$data_result['end_date']?>">
                                </div>
                                

                            </div>

                        </div>


                        <div class="modal-footer d-flex justify-content-evenly mb-3"
                            style="gap: 5px; margin-top: 1.5rem">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()"
                                style="width: 200px">Cancel</button>

                            <button type="submit" name="submit_editTenant" class="btn"
                                style="width: 200px; background-color: #08614e; color: white">Save</button>
                        </div>

                    </form>

                </div>
            </div>

            <?php
                    }
                    else{
                        echo "Occupant not found in the given ID!";
                    }

            }
            else{
                echo "ID not found in the URL!";
            }
            
            ?>




        </div>
    </div>
</div>

<?php include('footer.php') ?>