<?php

include("../../config/config.php");

$landlord_id = $_SESSION['auth_landlord']['id'];

$data_query = "SELECT * FROM landlords_acc WHERE landlord_id = '$landlord_id'";
$data_query_run = mysqli_query($con, $data_query);

if(mysqli_num_rows($data_query_run) > 0){
    $result_data = mysqli_fetch_assoc($data_query_run);
}
else{
    echo "Landlord not found!";
}

?>


<div class="main">
    <nav class="navbar navbar-expand px-3 ">
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
                            <?= $result_data['bh_name']; ?></div>
                        <div style="text-align: center;">

                            <?php

                              
                                $profileImage = "SELECT image FROM profile_image WHERE landlord_id = '$landlord_id'";
                                $profileImage_run = mysqli_query($con, $profileImage);

                                if(mysqli_num_rows($profileImage_run) > 0) {
                                    $image = mysqli_fetch_assoc($profileImage_run);

                                    echo '<img src="../landlord_uploads/' . htmlspecialchars($image['image'], ENT_QUOTES, 'UTF-8') . '" alt="image"
                                    style="width: 75px; height: 75px; margin-bottom: 10px; border-radius: 50%; margin-top: 10px; border: 2px solid white">';
                                } else {

                                    echo '<img src="../assets/images/usergreen_default.png" alt="image"
                                    style="width: 75px; height: 75px; margin-bottom: 10px; border-radius: 50%; margin-top: 10px; border: 2px solid white">';
                                }

                            ?>


                        </div>
                        <div style="text-align: center; color: white; margin-bottom: 10px;">
                            <div style="font-size: 1rem"> <?= $result_data['fullname']; ?></div>

                            <div style="font-size: .7rem; color: #CCCCCC;"> <?= $result_data['email']; ?></div>

                            <div style="color: lightgreen;font-size: .5rem;">● online</div>
                        </div>
                        <hr>
                        <div class="dropDownbtn">
                            <a href="account.php" class="dropdown-item">
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