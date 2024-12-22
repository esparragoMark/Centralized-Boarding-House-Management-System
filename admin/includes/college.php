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

h3, h5 {
    font-weight: bold;
    color: #08614E;
}

.card {
    border-radius: 10px;
    border: none;
}

/* Form Section */
form .form-control {
    border-radius: 5px;
    border: 1px solid #08614E;
    font-size: 14px;
    color: #333;
}

form .form-group label {
    font-weight: 500;
    color: #08614E;
}

form .btn-success {
    background-color: #08614E;
    border: none;
    font-size: 14px;
    font-weight: bold;
}

form .btn-success:hover {
    background-color: #064E3D;
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
.btn-outline-danger {
    color: #08614E;
    border-color: #08614E;
    font-size: 12px;
}

.btn-outline-danger:hover {
    background-color: #08614E;
    color: white;
}

.btn-outline-danger .fas {
    margin-right: 5px;
}

.modal-content {
    border-radius: 10px;
}

/* Modal Design */
.modal-header {
    background-color: #08614E;
    color: white;
}

.modal-footer .btn-secondary {
    background-color: #6c757d;
    border: none;
    font-size: 14px;
}

.modal-footer .btn-danger {
    background-color: #dc3545;
    border: none;
    font-size: 14px;
}

/* Responsive Layout */
@media (max-width: 767px) {
    .table-responsive {
        width: 100%;
        overflow-x: scroll;
    }

    .table th, .table td {
        font-size: 12px;
    }

    .card {
        margin-bottom: 20px;
    }
}
</style>

<div class="container my-4">
    <h3 class="mb-4">Colleges</h3>
    <div class="row">
        <!-- Add College Button -->
        <div class="col-sm-12 text-end">
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCollegeModal"  style="background-color: #08614e; color: white">
            <i class="fas fa-plus me-2"></i>Add College
            </button>
        </div>

        <!-- Add College Modal -->
        <div class="modal fade" id="addCollegeModal" tabindex="-1" aria-labelledby="addCollegeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCollegeModalLabel" style="color: white">Add College</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="addCollege.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="college" class="college-text">Enter College</label>
                                <input type="text" class="form-control" name="college" id="college"
                                    placeholder="e.g., College of Engineering" required>
                            </div>
                            <button type="submit" name="btn-AddCollege" class="btn btn-success float-end">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- List of Colleges -->
        <div class="col-sm-12 col-md-8 col-lg-12">
            <div class="card shadow-sm" style="padding: .5rem; height: 530px">
                <div class="card-body">
                    <h3 class="card-title college-text mb-3 text-center">List of Colleges</h3>
                    <div class="table-responsive design-table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Name of College</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $getCollege = "SELECT * FROM colleges";
                                    $getCollege_run = mysqli_query($con, $getCollege);

                                    if(mysqli_num_rows($getCollege_run) > 0) {
                                        $count = 1;
                                        while($row = mysqli_fetch_assoc($getCollege_run)) { 
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $count; ?></td>
                                                <td><?php echo $row['college']; ?></td> 
                                                <td class="text-center">
                                                    <!-- Edit Button -->
                                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">
                                                        <i class="fas fa-edit" style="margin-right: 5px"></i>Edit
                                                    </button>

                                                    <!-- Remove Button -->
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                                                        <i class="fas fa-trash" style="margin-right: 5px"></i>Remove
                                                    </button>

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>" style="color: white">Edit College</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="updateCollege.php" method="POST">
                                                                        <input type="hidden" name="college_id" value="<?php echo $row['id']; ?>">
                                                                        <div class="form-group">
                                                                            <label for="editCollege<?php echo $row['id']; ?>">College Name</label>
                                                                            <input type="text" class="form-control" id="editCollege<?php echo $row['id']; ?>" name="college" value="<?php echo $row['college']; ?>" required>
                                                                        </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-success">Update</button>
                                                                </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>" style="color: white">Confirm Delete</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete <strong><?php echo $row['college']; ?></strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="deleteCollege.php" method="POST" style="display:inline;">
                                                                        <input type="hidden" name="college_id" value="<?php echo $row['id']; ?>">
                                                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                                                    </form>
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
                                        echo '<tr><td colspan="3" class="text-center">No College Found!</td></tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>
