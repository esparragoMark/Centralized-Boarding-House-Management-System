<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- FONT AWESOOME -->
    <script src="https://kit.fontawesome.com/85f2b68f45.js" crossorigin="anonymous"></script>

    <!-- CSS STYLE -->
    <link rel="stylesheet" href="../assets/css/styles.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

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

    body{
        font-family: 'Poppins', sans-serif; /* Set the new font */
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
        /* background-image: url('../assets/images/Untitled design.png'); */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* footer */
    .footer{
        position: sticky;
        bottom: 0;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.1);
        /* Semi-transparent white */
        backdrop-filter: blur(10px);
        /* Blur effect */
        -webkit-backdrop-filter: blur(10px);
        /* Safari support */
    }


    /* college.php file */
    .college-text {
        font-size: 1.1rem;
        color: #08614E;
    }

    .design-table {
        height: 430px;
        overflow: hidden;
        overflow-y: scroll;
        scrollbar-width: none;
        border-radius: 5px;
        border: 1px solid #CCCCCC;
        background-color: #CCCCCC;
    }

    /* dashboard icon  */

    .custom_text_dash {
        color: var(--white);
        background-color: var(--white);
        padding: .5rem 0;
        transition: all .2s ease-in-out;
    }

    .custom_text_dash:hover {
        transform: scale(1.02);
    }
    </style>
    <title>Dashboard Draft</title>
</head>

<body>
    <?php include('sidebar.php') ?>
    <?php include('navbar.php') ?>