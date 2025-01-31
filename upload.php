<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES['files']['name'] as $key => $name) {
        $tmpName = $_FILES['files']['tmp_name'][$key];
        $uploadFile = $uploadDir . basename($name);
        move_uploaded_file($tmpName, $uploadFile);
    }

    echo "Files uploaded successfully!";
} else {
    http_response_code(405);
    echo "Method not allowed";
}
?>
