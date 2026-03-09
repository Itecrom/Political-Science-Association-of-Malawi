<?php
// Set upload directory
$uploadDir = "uploads/ckeditor/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Get file from request
if (isset($_FILES['upload']) && $_FILES['upload']['error'] === 0) {
    $file = $_FILES['upload'];
    $filename = time() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filepath = $uploadDir . $filename;

    // Validate image type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        $funcNum = $_GET['CKEditorFuncNum'];
        $message = 'Only JPG, PNG, and GIF images are allowed.';
        echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '$message');</script>";
        exit;
    }

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        $funcNum = $_GET['CKEditorFuncNum'];
        $url = $filepath;
        $message = 'Image uploaded successfully';
        echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    } else {
        $funcNum = $_GET['CKEditorFuncNum'];
        $message = 'Failed to upload image.';
        echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '$message');</script>";
    }
} else {
    $funcNum = $_GET['CKEditorFuncNum'] ?? 1;
    $message = 'No file uploaded or upload error.';
    echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '$message');</script>";
}
?>
