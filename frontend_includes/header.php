<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Add this to your header or CSS file -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS FILE -->
    <link rel="stylesheet" href="frontend_includes/css/styles.css">

    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/85f2b68f45.js" crossorigin="anonymous"></script>

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />

    <link rel="icon" type="image/png" href="favicon.png">

    <title>HausMaster</title>

    <style>
    .footer {

        width: 100%;
        padding: 20px;
        /* Add padding to give some spacing */
        text-align: center;
        /* Center text inside the footer */
       
    }



    a {
        text-decoration: none;
    }

    .card-img-top {
        object-fit: cover;
        width: 100%;
        height: auto;
    }

    .card-body {
        padding: 1rem;
        background-color: rgba(255, 255, 255, 0.8);
        /* White with 80% opacity */
    }

    .card-title {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .card-text {
        font-size: 0.875rem;
    }

    .fas {
        margin-right: 0.5rem;
    }

    /* bhroom part */
    .bhroom-p p {
        margin: 0px;
    }

    .display-feedback {
        max-height: 260px;
        overflow: hidden;
        overflow-y: scroll;
        scrollbar-width: thin;
        scroll-behavior: smooth;
    }

    .display-feedback .feedback-content {
        display: flex;
        gap: 1rem;
    }

    .display-feedback .feedback-content .circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .display-feedback .feedback-content .circle h5 {
        margin: 0px;
        color: white
    }

    .display-feedback .text-content .name-text {
        margin: 1px;

    }

    .display-feedback .text-content .message-text p {
        font-size: 12px;
        margin: 0px
    }

    /*MALE AND FEMALE ROOM SECTION */

    .room-text p {
        margin-bottom: 10px;
    }

    /* book.php img-scroller */
    .img-scoller {
        max-height: 690px;
        overflow: hidden;
        overflow-y: scroll;
        scrollbar-width: thin;
        background-color: #cccccc;
    }

    .img-wrapper {
        background-color: rgba(255, 255, 255, 0.5);
    }

    /* Container for the column */
    .back-button {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        width: 35px;
        padding: 8px 10px;
        background-color: #ffffff;
        border-radius: 50%;
        color: #08614E;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: #08614E;
        color: white;
    }

    .col-lg-7 {
        padding: 20px;
    }

    /* Heading style */
    h5 {
        color: #08614E;
        margin-bottom: 20px;
    }

    /* Scroller container styling */
    .img-scoller {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        /* Space between images */
        padding: 15px;
        background-color: rgba(255, 255, 255, 0.50);
        /* Light transparent background */
        border-radius: 8px;
        /* Rounded corners */
    }

    /* Individual image wrapper styling */
    .img-wrapper {
        position: relative;
        /* For positioning the text over the image if needed */
        overflow: hidden;
        height: 200px;
        border-radius: 8px;
        border: 1px solid #08614E;
        /* Rounded corners for images */
    }

    /* Image caption styling */
    .img-wrapper h5 {
        position: absolute;
        bottom: 10px;
        left: 10px;
        color: rgba(255, 255, 255, 0.9);
        /* Nearly white text with slight transparency */
        /* background-color: rgba(0, 0, 0, 0.75); */
        /* Semi-transparent black background for text readability */
        background-color: #08614E;
        padding: 5px 10px;
        border-radius: 5px;
        margin: 0;
    }

    /* Additional shadow effect */
    .shadow {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Subtle shadow effect */
    }



    /* rating section */

    .star-light {
        color: #dcdcdc;
        /* Light grey for unselected stars */
        font-size: 30px;
        transition: color 0.3s ease;
        /* Smooth transition for hover effects */
        cursor: pointer;
        /* Makes stars clickable */
    }

    .star-selected {
        color: #ffc107;
        /* Yellow color for selected stars */
    }

    #reviewModal .form-control {
        border-radius: 10px;
        /* Rounded corners for inputs */
        border: 1px solid #ced4da;
        /* Border color */
    }

    #reviewModal .btn-success {
        background-color: #28a745;
        /* Green background */
        border-color: #28a745;
        /* Green border */
        padding: 10px 20px;
        /* Padding for better button appearance */
        font-size: 16px;
        /* Larger font size for button */
        border-radius: 5px;
        /* Rounded button corners */
    }

    #reviewModal .btn-success:hover {
        background-color: #218838;
        /* Darker green on hover */
        border-color: #1e7e34;
        /* Darker border on hover */
    }

    /* register and Login form */
    .form-container {
        box-shadow: none;
    }

    /* for map style */
    .map-container {
        opacity: 0;
        height: 0;
        overflow: hidden;
        transition: opacity 0.5s ease, height 0.5s ease;
    }

    .map-container.show {
        opacity: 1;
        height: 400px;
        /* Set to match iframe height */
    }


    .input-group-text {
        height: 100%;
        /* Makes the icon span the entire height of the input */
        line-height: 1.5;
        /* Aligns the icon vertically */
        padding: 0.375rem 0.75rem;
        /* Ensures padding is consistent with the form-control */
    }

    .form-control {
        height: calc(2.25rem + 2px);
        /* Matches the height of the input-group-text */
    }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>