<?php 
session_start();
include("frontend_includes/header.php");
include("config/config.php");

// Fetch display configuration
$displayConfig = "SELECT * FROM dislay_config";
$displayConfig_run = mysqli_query($con, $displayConfig);

if(mysqli_num_rows($displayConfig_run) > 0)
{
    $row = mysqli_fetch_assoc($displayConfig_run);
}
else{
    echo '<p class="text-center">No Display Data Found!</p>';
}

// Handle search functionality
$searchQuery = '';
if(isset($_POST['submit_search'])) {
    $search = mysqli_real_escape_string($con, $_POST['search']);

    // Build the search query
    $searchQuery = "SELECT bh.*, r.gender, r.monthly_rent, r.vacant_bed 
                    FROM boarding_house_registration bh 
                    LEFT JOIN rooms r ON bh.bh_id = r.bh_fk 
                    WHERE bh.house_name LIKE '%$search%' 
                    OR bh.house_location LIKE '%$search%' 
                    OR r.gender LIKE '%$search%' 
                    OR r.monthly_rent LIKE '%$search%'";
} else {
    // Default query to fetch all data if no search term
    $searchQuery = "SELECT bh.*, r.gender, r.monthly_rent, r.vacant_bed 
                    FROM boarding_house_registration bh 
                    LEFT JOIN rooms r ON bh.bh_id = r.bh_fk";
}

$searchQuery_run = mysqli_query($con, $searchQuery);
?>

