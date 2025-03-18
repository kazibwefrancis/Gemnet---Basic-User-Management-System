<?php
require_once 'config/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Gemnet💎 Management System</title>
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

        .about-container {
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

        .team-section {
            text-align: center;
            margin-bottom: 50px;
        }

        .team-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .team-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 40px;
        }

        .team-photo {
            width: 100%;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            transition: transform 0.3s ease;
        }

        .team-photo:hover {
            transform: scale(1.02);
        }

        .team-members {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-bottom: 50px;
        }

        .team-member {
            text-align: center;
            width: 200px;
        }

        .member-name {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 5px;
        }

        .member-role {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 0.9rem;
            background-color: #f8f9fa;
            margin-top: auto;
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
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="user-profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="edit-profile.php">Edit Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav> -->

    <div class="about-container">
        <section class="team-section">
            <h2 class="team-title">Our Development Team</h2>
            <p class="team-subtitle">Meet the talented individuals behind the User Management System</p>
            
            <?php if (file_exists("images/team.jpg")): ?>
                <img src="images/team.jpg" alt="Team Photo" class="team-photo">
            <?php else: ?>
                <div class="team-photo placeholder" style="height: 400px; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center;">
                    <span style="font-size: 24px; color: #667eea;">Team Photo Placeholder</span>
                </div>
            <?php endif; ?>
        </section>

        <div class="team-members">
            <div class="team-member">
                <h3 class="member-name">Bantrobusa Kazibwe </h3>
                <p class="member-role">23/U/07416/EVE</p>
            </div>
            <div class="team-member">
                <h3 class="member-name">Jemimah Tendo</h3>
                <p class="member-role">23/U/17920/PS</p>
            </div>
            <div class="team-member">
                <h3 class="member-name">Jim Isaac Ainemani</h3>
                <p class="member-role">23/U/23830/EVE</p>
            </div>
            <div class="team-member">
                <h3 class="member-name">Abisha Baingana</h3>
                <p class="member-role">23/U/07328/PS</p>
            </div>
            <div class="team-member">
                <h3 class="member-name">Tusime Mable</h3>
                <p class="member-role">23/U/1494</p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y'); ?> Gemnet💎 Management System</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>