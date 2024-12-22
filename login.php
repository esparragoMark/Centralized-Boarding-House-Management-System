<?php 
session_start();
include('frontend_includes/header.php');

if (isset($_SESSION['authentication'])) {
    $_SESSION['message'] = "You are already logged in";
    $_SESSION['message_type'] = 'warning';
    header('Location: index.php');
    exit();
}
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
        text-align: center; /* Center text */
        margin-bottom: 20px; /* Adjusted for consistency */
    }

    .form-header img {
        width: 100%; /* Responsive image */
        max-width: 300px; /* Set a maximum width for the image */
        height: auto; /* Maintain aspect ratio */
    }

    .form-header i {
        font-size: 65px;
        color: #08614E;
    }

    .form-header h4 {
        color: #08614E;
        margin-top: 10px;
        font-weight: 600; /* Match the header style */
        font-size: 1.8rem;  /* Adjusted size for better readability */
    }

    .form-group {
        position: relative;
        margin-bottom: 20px; /* Consistent spacing */
        width: 100%; /* Ensure full width for inputs */
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
        border-radius: 25px;
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

    .form-footer {
        text-align: center;
        margin-top: 15px;
    }

    .form-footer a {
        color: #08614E;
        font-size: .9rem;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    /* Bouncing Ball Styles */
    .bouncing-balls {
        position: absolute;
        bottom: 5px; /* Position above the bottom of the container */
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

    @media (max-width: 576px) {
        .bouncing-balls{
            display: none;
        }

        .login_links{
            margin-bottom: 2rem;
        }
    }


</style>

<div class="py-0">
    <div class="container con2">
        <div class="form-container">
            <div class="form-header">
                <img src="form_user_lgo.png" alt="logo">
            </div>
            <form action="frontend_includes/auth_code.php" method="POST">
                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" name="emailAddress" id="emailAddress" placeholder="Email Address" required>
                </div>

                <div class="form-group">
                    <span class="form-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    <button type="button" id="togglePassword" class="form-icon-toggle">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>


                <button type="submit" name="login_btn" class="btn btn-custom">Log In</button>
            </form>
            <div class="form-footer">
                <div class="login_links" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px ">
                    <a href="forget_password.php">Forget Password?</a>
                    <a href="admin/admin_login_form.php">Administrator</a>
                </div>
                <p>Don't have an account? <a href="register.php">Register Now!</a></p>
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
</div>

<?php include('frontend_includes/footer.php'); ?> 

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle the eye icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

