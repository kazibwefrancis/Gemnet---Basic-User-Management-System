<?php
require_once 'config/db.php';
require_once 'includes/functions.php';
// require_once 'includes/header.php';

// Ensure uploads directory exists
$target_dir = "uploads/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);  // Create directory if it doesn't exist
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // File upload handling
    if (isset($_FILES["profile_picture"])) {
        $file_name = basename($_FILES["profile_picture"]["name"]);
        $file_tmp = $_FILES["profile_picture"]["tmp_name"];
        $file_size = $_FILES["profile_picture"]["size"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png'];

        // Validate file type and size
        if (!in_array($file_ext, $allowed_types)) {
            die("Invalid file type. Only JPG, JPEG, and PNG files are allowed.");
        }
        if ($file_size > 5 * 1024 * 1024) {
            die("File is too large. Maximum allowed size is 5MB.");
        }

        // Unique file name to avoid overwriting
        $file_path = $target_dir . uniqid() . "." . $file_ext;

        // Move the uploaded file
        if (move_uploaded_file($file_tmp, $file_path)) {
            // File successfully uploaded
        } else {
            die("Error: Unable to upload file.");
        }
    } else {
        die("Error: No file uploaded.");
    }

    // Prepare and execute the database insert
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, profile_picture) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $file_path);

    if ($stmt->execute()) {
        $success_message = "<div class='alert alert-success'>Registration successful! You can now <a href='login.php' class='alert-link'>login</a>.</div>";
    } else {
        $error_message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
        }

        .register-card h2 {
            text-align: center;
            color: #000000; /* Changed to black */
            margin-bottom: 30px;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 50px;
            padding: 15px 25px;
            font-size: 1rem;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.6);
            border-color: transparent;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px;
            border-radius: 50px;
            width: 100%;
            font-size: 1.1rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .custom-file-input {
            padding: 15px 25px;
            border-radius: 50px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .custom-file-input:hover {
            border-color: #c0c0c0;
        }

        .alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            font-size: 1rem;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .footer {
            position: fixed;
            bottom: 20px;
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="register-card">
        <div class="back-button-container">
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
        <h2>Register</h2>

        <?php if (isset($success_message)) { echo $success_message; } ?>
        <?php if (isset($error_message)) { echo $error_message; } ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" name="username" class="form-control" required placeholder="Username">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" required placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" required placeholder="Password">
            </div>
            <div class="form-group">
                <input type="file" name="profile_picture" class="form-control custom-file-input" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <div class="footer">
        <p>&copy; <?= date('Y'); ?> Gemnet 💎 Management System</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>