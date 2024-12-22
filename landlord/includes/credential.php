<?php

include('header.php') ;
include('../../middleware/middleware.php');
include('../../config/config.php');

?>
<div class="container my-2">
    <div class="card mx-auto col-md-8">
        <div class="card-body">
            <h3 class="text-center h2-title" style="color:  #08614E; margin-bottom: 2rem">Boarding House Credential
                Form</h3>
            <form class="credentialForm" action="process_form.php" method="post" enctype="multipart/form-data">
                <!-- Owner's Details -->
                 <input type="hidden" name="latitude" value=""><br>
                 <input type="hidden" name="longitude" value="">
                <fieldset>
                    <legend>Owner’s Details</legend>
                    <div class="mb-3">
                        <label for="ownerName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="ownerName" name="ownerName"
                            placeholder="Enter full name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ownerPhone" class="form-label">Phone Number/Gcash Number</label>
                            <input type="text" class="form-control" id="ownerPhone" name="ownerPhone"
                                placeholder="Enter phone number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ownerEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="ownerEmail" name="ownerEmail"
                                placeholder="Enter email address" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="ownerAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="ownerAddress" name="ownerAddress"
                            placeholder="Enter address" required>
                    </div>
                </fieldset>

                <!-- Boarding House Details -->
                <fieldset>
                    <legend>Boarding House Details</legend>
                    <div class="mb-3">
                        <label for="houseName" class="form-label">Name of the Boarding House</label>
                        <input type="text" class="form-control" id="houseName" name="houseName"
                            placeholder="Enter boarding house name" required>
                    </div>

                    <!-- SELECT OPTION -->

                    <div class="mb-3">
                        <label for="houseLocation" class="form-label">Location/Near College</label>
                        <select name="houseLocation" id="houseLocation" class="form-control" required>
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
                        <input type="file" class="form-control" id="bhImage" name="bhImage" required>
                    </div>

                    <div class="mb-3">
                        <label for="termsAndConditions" class="form-label">Terms and Conditions</label>
                        <textarea class="form-control" id="termsAndConditions" name="termsAndConditions" rows="4" style="height: 500px;" placeholder="Enter terms and conditions...." required></textarea>
                    </div>
                </fieldset>

                <!-- Documentation -->
                <fieldset>
                    <legend class="text-center">Documentation</legend>
                    
                    <div class="mb-3">
                        <label for="majorPermit" class="form-label">Mayor's Permit</label>
                        <input type="file" class="form-control" id="majorPermit" name="majorPermit" required>
                    </div>
                    <div class="mb-3">
                        <label for="dit" class="form-label">DIT</label>
                        <input type="file" class="form-control" id="dit" name="dit"  required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="bir" class="form-label">BIR</label>
                        <input type="file" class="form-control" id="bir" name="bir" required>
                    </div>
                    <div class="mb-3">
                        <label for="fireSafety" class="form-label">BFP</label>
                        <input type="file" class="form-control" id="fireSafety" name="fireSafety" required>
                    </div>
                    <div class="mb-3">
                        <label for="ato" class="form-label">Authority to Operate</label>
                        <input type="file" class="form-control" id="ato" name="ato" required>
                    </div>
                    <div class="mb-3">
                        <label for="barangayPermit" class="form-label">Barangay Permit</label>
                        <input type="file" class="form-control" id="barangayPermit" name="barangayPermit" required>
                    </div>
                </fieldset>

                <div class="submit-credentials-container">
                    <button type="submit" name="submit-btn" class="unique-submit-credentials">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php include('footer.php') ?>