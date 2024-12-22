<?php

include('header.php') ;
include('../../middleware/middleware.php');
include('../../config/config.php');

$landlord_id = $_SESSION['auth_landlord']['id'];

$get_credentials = "SELECT * FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$get_credentials_run = mysqli_query($con, $get_credentials);

if(mysqli_num_rows($get_credentials_run) > 0)
{
    $data = mysqli_fetch_assoc($get_credentials_run);

    $owner_name = $data['owner_name'];
    $owner_contact = $data['owner_phone'];
    $owner_email = $data['owner_email'];
    $owner_address = $data['owner_address'];
    $bh_name = $data['house_name'];
    $bh_location = $data['house_location'];
    $bh_image = $data['bhImage'];
    $terms_and_conditions = $data['terms_and_conditions'];
    $major_permit = $data['major_permit'];
    $DTI = $data['DTI'];
    $BIR = $data['BIR'];
    $BFP = $data['fire_safety_path'];
    $ATO = $data['ATO'];
    $barangay_permit = $data['barangay_permit_path'];
}

?>

<div class="container my-4">
    <div class="row">
        <div class="col-12 col-lg-12">
            <h3 class="mb-4">Credential's Information</h3>
            <div class="card border-0">

                <div class="card-body">
                    <div class="row">

                        <div class="col-12 mb-5 text-center">
                            <img src="../landlord_uploads/<?=$bh_image?>" alt="boardinghouse image"
                                style="width: 30%; height: auto; border-radius:5px">
                            <hr>
                        </div>
                        <div class="col-sm-12 col-lg-4 mb-3 ">
                            <h4>Personal Information</h4>
                            <div class="credential_text">
                                <ul>
                                    <li><?=$owner_name?></li>
                                    <li><?=$owner_contact?></li>
                                    <li><?=$owner_email?></li>
                                    <li><?=$owner_address?></li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-sm-12 col-lg-4 mb-3 ">
                            <h4>Boardinghouse Information</h4>
                            <div class="credential_text">
                                <ul>
                                    <li><?=$bh_name?></li>
                                    <li>Near at <?=$bh_location?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4 mb-3 ">
                            <h4>Terms & Conditions</h4>
                            <div class="credential_text">
                                <ul>
                                    <li>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#termsModal" style="width: 120px">View</button>
                                    </li>
                                </ul>
                                
                                
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <hr>
                            <h4 class="text-center mb-3">Documentation</h4>
                            <div class="row">
                                <div class="col-sm-12 col-lg-2 mb-2 text-center">
                                    <img src="../landlord_uploads/<?= !empty($major_permit) ? $major_permit : 'placeholder.jpg' ?>" 
                                        alt="Mayor's permit image" 
                                        style="width: 90%; height: auto; border-radius:5px">
                                    <h6>Mayor's Permit</h6>
                                </div>

                                <div class="col-sm-12 col-lg-2 mb-2 text-center">
                                    <img src="../landlord_uploads/<?= !empty($DTI) ? $DTI : 'placeholder.jpg' ?>" 
                                        alt="DTI permit image" 
                                        style="width: 90%; height: auto; border-radius:5px">
                                    <h6>DTI</h6>
                                </div>

                                <div class="col-sm-12 col-lg-2 mb-2 text-center">
                                    <img src="../landlord_uploads/<?= !empty($BIR) ? $BIR : 'placeholder.jpg' ?>" 
                                        alt="BIR permit image" 
                                        style="width: 90%; height: auto; border-radius:5px">
                                    <h6>BIR</h6>
                                </div>

                                <div class="col-sm-12 col-lg-2 mb-2 text-center">
                                    <img src="../landlord_uploads/<?= !empty($BFP) ? $BFP : 'placeholder.jpg' ?>" 
                                        alt="BFP certificate image" 
                                        style="width: 90%; height: auto; border-radius:5px">
                                    <h6>BFP Certificate</h6>
                                </div>

                                <div class="col-sm-12 col-lg-2 mb-2 text-center">
                                    <img src="../landlord_uploads/<?= !empty($ATO) ? $ATO : 'placeholder.jpg' ?>" 
                                        alt="Authority to Operate image" 
                                        style="width: 90%; height: auto; border-radius:5px">
                                    <h6>Authority to Operate</h6>
                                </div>

                                <div class="col-sm-12 col-lg-2 mb-2 text-center">
                                    <img src="../landlord_uploads/<?= !empty($barangay_permit) ? $barangay_permit : 'placeholder.jpg' ?>" 
                                        alt="Barangay permit image" 
                                        style="width: 90%; height: auto; border-radius:5px">
                                    <h6>Barangay Permit</h6>
                                </div>
                            </div>

                            <hr>

                        </div>
                    </div>


                </div>

                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editModal"
                    style="border-top-left-radius: 0; border-top-right-radius: 0; background-color: #08614e; color: white; height: 50px">
                    <i class="fas fa-pen me-2"></i> Edit Credential
                </button>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Credentials</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="edit_credential.php" method="POST" enctype="multipart/form-data">

                                    <fieldset>
                                        <legend class="text-center">Personal Information</legend>

                                        <div class="mb-3">
                                            <label for="ownerName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="ownerName"
                                                value="<?=$owner_name?>" name="ownerName">
                                        </div>

                                        <div class="mb-3">
                                            <label for="ownerContact" class="form-label">Contact</label>
                                            <input type="text" class="form-control" id="ownerContact"
                                                value="<?=$owner_contact?>" name="ownerContact">
                                        </div>

                                        <div class="mb-3">
                                            <label for="ownerEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="ownerEmail"
                                                value="<?=$owner_email?>" name="ownerEmail">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ownerAddress" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="ownerAddress"
                                                value="<?=$owner_address?>" name="ownerAddress">
                                        </div>

                                    </fieldset>

                                    <fieldset>
                                        <legend class="text-center">Boardinghouse Details</legend>

                                        <div class="mb-3">
                                            <label for="houseName" class="form-label">Name of the Boarding House</label>
                                            <input type="text" class="form-control" id="houseName" name="houseName"
                                                value="<?=$bh_name?>">
                                        </div>

                                        <!-- SELECT OPTION -->
                                        <div class="mb-3">
                                            <label for="houseLocation" class="form-label">Location/Near College</label>
                                            <select name="houseLocation" id="houseLocation" class="form-control">
                                                <option value="" disabled selected>--Select Near College--</option>

                                                <?php
                                                    $query = "SELECT * FROM colleges";
                                                    $query_run = mysqli_query($con, $query);

                                                    if(mysqli_num_rows($query_run) > 0){
                                                        while($result = mysqli_fetch_assoc($query_run)){
                                                            echo "<option value=\"{$result['college']}\">{$result['college']}</option>";
                                                        }
                                                    } else {
                                                        echo "<option disabled >No data found!</option>";
                                                    }
                                                ?>

                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bhImage" class="form-label">Boarding House Image</label>
                                            <input type="file" class="form-control" id="bhImage" name="bhImage">
                                        </div>

                                        <div class="mb-3">
                                            <label for="termsAndConditions" class="form-label">Terms and
                                                Conditions</label>
                                            <textarea class="form-control" id="termsAndConditions"
                                                name="termsAndConditions" rows="4" style="height: 500px;"
                                                ><?=$terms_and_conditions?></textarea>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <legend class="text-center">Documentation</legend>

                                        <div class="mb-3">
                                            <label for="majorPermit" class="form-label">Mayor's Permit</label>
                                            <input type="file" class="form-control" id="majorPermit" name="majorPermit">
                                        </div>
                                        <div class="mb-3">
                                            <label for="dit" class="form-label">DIT</label>
                                            <input type="file" class="form-control" id="dit" name="dit">
                                        </div>

                                        <div class="mb-3">
                                            <label for="bir" class="form-label">BIR</label>
                                            <input type="file" class="form-control" id="bir" name="bir"> 
                                        </div>
                                        <div class="mb-3">
                                            <label for="fireSafety" class="form-label">BFP</label>
                                            <input type="file" class="form-control" id="fireSafety" name="fireSafety">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ato" class="form-label">Authority to Operate</label>
                                            <input type="file" class="form-control" id="ato" name="ato">
                                        </div>
                                        <div class="mb-3">
                                            <label for="barangayPermit" class="form-label">Barangay Permit</label>
                                            <input type="file" class="form-control" id="barangayPermit"
                                                name="barangayPermit">
                                        </div>
                                    </fieldset>
                                    <button type="submit" class="btn float-end" name="update" style="background-color: #08614e; color: white">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for clicking the the view terms and conditons -->
                <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Textarea to display the terms and conditions -->
                            <textarea class="form-control" rows="4" disabled style="height: 500px"><?=$terms_and_conditions?></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>