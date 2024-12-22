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
    <h3 class="mb-4">Students</h3>
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
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Course/Year/Section</th>
                                    <th>Address</th>
                                    <th>Contact No.</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $getOccupants = "SELECT * FROM occupants";
                                $getOccupants_run = mysqli_query($con, $getOccupants);

                                if (mysqli_num_rows($getOccupants_run) > 0) {
                                    $count = 1;
                                    while ($row = mysqli_fetch_assoc($getOccupants_run)) { ?>
                                        <tr>
                                            <td class="text-center"><?php echo $count; ?></td>
                                            <td><?php echo $row['fullname']; ?></td>
                                            <td><?php echo $row['gender']; ?></td>
                                            <td><?php echo $row['course_year_section']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['contact_number']; ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo $row['occupant_id']; ?>">
                                                    View Details
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="detailsModal<?php echo $row['occupant_id']; ?>" tabindex="-1" aria-labelledby="detailsModalLabel<?php echo $row['occupant_id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title text-center" id="detailsModalLabel<?php echo $row['occupant_id']; ?>">Student Details</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row d-flex justify-content-center mb-4">
                                                                    <i class="fas fa-user-circle" style="font-size: 120px; color: #08614E;"></i>
                                                                    <h5 class="mt-3"><?php echo $row['fullname']; ?></h5>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <hr>
                                                                        <h5 class="text-center text-muted">Personal Information</h5>
                                                                        <hr>
                                                                        <ul>
                                                                            <li><p class="text-start mb-3">Gender: <?php echo $row['gender']; ?></p></li>
                                                                            <li><p class="text-start mb-3">Course/Year/Section: <?php echo $row['course_year_section']; ?></p></li>
                                                                            <li><p class="text-start mb-3">Contact #: <?php echo $row['contact_number']; ?></p></li>
                                                                            <li><p class="text-start">Address: <?php echo $row['address']; ?></p></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <hr>
                                                                        <h5 class="text-center text-muted">Boarding House Information</h5>
                                                                        <hr>
                                                                        <ul>
                                                                            <li><p class="text-start mb-3">Boarding House: <?php echo $row['bh_name']; ?></p></li>
                                                                            <li><p class="text-start mb-3">Room: <?php echo $row['room_number']; ?></p></li>
                                                                            <li><p class="text-start mb-3">Move-in Date: <?php echo $row['date_of_moving_in']; ?></p></li>
                                                                            <li><p class="text-start mb-3">Monthly Rent: ₱<?php echo $row['monthly_rent']; ?></p></li>
                                                                        </ul>
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
