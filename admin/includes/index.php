<?php
include("header.php");
include("../../config/config.php");
?>

<style>
    .custom_text_dash {
        border-radius: 8px;
        transition: transform 0.2s;
    }

    .custom_text_dash:hover {
        transform: scale(1.05);
    }

    .bg-gradient {
        background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
    }

    .card {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .arrow-icon-container {
    display: inline-flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 40px;
    background-color: #08614E;
    border-radius: 10px;
    padding-left: 10px;
    padding-right: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Example shadow */
}


    .arrow-icon {
        color: white;
        font-size: 1.2rem;
    }
</style>

<div class="container my-4">
    <h3 class="mb-4">Dashboard</h3>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
            <a href="account.php" class="text-decoration-none text-dark">
                <div class="card text-center custom_text_dash bg-white bg-gradient">
                    <div class="card-body align-items-center">
                        <div class="custom_icon mb-4">
                            <i class="fas fa-lock fa-3x" style="font-size: 3.5rem; color: #08614E"></i>
                        </div>
                        <div>
                            <?php
                                $getNumberOfAcc = "SELECT * FROM landlords_acc";
                                $getNumberOfAcc_run = mysqli_query($con, $getNumberOfAcc);
                                $allAcc = mysqli_num_rows($getNumberOfAcc_run);
                                echo "<h3>" . ($allAcc > 0 ? $allAcc : 0) . "</h3>";
                            ?>
                            <h4 class="mb-0" style="color: #08614E">Boarding House Account</h4>
                        </div>
                        <div class="mt-3 text-end">
                            <div class="arrow-icon-container">
                                <span>View</span><i class="fas fa-arrow-right arrow-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
            <a href="college.php" class="text-decoration-none text-dark">
                <div class="card text-center custom_text_dash bg-white bg-gradient">
                    <div class="card-body align-items-center">
                        <div class="custom_icon mb-4">
                            <i class="fas fa-building fa-3x" style="font-size: 3.5rem; color: #08614E"></i>
                        </div>
                        <div>
                            <?php
                                $getNumberOfCollege = "SELECT * FROM colleges";
                                $getNumberOfCollege_run = mysqli_query($con, $getNumberOfCollege);
                                $allCollege = mysqli_num_rows($getNumberOfCollege_run);
                                echo "<h3>" . ($allCollege > 0 ? $allCollege : 0) . "</h3>";
                            ?>
                            <h4 class="mb-0" style="color: #08614E">Colleges</h4>
                        </div>
                        <div class="mt-3 text-end">
                            <div class="arrow-icon-container">
                            <span>View</span><i class="fas fa-arrow-right arrow-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
            <a href="boardingHouses.php" class="text-decoration-none text-dark">
                <div class="card text-center custom_text_dash bg-white bg-gradient">
                    <div class="card-body align-items-center">
                        <div class="custom_icon mb-4">
                            <i class="fas fa-home fa-3x" style="font-size: 3.5rem; color: #08614E"></i>
                        </div>
                        <div>
                            <?php
                                $getNumberOfBh = "SELECT * FROM boarding_house_registration";
                                $getNumberOfBh_run = mysqli_query($con, $getNumberOfBh);
                                $allBh = mysqli_num_rows($getNumberOfBh_run);
                                echo "<h3>" . ($allBh > 0 ? $allBh : 0) . "</h3>";
                            ?>
                            <h4 class="mb-0" style="color: #08614E">Accredited Boarding Houses</h4>
                        </div>
                        <div class="mt-3 text-end">
                            <div class="arrow-icon-container">
                            <span>View</span><i class="fas fa-arrow-right arrow-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
            <a href="student.php" class="text-decoration-none text-dark">
                <div class="card text-center custom_text_dash bg-white bg-gradient">
                    <div class="card-body align-items-center">
                        <div class="custom_icon mb-4">
                            <i class="fas fa-users fa-3x" style="font-size: 3.5rem; color: #08614E"></i>
                        </div>
                        <div>
                            <?php
                                $getNumberOfStudent = "SELECT * FROM occupants";
                                $getNumberOfStudent_run = mysqli_query($con, $getNumberOfStudent);
                                $allStudent = mysqli_num_rows($getNumberOfStudent_run);
                                echo "<h3>" . ($allStudent > 0 ? $allStudent : 0) . "</h3>";
                            ?>
                            <h4 class="mb-0" style="color: #08614E">Students</h4>
                        </div>
                        <div class="mt-3 text-end">
                            <div class="arrow-icon-container">
                            <span>View</span><i class="fas fa-arrow-right arrow-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
