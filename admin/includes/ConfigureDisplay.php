<?php

include("header.php");
include("../../config/config.php");

$displayConfig = "SELECT * FROM dislay_config";
$displayConfig_run = mysqli_query($con, $displayConfig);

if(mysqli_num_rows($displayConfig_run) > 0)
{
    $row = mysqli_fetch_assoc($displayConfig_run);
}
else{
    echo '<p class="text-center">No Display Data Founnd!</p>';
}


?>

<style>
        .container {
            max-width: 1140px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 8px;
        }

        .card-header {
            background-color: #08614E;
            color: white;
            font-weight: bold;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        textarea, input[type="file"] {
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
        }

        textarea:focus, input[type="file"]:focus {
            border-color: #08614E;
            box-shadow: 0 0 5px rgba(0, 100, 0, 0.2);
        }

        .btn-outline-success {
            background-color: #08614E;
            color: white;
            border-color: #08614E;
            transition: background-color 0.3s ease;
        }

        .btn-outline-success:hover {
            background-color: white;
            color: #08614E;
            border-color: #08614E;
        }

        .text-center img {
            border-radius: 6px;
            border: 2px solid #08614E;
        }

        h3, h5 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #08614E;
        }

        textarea[readonly], input[readonly] {
            background-color: #f8f8f8;
            color: #333;
        }
    </style>

<div class="container my-4">
        <h3 class="mb-4">Display Configuration</h3>
        <div class="row">
            <!-- Image Logo Upload -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Update Logo</h5>
                    </div>
                    <div class="card-body">
                        <form action="configDisplayProcess.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="logoUpload" class="form-label">Upload New Logo</label>
                                <input type="file" class="form-control dropify" id="logoUpload" name="uploadImage" required>
                            </div>
                            <button type="submit" class="btn btn-outline-success btn-sm">Save</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Frontend Text Update -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Frontend Text</h5>
                    </div>
                    <div class="card-body">
                        <form action="configDisplayProcess.php" method="POST">
                            <div class="mb-3">
                                <label for="frontendText" class="form-label">Frontend Text</label>
                                <textarea class="form-control" id="frontendText" placeholder="Enter here.."
                                    name="frontEndText" style="height: 200px;" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-success btn-sm">Save</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer Text Update -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Footer Text</h5>
                    </div>
                    <div class="card-body">
                        <form action="configDisplayProcess.php" method="POST">
                            <div class="mb-3">
                                <label for="footerText" class="form-label">Footer Text</label>
                                <textarea class="form-control" id="footerText" placeholder="Enter here.."
                                    name="footerText" style="height: 200px;" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-success btn-sm">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-2">
        <h5 class="mb-4">Current Display</h5>
        <div class="row">
            <!-- Image Logo -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Logo</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <img src="../../adminUploads/<?=$row['image']?>" alt="photo" class="img-fluid" style="max-width: 100%; height: auto; max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Frontend Text -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Frontend Text</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="form-control" id="frontendText" name="frontEndText" style="height: 125px;" readonly><?=$row['front_end_text']?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Text -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Footer Text</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="form-control" id="footerText" name="footerText" style="height: 125px;" readonly><?=$row['footer_text']?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("footer.php");
    ?>



<?php
include("footer.php");
?>