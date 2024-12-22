<?php
session_start();
require "config/config.php";

$token = $_GET["token"];
$userRole = $_GET["userRole"];

// Hash the token to compare with the stored hash
$token_hash = hash("sha256", $token);

// Initialize SQL query based on user role
if ($userRole === 'student') {
    $sql = "SELECT * FROM users WHERE reset_token = '$token_hash'";
} elseif ($userRole === 'landlord') {
    $sql = "SELECT * FROM landlords_acc WHERE reset_token = '$token_hash'";
} elseif ($userRole === 'admin') {
    $sql = "SELECT * FROM admin_acc WHERE reset_token = '$token_hash'";
} else {
    die("Invalid user role");
}

// Execute the query
$sql_run = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($sql_run);

// Check if the user was found
if ($user === null) {
    die("Token not found");
}

// Check if the token has expired
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired");
}

// Proceed with password reset form (not included in this snippet)
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" type="image/png" href="favicon.png">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
            padding: 20px;
            background-image: url('admin/assets/images/Untitled design.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            max-width: 1000px;
            width: 100%;
            min-height: 700px; 
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            background-color: #fff;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-image: url('admin/assets/images/Untitled design.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .form-header img {
            width: 100%;
            max-width: 300px;
            height: auto;
        }

        .form-group {
            position: relative;
            margin-bottom: 15px;
            width: 100%;
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
            max-width: 400px;
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
            margin-top: 15px;
        }

        .btn-custom:hover {
            background-color: #064c3b;
        }

        .bouncing-balls {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: space-around;
            width: 100%;
            max-width: 450px;
            z-index: 0;
        }

        .ball {
            border-radius: 50%;
            animation: fly 2s infinite;
        }

        .ball1 { width: 30px; height: 30px; background-color: #08614E; animation-delay: 0s; }
        .ball2 { width: 50px; height: 50px; background-color: #0a8f78; animation-delay: 0.5s; }
        .ball3 { width: 40px; height: 40px; background-color: #0bc9b2; animation-delay: 1s; }
        .ball4 { width: 35px; height: 35px; background-color: #4caf50; animation-delay: 1.5s; }
        .ball5 { width: 55px; height: 55px; background-color: #ff9800; animation-delay: 2s; }

        @keyframes fly {
            0%, 50%, 100% { transform: translateY(0); }
            25% { transform: translateY(-30px); }
            75% { transform: translateY(-15px); }
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
        h2{
            font-weight: 600;
            color: #08614E;
            margin-bottom: 2rem;
        }

         @media (max-width: 576px) {
        .bouncing-balls{
            display: none;
        }

        .form-header h2{
            font-size: 2.1rem;
            font-weight: 600;
        }
    }
     @media (max-width: 576px) {
        .container{
            max-width: 1140px;
            margin-bottom: 50px;
        }

        body{
            padding: 10px;
            background: #08614E;
        }

        .form-header{
            margin-bottom: 2rem;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-header">
           <h2>Reset Password</h2>
        </div>
        <form action="proccess_reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <input type="hidden" name="userRole" value="<?= htmlspecialchars($userRole) ?>">

            <div class="form-group">
                <span class="form-icon"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" name="password" id="newpassword" placeholder="Enter New Password" required>
                <button type="button" class="form-icon-toggle" onclick="togglePasswordVisibility('newpassword', this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <div class="form-group">
                <span class="form-icon"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control" name="pass_confirm" id="pass_confirm" placeholder="Confirm Password" required>
                <button type="button" class="form-icon-toggle" onclick="togglePasswordVisibility('pass_confirm', this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn btn-custom">Reset</button>
        </form>

        <div class="bouncing-balls">
            <div class="ball ball1"></div>
            <div class="ball ball2"></div>
            <div class="ball ball3"></div>
            <div class="ball ball4"></div>
            <div class="ball ball5"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if (isset($_SESSION['message_type'])): ?>
            <?php if ($_SESSION['message_type'] == 'success'): ?>
                Swal.fire({ icon: 'success', text: '<?= $_SESSION['message']; ?>' });
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            <?php elseif ($_SESSION['message_type'] == 'warning'): ?>
                Swal.fire({ icon: 'warning', text: '<?= $_SESSION['message']; ?>' });
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            <?php endif; ?>
        <?php endif; ?>
    });

    function togglePasswordVisibility(id, toggleButton) {
        const passwordField = document.getElementById(id);
        const isPassword = passwordField.type === "password";
        passwordField.type = isPassword ? "text" : "password";
        toggleButton.querySelector('i').classList.toggle('fa-eye');
        toggleButton.querySelector('i').classList.toggle('fa-eye-slash');
    }
    </script>

</body>
</html>
