<?php
ob_start();
session_start();
include("config/config.php");

// Set the response header to JSON
header('Content-Type: application/json');

// Check if the form is submitted
if (isset($_POST['rating_data'])) {
    // Sanitize and escape input data
    $rating_data = mysqli_real_escape_string($con, $_POST["rating_data"]);
    $user_name = mysqli_real_escape_string($con, $_POST["user_name"]);
    $bh_id = mysqli_real_escape_string($con, $_POST["bh_id"]);
    $user_review = mysqli_real_escape_string($con, $_POST["user_review"]);
    $time = date('H:i:s');

    // Check if user is logged in
    if (empty($user_name)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please log in to submit a review.'
        ]);
        exit;
    }

    // Prepare SQL query
    $addRating = "INSERT INTO rating (rating_count, user_name, user_review, bh_id, time) 
                  VALUES ('$rating_data', '$user_name', '$user_review', '$bh_id', '$time')";
    
    $addRating_run = mysqli_query($con, $addRating);

    if ($addRating_run) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Review submitted successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to submit review.'
        ]);
    }

    mysqli_close($con);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request.',
        'received_data' => $_POST
    ]);
}
ob_end_flush();
?>
