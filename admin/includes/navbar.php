<?php
include("../../config/config.php");

// Get admin data
$data = "SELECT * FROM admin_acc";
$data_run = mysqli_query($con, $data);

if (!$data_run) {
    die("Query failed: " . mysqli_error($con));
}

$row = mysqli_fetch_assoc($data_run);
?>

<div class="main">
    <nav class="navbar navbar-expand px-3">
        <button class="btn" id="sidebar-toggle" type="button">
            <i class="fas fa-bars" style="color: #08614E;"></i>
        </button>

        <div class="navbar-collapse navbar">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                        <img src="../assets/images/usergreen_default.png" class="avatar img-fluid" alt="image">
                    </a>

                    <div class="dropdown-menu dropdown-menu-end drop-menu"
                        style="background: #08614E; padding: 10px; width: 250px;">
                        <div style="font-size: .8rem; color: #FFFFFF;" class="text-center">
                            Administrator
                        </div>
                        <div style="text-align: center;">
                            <?php if (!empty($row['profile'])): ?>
                                <img src="../assets/images/<?php echo htmlspecialchars($row['profile'], ENT_QUOTES, 'UTF-8'); ?>" 
                                     alt="image" style="width: 75px; height: 75px; margin-bottom: 10px; 
                                     border-radius: 50%; margin-top: 10px; border: 2px solid white">
                            <?php else: ?>
                                <img src="../assets/images/usergreen_default.png" alt="image"
                                     style="width: 75px; height: 75px; margin-bottom: 10px; 
                                     border-radius: 50%; margin-top: 10px; border: 2px solid white">
                            <?php endif; ?>
                        </div>
                        <div style="text-align: center; color: white; margin-bottom: 10px;">
                            <?php if ($row): ?>
                                <div style="font-size: 1rem"> 
                                    <?php echo htmlspecialchars($row['fullname'], ENT_QUOTES, 'UTF-8'); ?> 
                                </div>
                                <div style="font-size: .7rem; color: #CCCCCC;">
                                    <?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?> 
                                </div>
                                <div style="color: lightgreen; font-size: .5rem;">● online</div>
                            <?php else: ?>
                                <div>No admin data found.</div>
                            <?php endif; ?>
                        </div>
                        <hr>
                        <div class="dropDownbtn">
                            <a href="adminAccount.php" class="dropdown-item">
                                <i class="fas fa-pen"></i>Edit Account
                            </a>
                            <a href="logout.php" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <main class="content px-3">
