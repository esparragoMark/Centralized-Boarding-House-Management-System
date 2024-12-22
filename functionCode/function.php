<?php

// File upload handling function For single file image
function uploadFile($fileKey, $uploadDir) {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$fileKey]['tmp_name'];
        $fileName = $_FILES[$fileKey]['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Generate a unique file name using timestamp
        $newFileName = time() . '_' . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $dest_path = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            return $newFileName;
        } else {
            return false;
        }
    }
    return false;
}

// Modified file upload handling function for multiple files
function multiUploadFile($fileKey, $key, $uploadDir) {
    if (isset($_FILES[$fileKey]['name'][$key]) && $_FILES[$fileKey]['error'][$key] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$fileKey]['tmp_name'][$key];
        $fileName = $_FILES[$fileKey]['name'][$key];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Generate a unique file name using timestamp
        $newFileName = time() . '_' . $fileName;

        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $dest_path = $uploadDir . $newFileName;

        // Move the file to the specified directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            return $newFileName;
        } else {
            return false;
        }
    }
    return false;
}



?>