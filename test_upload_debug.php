<?php

/**
 * Debug script untuk test upload functionality
 * Jalankan di browser: /test_upload_debug.php
 */

// Hanya untuk testing - jangan digunakan di production
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
    echo "<h2>Upload Test Results:</h2>";
    
    echo "<h3>$_FILES data:</h3>";
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    
    echo "<h3>$_POST data:</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    if (isset($_FILES['test_file']) && $_FILES['test_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/uploads/test/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = time() . '_' . $_FILES['test_file']['name'];
        $uploadPath = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['test_file']['tmp_name'], $uploadPath)) {
            echo "<p style='color: green;'>✅ File uploaded successfully: $uploadPath</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to move uploaded file</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ No file uploaded or upload error</p>";
        if (isset($_FILES['test_file'])) {
            echo "<p>Error code: " . $_FILES['test_file']['error'] . "</p>";
        }
    }
    
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Debug Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .form-group { margin: 20px 0; }
        input[type="file"] { padding: 10px; border: 1px solid #ccc; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Upload Debug Test</h1>
    <p>Test form untuk debug upload functionality</p>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Select File:</label><br>
            <input type="file" name="test_file" accept="image/*" required>
        </div>
        
        <div class="form-group">
            <label>Test Field:</label><br>
            <input type="text" name="test_field" value="test_value">
        </div>
        
        <div class="form-group">
            <button type="submit">Upload Test</button>
        </div>
    </form>
    
    <hr>
    <h3>PHP Configuration:</h3>
    <ul>
        <li>upload_max_filesize: <?php echo ini_get('upload_max_filesize'); ?></li>
        <li>post_max_size: <?php echo ini_get('post_max_size'); ?></li>
        <li>max_file_uploads: <?php echo ini_get('max_file_uploads'); ?></li>
        <li>file_uploads: <?php echo ini_get('file_uploads') ? 'Enabled' : 'Disabled'; ?></li>
    </ul>
</body>
</html>