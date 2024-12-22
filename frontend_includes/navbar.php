<?php
include("config/config.php"); 
?>
<nav class="navbar navbar-expand-lg border-1">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <?php
                // Query to select display configuration
                $displayConfig = "SELECT * FROM dislay_config";
                $displayConfig_run = mysqli_query($con, $displayConfig);
                
                if(mysqli_num_rows($displayConfig_run) > 0) {
                    $row = mysqli_fetch_assoc($displayConfig_run);
                    ?>
                    <!-- Display the logo image -->
                    <img src="adminUploads/<?=$row['image']?>" alt="photo" style="height: 70px">
                    <?php
                } else {
                    echo '<p class="text-center">No Display Data Found!</p>';
                }
            ?> 
        </a>
        <button class="navbar-toggler center-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse custom-navbar" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <?php
                if(isset($_SESSION['auth_user']) && $_SESSION['authentication'] === true) {
                    // If the user is logged in
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservation.php">Reservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="studentAccount.php">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php
                } else {
                    // If the user is not logged in
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
