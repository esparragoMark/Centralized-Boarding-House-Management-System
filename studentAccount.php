<?php 
ob_start();
session_start();
include("frontend_includes/header.php");
include("config/config.php");

// Check if the user is authenticated
if(isset($_SESSION['authentication'])) {
    $userID = $_SESSION['auth_user']['id'];
} else {
    $_SESSION['message'] = "Please Log in!";
    $_SESSION['message_type'] = "warning";
    header('Location: login.php');
    exit;
}

// Fetch user account details
$getAccount = "SELECT * FROM users WHERE user_id = '$userID' ";
$getAccount_run = mysqli_query($con, $getAccount);
if(mysqli_num_rows($getAccount_run) > 0) {
    $row = mysqli_fetch_array($getAccount_run);
}

// Update account function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_account'])) {
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $contact_number = mysqli_real_escape_string($con, $_POST['contact_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $guardian_name = mysqli_real_escape_string($con, $_POST['guardian_name']);
    $guardian_contact = mysqli_real_escape_string($con, $_POST['guardian_contact']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Hash the password if it's not empty
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateAccount = "UPDATE users SET fullname='$fullname', gender='$gender', course='$course', contact_number='$contact_number', email='$email', address='$address', guardian_name='$guardian_name', guardian_contact='$guardian_contact', password='$hashedPassword' WHERE user_id='$userID'";
    } else {
        // If password is empty, don't update it
        $updateAccount = "UPDATE users SET fullname='$fullname', gender='$gender', course='$course', contact_number='$contact_number', email='$email', address='$address', guardian_name='$guardian_name', guardian_contact='$guardian_contact' WHERE user_id='$userID'";
    }

    if (mysqli_query($con, $updateAccount)) {
        $_SESSION['message'] = "Account updated successfully!";
        $_SESSION['message_type'] = "success";
        header('Location: studentAccount.php'); // Redirect to account page
        exit;
    } else {
        $_SESSION['message'] = "Error updating account!";
        $_SESSION['message_type'] = "danger";
        header('Location: studentAccount.php'); // Redirect to account page
    }
}

ob_end_flush();
?>

<style>
    /* Main theme color: #08614E */
    body {
        background-color: #f5f5f5;
        font-family: 'Poppins', sans-serif; /* Set the new font */
        background-image: url('admin/assets/images/Untitled design.png'); /* Add your background image */
        background-size: cover; /* Cover the entire background */
        background-position: center; /* Center the background image */
        background-repeat: no-repeat; /* Prevent repeating the background image */
        position: relative; /* Position relative for absolute elements */
    }

    .container {
        max-width: 1140px;
    }

    .form-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff; /* Light shade of your main color for contrast */
        border-radius: 10px; /* Optional: adds rounded corners for a softer look */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Optional: adds subtle shadow for depth */
       
    }

    .form-header {
        text-align: center;
        margin-bottom: 20px; /* Adjusted for consistency */
    }

    .form-header h4 {
        color: #08614E;
        margin-top: 10px;
        font-weight: 700; /* Match the header style */
        font-size: 1.8rem;  /* Adjusted size for better readability */
    }

    .form-group {
        position: relative;
        margin-bottom: 20px; /* Consistent spacing */
    }

    .form-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #08614E;
    }

    .form-control {
        padding-left: 45px;
        height: 50px;
        border-radius: 25px;
        border: 1px solid #ced4da;
        font-size: 1rem; /* Adjust font size for consistency */
    }

    .form-control:focus {
        border-color: #08614E;
        box-shadow: none;
    }

    .btn-custom {
        background-color: #08614E;
        border-color: #08614E;
        color: white;
        width: 100%;
        padding: 10px;
        border-radius: 25px;
        font-weight: 500; /* Match button text weight */
        transition: background-color 0.3s;
    }

    .btn-custom:hover {
        background-color: #06593e;
        border-color: #06593e;
    }

    .footer .footer-text{
        color: #08614e;
    }
</style>

<div class="py-3">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h4>Update Account Details</h4>
            </div>
            <form action="" method="POST">
                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" name="fullname" id="fullname" value="<?= $row['fullname']; ?>" placeholder="Full Name" required>
                </div>

                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-venus-mars"></i></span>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="Male" <?= ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?= ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-book"></i></span>
                    <input type="text" class="form-control" id="course" name="course" value="<?= $row['course']; ?>" placeholder="Course" required>
                </div>

                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-phone-alt"></i></span>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= $row['contact_number']; ?>" placeholder="Contact Number" required>
                </div>

                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $row['email']; ?>" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-home"></i></span>
                    <input type="text" class="form-control" id="address" name="address" value="<?= $row['address']; ?>" placeholder="Address" required>
                </div>

                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-user-shield"></i></span>
                    <input type="text" class="form-control" id="guardian_name" name="guardian_name" value="<?= $row['guardian_name']; ?>" placeholder="Guardian's Name" required>
                </div>

                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-phone-alt"></i></span>
                    <input type="text" class="form-control" id="guardian_contact" name="guardian_contact" value="<?= $row['guardian_contact']; ?>" placeholder="Guardian's Contact" required>
                </div>

                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                </div>

                <button type="submit" name="update_account" class="btn btn-custom">Update Account</button>
            </form>
        </div>
    </div>
</div>

<?php 
include("frontend_includes/footer.php");
?>



<!-- JavaScript to toggle password visibility and icon -->
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
</script>
