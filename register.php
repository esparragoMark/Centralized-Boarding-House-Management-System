<?php 
session_start();

if (isset($_SESSION['authentication'])) {
    $_SESSION['message'] = "You are already logged in";
    $_SESSION['message_type'] = 'warning';
    header('Location: index.php');
    exit();
}

include('frontend_includes/header.php');
?>

<style>
    /* Main theme color: #08614E */
    body {
        background-color: #f5f5f5;
        font-family: 'Poppins', sans-serif;
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;
        background-image: url('admin/assets/images/Untitled design.png'); /* Add your background image */
        background-size: cover; /* Cover the entire background */
        background-position: center; /* Center the background image */
        background-repeat: no-repeat; /* Prevent repeating the background image */
        position: relative; /* Position relative for absolute elements */
    }

    .container{
        max-width: 1140px;
    }

    .form-container {
        display: flex; /* Use flexbox for centering */
        flex-direction: column; /* Stack children vertically */
        align-items: center; /* Center horizontally */
        max-width: 1000px;
        width: 100%;
        min-height: 700px; 
        margin: 0 auto;
        margin-bottom: 10px;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 20px; /* Optional: adds rounded corners for a softer look */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Optional: adds subtle shadow for depth */
        background-image: url('admin/assets/images/Untitled design.png'); /* Add your background image */
        background-size: cover; /* Cover the entire background */
        background-position: center; /* Center the background image */
        background-repeat: no-repeat; /* Prevent repeating the background image */
        position: relative; /* Position relative for absolute elements */
    }

    .form-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-header h2 {
        color: #08614E;
        font-weight: 600;
        font-size: 1.8rem;
    }

    .form-header p {
        color: #6c757d;
        font-size: 1rem;
    }

    .form-group {
        position: relative;
        margin-bottom: 20px;
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
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #08614E;
        box-shadow: none;
        border-radius: 25px;
    }

    select.form-control {
        padding-left: 45px;
        height: 50px;
        border-radius: 25px;
        font-size: 1rem;
    }

    .form-control::placeholder {
        font-size: 0.9rem;
    }

    .btn-custom {
        background-color: #08614E;
        border-color: #08614E;
        color: white;
        width: 100%;
        padding: 12px;
        border-radius: 25px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #06593e;
        border-color: #06593e;
    }

    .form-footer {
        text-align: center;
        margin-top: 20px;
    }

    .form-footer p {
        color: #6c757d;
        font-size: 1rem;
    }

    .form-footer a {
        color: #08614E;
        font-weight: 600;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    /* Bouncing Ball Styles */
    .bouncing-balls {
        position: absolute;
        bottom: 20px; /* Position above the bottom of the container */
        left: 50%; /* Center horizontally */
        transform: translateX(-50%); /* Adjust for width of the balls */
        display: flex;
        justify-content: space-around; /* Space out the balls evenly */
        width: 100%; /* Ensure it takes full width of the container */
        max-width: 450px; /* Set a max width for the balls */
        z-index: 0; /* Behind the form */
    }

    .ball {
        border-radius: 50%;
        position: relative; /* Use relative positioning for animation */
        animation: fly 2s infinite;
    }

    .ball1 {
        width: 30px; /* Small ball */
        height: 30px;
        background-color: #08614E;
        animation-delay: 0s;
    }

    .ball2 {
        width: 50px; /* Medium ball */
        height: 50px;
        background-color: #0a8f78;
        animation-delay: 0.5s;
    }

    .ball3 {
        width: 40px; /* Medium ball */
        height: 40px;
        background-color: #0bc9b2;
        animation-delay: 1s;
    }

    .ball4 {
        width: 35px; /* Small ball */
        height: 35px;
        background-color: #4caf50;
        animation-delay: 1.5s;
    }

    .ball5 {
        width: 55px; /* Large ball */
        height: 55px;
        background-color: #ff9800;
        animation-delay: 2s;
    }

    @keyframes fly {
        0% {
            transform: translateY(0);
        }
        25% {
            transform: translateY(-30px); /* Fly up */
        }
        50% {
            transform: translateY(0); /* Return to base */
        }
        75% {
            transform: translateY(-15px); /* Slightly up */
        }
        100% {
            transform: translateY(0); /* Return to base */
        }
    }

    .footer{
        display: none;
    }

    .form-icon-toggle {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #08614E;
    font-size: 18px;
    cursor: pointer;
    outline: none;
    }
</style>

<div class="container">
    <div class="form-container">
        <div class="form-header">
            <h2>Register</h2>
            <p>Join Now!</p>
        </div>
        <form action="frontend_includes/auth_code.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-venus-mars"></i></span>
                        <select class="form-control" name="gender" id="gender" required>
                            <option value="" disabled selected>--Select Gender--</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-graduation-cap"></i></span>
                        <input type="text" class="form-control" name="course" id="course" placeholder="e.g. BSCS 4A" required>
                    </div>
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-phone"></i></span>
                        <input type="text" class="form-control" name="contactNumber" id="contactNumber" placeholder="Contact Number" required>
                    </div>
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-home"></i></span>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" name="guardian" id="guardian" placeholder="Guardian" required>
                    </div>
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-phone"></i></span>
                        <input type="text" class="form-control" name="guardianContact" id="guardianContact" placeholder="Guardian Contact Number" required>
                    </div>
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" name="emailAddress" id="emailAddress" placeholder="Email Address" required>
                    </div>
                    <!-- <span style="color: #08614E; font-size: 13px;">Create Password</span> -->
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        <button type="button" id="togglePassword" class="form-icon-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
                        <button type="button" id="toggleConfirmPassword" class="form-icon-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                </div>
            </div>

            <button type="submit" name="register_btn" class="btn btn-custom">Register Now</button>
        </form>
        <div class="form-footer">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>

        <!-- Bouncing Balls -->
        <div class="bouncing-balls">
                <div class="ball ball1"></div>
                <div class="ball ball2"></div>
                <div class="ball ball3"></div>
                <div class="ball ball4"></div>
                <div class="ball ball5"></div>
            </div>
    </div>
</div>

<?php include('frontend_includes/footer.php'); ?>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    togglePassword.addEventListener('click', function () {
        // Toggle password visibility
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        // Toggle the eye icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    toggleConfirmPassword.addEventListener('click', function () {
        // Toggle confirm password visibility
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        // Toggle the eye icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>
