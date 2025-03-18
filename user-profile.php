<?php
require_once 'config/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Get user data
$user = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        } else {
            echo "<script>alert('User not found. Please log in again.'); window.location='logout.php';</script>";
        }
        $stmt->close();
    }
}

// Redirect if user data is not available
if (!$user) {
    header("Location: login.php");
    exit();
}

// Handle profile deletion
if (isset($_POST['delete_profile'])) {
    if ($user['profile_picture'] && file_exists("uploads/" . $user['profile_picture'])) {
        unlink("uploads/" . $user['profile_picture']);
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }

    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .dashboard-container {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .navbar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand, .nav-link {
            color: white !important;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .welcome-title {
            font-size: 2.8rem;
            color: #333;
            margin-bottom: 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .welcome-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
        }

        .profile-picture {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #667eea;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .profile-picture:hover {
            transform: scale(1.03);
        }

        .profile-info {
            text-align: center;
            margin-top: 20px;
        }

        .profile-username {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 5px;
        }

        .profile-email {
            font-size: 1rem;
            color: #6c757d;
        }

        .profile-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #4dabf7 0%, #28a7de 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(77, 171, 247, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-edit:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(77, 171, 247, 0.6);
        }

        .btn-delete {
            background: #dc3545;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-delete:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.6);
        }

        .info-tiles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .info-tile {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-tile:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .info-tile h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .info-tile p {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .info-tile .btn {
            position: absolute;
            bottom: 30px;
            right: 30px;
            padding: 8px 15px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 0.9rem;
            background-color: #f8f9fa;
            margin-top: auto;
        }

        .delete-profile-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-profile-btn:hover {
            background: #bb2d3b;
        }
    </style>
</head>
<body>
    <!-- <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">User Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="user-profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit-profile.php">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> -->

    <div class="dashboard-container">
        <section class="welcome-section">
            <h2 class="welcome-title">Welcome back, <?= htmlspecialchars($user['username']) ?>!</h2>
            <p class="welcome-subtitle">Here's your personalized dashboard where you can manage your account and explore the system.</p>
        </section>

        <div class="profile-container">
            <?php if (!empty($user['profile_picture']) && file_exists("uploads/" . $user['profile_picture'])): ?>
                <img src="uploads/<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" class="profile-picture">
            <?php else: ?>
                <div class="profile-picture placeholder" style="background-color: #f8f9fa; display: flex; justify-content: center; align-items: center;">
                    <span style="font-size: 80px; color: #667eea;"><?= strtoupper(substr($user['username'], 0, 1)) ?></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="profile-info">
            <h3 class="profile-username"><?= htmlspecialchars($user['username']) ?></h3>
            <p class="profile-email"><?= htmlspecialchars($user['email']) ?></p>
        </div>

        <div class="profile-actions">
            <a href="edit-profile.php" class="btn btn-edit">Edit Profile</a>
            <form method="POST" onsubmit="return confirm('Are you sure you want to permanently delete your profile? This action cannot be undone.');">
    <button type="submit" name="delete_profile" class="btn btn-delete">Delete Profile</button>
</form>

        </div>

        <div class="info-tiles">
            <div class="info-tile">
                <h3>Account Management</h3>
                <p>Manage your account settings, view your registration details, and even delete your account permanently from the system.</p>
                <a href="edit-profile.php" class="btn btn-primary">Manage Account</a>
            </div>
            <div class="info-tile">
                <h3>Security Best Practices</h3>
                <p>Always use a strong, unique password and log out when using public devices.We recommend enabling two-factor authentication for added security. Dont share your login details with anyone </p>
                <a href="reset-password.php" class="btn btn-primary">Change Password</a>
            </div>
            <div class="info-tile">
                <h3>Dashboard</h3>
                <p>Click below to return to the main dashboard.</p>
                <a href="index.php" class="btn btn-primary">Go to Dashboard</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y'); ?> Gemnet💎 Management System</p>
        </div>
    </footer>

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to permanently delete your profile? This action cannot be undone.')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>

    <form id="delete-form" method="POST" style="display: none;">
        <input type="submit" name="delete_profile" value="Delete">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>