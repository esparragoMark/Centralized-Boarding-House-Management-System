<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- FONT AWESOOME -->
    <script src="https://kit.fontawesome.com/85f2b68f45.js" crossorigin="anonymous"></script>

    <!-- CSS STYLE -->
    <link rel="stylesheet" href="../assets/css/styles.css">

    <!-- BOOTSTRAP DATATABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />

    <!-- DROPIFY -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/css/dropify.min.css">

    <!-- SWEET ALERT -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="icon" type="image/png" href="../../favicon.png">

    <style>
    /* THIS  DESIGN IS FOR THE VIEWROOMDETAILS */
    body {
        background-color: #f8f9fa;
    }

    main {
        height: 100%;
        /* overflow: hidden; */
        overflow-y: scroll;
        scrollbar-width: none;
    }

    .main {
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
        background-image: url('../../background.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;

    }


    .custom-card {
        background-color: #fff;
        border-radius: 10px;
    }

    .custom-card-body {
        padding: 20px;
    }

    /* Carousel Image Styling */
    .carousel-inner img.room-image {
        height: 400px;
        /* Increased height for better visibility */
        object-fit: cover;
        border-radius: 8px;
    }

    /* Room Details Styling */
    .custom-room-details {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
    }

    /* Bed Item Styling */
    .custom-bed-item {
        background-color: #f8f9fa;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .custom-bed-image img.bed-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* Badge Styling */
    .badge {
        padding: 5px 10px;
        font-size: 0.85rem;
        border-radius: 5px;
    }

    /* Back Button Styling */
    .btn-light {
        border: 1px solid #ddd;
    }

    /* Manage Room Images Section */
    .manage-images .position-relative {
        position: relative;
    }

    .manage-images img.img-fluid {
        border-radius: 8px;
        height: 150px;
        object-fit: cover;
    }

    /* Delete Button Styling */
    .delete-image-btn {
        background-color: none;
        border: none;
        color: red;
        border-radius: 50%;
        padding: 5px 8px;
        cursor: pointer;
    }

    .delete-image-btn:hover {
        background-color: rgba(255, 0, 0, 0.9);
        color: white
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {

        .custom-room-info,
        .custom-bed-info {
            margin-bottom: 20px;
        }

        .custom-bed-item {
            flex-direction: column;
            align-items: start;
        }

        .custom-bed-image {
            margin-bottom: 10px;
        }

        .carousel-inner img.room-image {
            height: 250px;
            /* Adjust height for smaller screens */
        }

        .manage-images img.img-fluid {
            height: 120px;
        }
    }

    /* ############################################################################ */
    /* UI Improve desing */
    .index_card {
        background-color: white;
        color: #08614E;
        border: 1px solid #08614E;

    }

    .custom_text_dash h4,
    .custom_text_dash span {
        color: #08614E;

    }


    .view-tenant-info-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        /* White background for the card */
    }

    .view-tenant-info-card-body {
        padding: 2rem;
    }

    .view-tenant-info-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .back-btn {
        background-color: transparent;
        border: none;
        color: #08614E;
        font-size: 1.5rem;
        cursor: pointer;
        margin-right: 1rem;
    }

    h4 {
        color: #08614E;
        /* Heading color */
    }

    .view-tenant-info-details {
        padding: 1rem;
    }

    .tenant-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .tenant-info-label {
        color: #08614E;
        /* Label color */
        font-weight: bold;
    }

    .tenant-info-value {
        margin: 0;
    }

    hr {
        border-top: 1px solid #08614E;
        /* Change hr color to match the theme */
        margin: 1rem 0;
    }

    @media (max-width: 768px) {
        .view-tenant-info-card-body {
            padding: 1rem;
            /* Smaller padding on mobile */
        }

        .view-tenant-info-card {
            margin-bottom: 1rem;
            /* Reduce margin on mobile */
        }

        .tenant-info-row {
            flex-direction: column;
            /* Stack elements vertically */
            align-items: flex-start;
            /* Align items to the left */
        }

        .tenant-info-label {
            margin-bottom: 0.5rem;
            /* Add spacing between label and value */
        }

        .tenant-info-value {
            margin-left: 0;
            /* Remove margin-left to avoid extra spacing */
            color: #333;
            /* Change value color for better readability */
        }
    }
    </style>


    <title>Landlord Panel</title>
</head>

<body onload="getLocation();">
    <?php include('sidebar.php') ?>
    <?php include('navbar.php') ?>