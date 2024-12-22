<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" type="image/png" href="../favicon.png">
    
    <style>
        body {

            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden; /* Prevent scrollbar */
            position: relative; /* Position relative for absolute elements */
            padding: 20px; /* Add some padding to the body */
            background-image: url('assets/images/Untitled design.png'); /* Add your background image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Prevent repeating the background image */
        }

        .container {
            max-width: 1000px;
            width: 100%;
            min-height: 700px; 
            padding: 40px; /* Increased padding for a better layout */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            border-radius: 20px;
            background-color: #fff;
            position: relative;
            z-index: 1; /* Ensure the form is above bouncing balls */
            display: flex; /* Use flexbox */
            flex-direction: column; /* Stack items vertically */
            /* justify-content: center; Center items vertically */
            align-items: center; /* Center items horizontally */
            background-image: url('assets/images/Untitled design.png'); /* Add your background image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Prevent repeating the background image */
        }

        .leaves i {
            font-size: 30px; /* Adjust the size of the leaves */
            color: #08614E; /* Leaf color */
            margin-right: 5px; /* Space between the leaves */
        }

        .form-header {
            text-align: center;
            margin-top: 10px; /* Optional: Add space above header if needed */
        }

        .form-header img {
            width: 100%; /* Make the image responsive */
            max-width: 300px; /* Set a maximum width for the image */
            height: auto; /* Maintain the aspect ratio */
        }

        .form-group {
            position: relative;
            margin-bottom: 15px; /* Space between inputs */
            width: 100%; /* Ensure it takes full width */
        }

        .form-group .form-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #08614E;
        }

        .form-control {
            padding-left: 40px;
            height: 50px;
            border-radius: 25px;
            border: 1px solid #ced4da;
            font-size: 1rem;
            margin-bottom: 15px; /* Space between inputs */
            width: 100%; /* Ensure it takes full width */
            max-width: 400px; /* Set a max width for the input fields */
        }

        .form-control:focus {
            border-color: #08614E;
            box-shadow: none;
        }

        .btn-custom {
            width: 100%;
            background-color: #08614E;
            color: white;
            padding: 12px;
            font-size: 16px;
            border-radius: 25px;
            transition: background-color 0.3s;
            margin-top: 15px; /* Space above button */
        }

        .btn-custom:hover {
            background-color: #064c3b;
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
        .container{
            max-width: 1140px;
            margin-bottom: 50px;
        }

        body{
            padding: 10px;
        }
    }

     a:hover{
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-header">
            <img src="assets/images/form logo.png" alt="logo">
        </div>
        <form action="login_controller.php" method="POST">
            <div class="form-group mb-3">
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


            <button type="submit" name="admin_login" class="btn btn-custom">Log In</button>
        </form>

        <a href="../forget_password.php" class="mt-3">Forget Password?</a>
        <!-- Bouncing Balls -->
        <div class="bouncing-balls">
            <div class="ball ball1"></div>
            <div class="ball ball2"></div>
            <div class="ball ball3"></div>
            <div class="ball ball4"></div>
            <div class="ball ball5"></div>
        </div>
    </div>

    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if (isset($_SESSION['message_type'])): ?>
            <?php if ($_SESSION['message_type'] == 'success'): ?>
                Swal.fire({
                    icon: 'success',
                    text: '<?php echo $_SESSION['message']; ?>',
                });
                <?php unset($_SESSION['message']); ?> <!-- Unset the message after displaying -->
                <?php unset($_SESSION['message_type']); ?> <!-- Unset message type after displaying -->
            <?php elseif ($_SESSION['message_type'] == 'warning'): ?>
                Swal.fire({
                    icon: 'warning',
                    text: '<?php echo $_SESSION['message']; ?>',
                });
                <?php unset($_SESSION['message']); ?> <!-- Unset the message after displaying -->
                <?php unset($_SESSION['message_type']); ?> <!-- Unset message type after displaying -->
            <?php endif; ?>
        <?php endif; ?>
        });
    </script>

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


</body>

</html>
