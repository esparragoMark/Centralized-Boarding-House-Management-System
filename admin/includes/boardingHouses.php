<?php
include("header.php");
include("../../config/config.php");
?>

<style>
/* Global Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f5f5;
}

h3 {
    font-weight: bold;
    color: #08614E;
}

/* Table Section */
.table-responsive {
    overflow-x: auto;
    white-space: nowrap;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th {
    color: white;
    background-color: #08614E;
    font-size: 14px;
    padding: 10px;
    text-align: center;
}

table td {
    padding: 10px;
    font-size: 13px;
    text-align: center;
    color: #333;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tbody tr:hover {
    background-color: #e0e0e0;
}

/* Buttons and Icons */
.btn-outline-primary {
    color: #08614E;
    border-color: #08614E;
    font-size: 12px;
}

.btn-outline-primary:hover {
    background-color: #08614E;
    color: white;
}

/* Responsive Layout */
@media (max-width: 767px) {
    .table th, .table td {
        font-size: 12px;
    }
}
</style>

<div class="container my-4">
    <h3 class="mb-4">Boarding Houses</h3>
    <div class="row">
        <div class="col-sm-12 col-md-10 col-lg-12">
            <!-- Card to wrap the table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Owner</th>
                                    <th>Contact No.</th>
                                    <th>Email Address</th>
                                    <th>Address</th>
                                    <th>Boarding House</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $getBH = "SELECT * FROM boarding_house_registration";
                                $getBH_run = mysqli_query($con, $getBH);

                                if (mysqli_num_rows($getBH_run) > 0) {
                                    $count = 1;
                                    while ($row = mysqli_fetch_assoc($getBH_run)) { ?>
                                        <tr>
                                            <td class="text-center"><?php echo $count; ?></td>
                                            <td><?php echo $row['owner_name']; ?></td>
                                            <td><?php echo $row['owner_phone']; ?></td>
                                            <td><?php echo $row['owner_email']; ?></td>
                                            <td><?php echo $row['owner_address']; ?></td>
                                            <td><?php echo $row['house_name']; ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo $row['landlord_id']; ?>">
                                                    View Details
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="detailsModal<?php echo $row['landlord_id']; ?>" tabindex="-1" aria-labelledby="detailsModalLabel<?php echo $row['landlord_id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detailsModalLabel<?php echo $row['landlord_id']; ?>">Boarding House Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Grid Layout for Images -->
                                                                <div class="row mb-4">
                                                                    <?php
                                                                    $imageFields = [
                                                                        'bhImage' => 'Boarding House Image',
                                                                        'major_permit' => 'Major Permit',
                                                                        'DTI' => 'DTI',
                                                                        'BIR' => 'BIR',
                                                                        'fire_safety_path' => 'Fire Safety Clearance',
                                                                        'ATO' => 'Authority to Operate',
                                                                        'barangay_permit_path' => 'Barangay Permit'
                                                                    ];
                                                                    
                                                                    foreach ($imageFields as $field => $label) {
                                                                        $imagePath = "../../landlord/landlord_uploads/" . $row[$field];
                                                                        if (file_exists($imagePath) && !empty($row[$field])) {
                                                                            echo '<div class="col-md-4 mb-3">
                                                                                    <img src="' . $imagePath . '" class="img-fluid rounded shadow-sm" alt="' . $label . '">
                                                                                    <p class="text-center mt-2">' . $label . '</p>
                                                                                </div>';
                                                                        } else {
                                                                            echo '<div class="col-md-4 mb-3">
                                                                                    <img src="../../landlord/landlord_uploads/placeholder.jpg" class="img-fluid rounded shadow-sm" alt="No Image Available">
                                                                                    <p class="text-center mt-2">' . $label . '</p>
                                                                                </div>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>

                                                                <!-- Owner and Boarding House Information -->
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <h6><strong>Owner Information</strong></h6>
                                                                        <p><?php echo $row['owner_name']; ?></p>
                                                                        <p><?php echo $row['owner_phone']; ?></p>
                                                                        <p><?php echo $row['owner_email']; ?></p>
                                                                        <p><?php echo $row['owner_address']; ?></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <h6><strong> Boarding House Information</strong></h6>
                                                                        <p><?php echo $row['house_name']; ?></p>
                                                                        <p><?php echo $row['house_location']; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                        $count++;
                                    }
                                } else {
                                    echo '<h5>No Record!</h5>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- End of card -->
        </div>
    </div>
</div>

<?php
include("footer.php");
?>