<style>
    /* Main theme color: #08614E */
    body {
        background-color: #f5f5f5;
        font-family: 'Poppins', sans-serif; /* Set the new font */
        background: linear-gradient(white, #08614E);
        /* background-image: url('admin/assets/images/Untitled design.png');  */
        /* background-size: cover;  */
        /* background-position: center; 
        background-repeat: no-repeat;  */
        position: relative; 
    }

    .header-title {
        color: #08614E;
        font-weight: 600; /* Slightly bolder for a header */
        font-size: 1.5rem;  /* Adjust size for better readability */
    }

    .search-container {
        padding: 20px;
        /* background-color: #f8f9fa; */
        background-color: transparent;
        border-radius: 10px;
        /* box-shadow: 0 4px 8px rgba(0,0,0,0.1); */
    }

    .search-input {
        height: 50px;
        border-radius: 25px;
        font-size: 1rem; /* Adjust font size */
        padding-left: 2rem;
        border-right: none;
    }

    .search-input:focus{
        border-radius: 25px;
    }

    .search-btn{
        background-color: #fff;
        border-color: #cccfcc;
        padding: 12px 20px;
        border-radius: 25px;
        color: #08614E;
        font-weight: 500; /* Make button text slightly bold */
        border-left: none;
    }
    .search-btn:hover{
        background-color: #fff;
        border-color: #ccc;
        padding: 12px 20px;
        border-radius: 25px;
        color: #08614E;
        font-weight: 5s00; /* Make button text slightly bold */
        border-left: none;
    }

    .card-container {
        /* background-color: #ffffff; */
        background-color: transparent;
        border-radius: 20px;
        /* background: rgba(255, 255, 255, 0.2); 
        backdrop-filter: blur(10px);  */
        /* box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);  */
        padding: 25px; /* Padding inside the container */
        /* border: 1px solid rgba(255, 255, 255, 0.5);  */
    }

    .card {
        border-radius: 10px;
        transition: transform 0.2s;
        font-family: 'Poppins', sans-serif; /* Apply to the cards too */
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-title {
        font-weight: 700;
        color: #343a40;
        font-size: 0.9rem; /* Adjust title size for clarity */
    }

    .card-text i {
        margin-right: 8px;
        color: #08614E;
    }

    .card-text span{
        font-size: 0.8rem;
    }

    .card-text .rent{
        font-size: 1.1rem;
        color: red;
        font-weight: 500
    }

    .reserve-btn {
        background-color: #08614E;
        border-color: #08614E;
        border-radius: 5px;
        color: white;
        font-weight: 500;
    }

    .reserve-btn:hover {
        background-color: #06593e;
        border-color: #06593e;
    }

    .text-success {
        color: #08614E !important; /* Override to match the theme */
    }

    .text-danger {
        color: #d9534f !important; /* Keeping red for critical elements */
    }

    .container, .card-container {
        max-width: 1140px;
        
    }

    /* Style for 'No Result' section */
    .not-found-img {
        max-width: 310px;
        height: auto;
        margin: 20px auto;
        display: block;
        opacity: 0.85;
    }

    h4 {
        font-weight: 500;
        color: #343a40;
        font-size: 1.5rem; /* Increase the size for better emphasis */
    }

    .footer .footer-text{
        /* color: #08614e; */
        color: white;
    }

    /* Animation for the SVG blob */
    #blob {
        animation: blobAnimation 10s infinite;
        transition: all 0.5s ease-in-out;
    }

    /* Keyframes for the blob animation */
    @keyframes blobAnimation {
        0% {
            d: path("M421.5,283Q388,316,391,373Q394,430,346.5,446.5Q299,463,260.5,417Q222,371,191.5,366.5Q161,362,142.5,336.5Q124,311,83,280.5Q42,250,55.5,206.5Q69,163,127,165.5Q185,168,190,87.5Q195,7,250,7Q305,7,349,38.5Q393,70,427,109Q461,148,458,199Q455,250,421.5,283Z");
        }
        25% {
            d: path("M432,286.5Q402,323,399,378Q396,433,348,450.5Q300,468,259,430Q218,392,184,384Q150,376,129,347.5Q108,319,71.5,284.5Q35,250,48.5,204.5Q62,159,116,154Q170,149,182.5,78Q195,7,250,7Q305,7,350.5,37Q396,67,430,107Q464,147,463,198.5Q462,250,432,286.5Z");
        }
        50% {
            d: path("M421.5,283Q388,316,391,373Q394,430,346.5,446.5Q299,463,260.5,417Q222,371,191.5,366.5Q161,362,142.5,336.5Q124,311,83,280.5Q42,250,55.5,206.5Q69,163,127,165.5Q185,168,190,87.5Q195,7,250,7Q305,7,349,38.5Q393,70,427,109Q461,148,458,199Q455,250,421.5,283Z");
        } 
        75% {
            d: path("M432,286.5Q402,323,399,378Q396,433,348,450.5Q300,468,259,430Q218,392,184,384Q150,376,129,347.5Q108,319,71.5,284.5Q35,250,48.5,204.5Q62,159,116,154Q170,149,182.5,78Q195,7,250,7Q305,7,350.5,37Q396,67,430,107Q464,147,463,198.5Q462,250,432,286.5Z");
        }
        100% {
            d: path("M421.5,283Q388,316,391,373Q394,430,346.5,446.5Q299,463,260.5,417Q222,371,191.5,366.5Q161,362,142.5,336.5Q124,311,83,280.5Q42,250,55.5,206.5Q69,163,127,165.5Q185,168,190,87.5Q195,7,250,7Q305,7,349,38.5Q393,70,427,109Q461,148,458,199Q455,250,421.5,283Z");
        } 
    }

    .row2{
        /* min-height: 100vh; */
    }

    @media (max-width: 576px) {
    .card-container{
        padding: 15px !important; /* Remove padding */
        margin: 0 !important;  /* Remove margin */
    }
    .card {
        margin: 0 !important;
    }

    .header-title {
        font-size: 1.2rem;
        font-weight: 700;
    }

}

</style>

<!-- <div class="position-absolute w-50  d-lg-block" style="opacity: 0.5; z-index: -1; left: 0; bottom: 0; height: auto">
    <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" id="blobSvg">
    <path id="blob" d="M421.5,283Q388,316,391,373Q394,430,346.5,446.5Q299,463,260.5,417Q222,371,191.5,366.5Q161,362,142.5,336.5Q124,311,83,280.5Q42,250,55.5,206.5Q69,163,127,165.5Q185,168,190,87.5Q195,7,250,7Q305,7,349,38.5Q393,70,427,109Q461,148,458,199Q455,250,421.5,283Z" fill="#08614e"></path>
    </svg>
</div> -->

<div class="container my-3  rounded">
    <h3 class="text-center header-title mb-2"><?=$row['front_end_text']?></h3>
    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-10 col-lg-8 py-3">
            <div class="search-container">
                <form action="" method="POST">
                    <div class="input-group">
                        <input type="search" class="form-control search-input" name="search" placeholder="Search..." aria-label="Search" value="<?php if(isset($_POST['search'])) { echo htmlspecialchars($_POST['search']); } ?>">
                        <button type="submit" class="btn search-btn" name="submit_search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="py-2">
    <div class="container p-2 card-container">
        <div class="row">
            <div class="col-md-12">
                <div class="row g-4  row2">
                    
                    <?php
                        if(mysqli_num_rows($searchQuery_run) > 0)
                        {
                            foreach($searchQuery_run as $data)
                            {
                                ?>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="card shadow-lg border-light">
                                        <img src="landlord/landlord_uploads/<?php echo htmlspecialchars($data['bhImage']); ?>" 
                                            alt="Image" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($data['house_name']); ?></h5>
                                            <p class="card-text">
                                                <i class="fas fa-map-marker-alt"></i><span>Near at <?php echo htmlspecialchars($data['house_location']); ?></span> <br>
                                                <i class="fas fa-venus-mars"></i><span><?php echo htmlspecialchars($data['gender']); ?></span><br>
                                                <span class="rent">PHP <?php echo htmlspecialchars($data['monthly_rent']); ?></span><br>
                                            </p>
                                            <a href="selected_bhID.php?boarding_house_id=<?php echo htmlspecialchars($data['bh_id']); ?>" class="btn reserve-btn btn-sm float-end">Reserve Now</a>
                                        </div>
                                    </div>
                                    
                                </div>
                                <?php
                            }
                        }
                        else
                        {
                            echo '
                            <div class="text-center text-muted py-4">
                                <img src="notFound.png" alt="Not Found" class="not-found-img" style="width: 310px; height: auto">
                                <h4 class="text-muted"></h4>
                            </div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("frontend_includes/footer.php"); ?> 
