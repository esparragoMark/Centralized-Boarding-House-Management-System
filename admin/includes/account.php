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
    min-height: 300px; /* Set your desired minimum height */
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
    background-color: #f2f2f2; /* Alternating row color */
}

table tbody tr:hover {
    background-color: #e0e0e0; /* Hover effect */
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
    <h3 class="mb-4">Manage Account</h3>
    <div class="row">
        <!-- Add Account Button -->
        <div class="col-sm-12 text-end">
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addAccountModal" style="background-color: #08614e; color: white">
                <i class="fas fa-plus me-2"></i>Add Account
            </button>
        </div>

        <!-- Table Column -->
        <div class="col-sm-12 col-md-12 col-lg-12 mt-3">
            <div class="card shadow-sm" style="padding: .5rem; height: 550px">
                <div class="card-body">
                    <h3 class="college-text mb-3 text-center">List Boarding House Account </h3>
                    <div class="table-responsive design-table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Name</th>
                                    <th>Boarding House</th>
                                    <th>Email Address</th>
                                    <th>Password</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $getAccount = "SELECT * FROM landlords_acc";
                                    $getAccount_run = mysqli_query($con, $getAccount);

                                    if (mysqli_num_rows($getAccount_run) > 0) {
                                        $count = 1;
                                        while ($row = mysqli_fetch_assoc($getAccount_run)) { 
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $count; ?></td>
                                                <td><?php echo $row['fullname']; ?></td> 
                                                <td><?php echo $row['bh_name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['password']; ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['landlord_id']; ?>">
                                                        <i class="fas fa-trash" style="margin-right: 5px"></i>Remove
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteModal<?php echo $row['landlord_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['landlord_id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $row['landlord_id']; ?>" style="color: white">Confirm Delete</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete <strong><?php echo $row['fullname']; ?></strong> account?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="deleteAccount.php" method="POST" style="display:inline;">
                                                                        <input type="hidden" name="landlord_id" value="<?php echo $row['landlord_id']; ?>">
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
                                        echo '<tr><td colspan="6" class="text-center">No Account Found!</td></tr>';
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

<!-- Add Account Modal -->
<div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAccountModalLabel" style="color: white">Add Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="addAccount.php" method="POST">
                    <div class="form-group mb-3">
                        <label for="name" class="college-text">Enter Name</label>
                        <input type="text" class="form-control" name="name" id="name"  required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="bhname" class="college-text">Enter Boarding House Name</label>
                        <input type="text" class="form-control" name="bhname" id="bhname"  required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="college-text">Enter Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="college-text">Enter Password</label>
                        <input type="password" class="form-control" name="password" id="password"  required>
                    </div>
                    <button type="submit" name="btn-addAccount" class="btn btn-success float-end">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?> 
