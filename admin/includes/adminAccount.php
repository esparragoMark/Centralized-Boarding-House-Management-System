<?php
include("header.php");
include("../../config/config.php");

// Get admin data
$data = "SELECT * FROM admin_acc";
$data_run = mysqli_query($con, $data);

if (!$data_run) {
    die("Query failed: " . mysqli_error($con));
}

$row = mysqli_fetch_assoc($data_run);
?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f5f5;
    }

    .container {
        max-width: 1140px;
        padding: 40px 20px;
    }

    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #08614E;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .card-body {
        padding: 40px 30px;
    }

    .input-group-text {
        background-color: transparent;
        border: none;
        color: #08614E;
        padding-left: 5px;
        padding-right: 5px;
    }

    .input-group-icon {
        position: relative;
    }

    .input-group-icon input {
        padding-left: 45px; /* Space for the left icon */
        padding-right: 45px; /* Space for the eye icon */
        height: 45px; /* Consistent input height */
        border-radius: 8px;
        border: 1px solid #ced4da;
    }

    .input-group-icon .form-control {
        border-color: #ced4da;
        transition: border-color 0.2s ease-in-out;
    }

    .input-group-icon .form-control:focus {
        border-color: #08614E;
        box-shadow: none;
    }

    .input-group-text-position {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 15px;
        color: #08614E;
    }

    .toggle-password-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 15px; /* Position for the eye icon */
        cursor: pointer;
        color: #6c757d;
    }

    .toggle-password-icon:hover {
        color: #333;
    }

    .form-label {
        font-size: 15px;
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
    }

    input[type="file"] {
        border: 1px solid #ced4da;
        border-radius: 8px;
    }

    .btn-success {
        background-color: #08614E;
        border: none;
        border-radius: 8px;
        padding: 12px 25px;
        font-size: 16px;
        transition: background-color 0.2s ease;
    }

    .btn-success:hover {
        background-color: #06543e;
    }

    .btn-success:focus {
        box-shadow: none;
    }

    /* Profile image styles */
    .image {
        border-radius: 50%;
        border: 2px solid #08614E; /* Match theme color */
        padding: 5px;
        width: 80px;
        height: 80px;
    }

    .mt-2 .image {
        margin: 10px 0;
    }

    /* Small devices adjustments */
    @media (max-width: 576px) {
        .card {
            margin: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .btn-success {
            width: 100%; /* Full-width button on mobile */
        }
    }
</style>

<div class="container ">
    <!-- <h2 class="text-center mb-4">Update Account Details</h2> -->
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header text-white">
                    <h5 class="mb-0 text-white">Admin Account Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="update_admin_account.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <div class="input-group-icon">
                                <span class="input-group-text-position"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($row['fullname'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group-icon">
                                <span class="input-group-text-position"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-group-icon">
                                <span class="input-group-text-position"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password">
                                <span class="toggle-password-icon" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="profile" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="profile" name="profile">
                            <div class="mt-2">
                                <?php if (!empty($row['profile'])): ?>
                                    <img class="image" src="../assets/images/<?= htmlspecialchars($row['profile'], ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Picture">
                                <?php else: ?>
                                    <img class="image" src="../assets/images/usergreen_default.png" alt="Default Profile Picture">
                                <?php endif; ?>
                            </div>
                        </div>
                        <input type="hidden" name="admin_id" value="<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="adminUpdateAcc">Update Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<!-- JavaScript to toggle password visibility -->
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const passwordInput = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        this.querySelector("i").classList.toggle("fa-eye");
        this.querySelector("i").classList.toggle("fa-eye-slash");
    });
</script>
