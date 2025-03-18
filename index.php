<?php
require_once 'config/auth.php';
require_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - User Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hero-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 50px 20px;
            box-sizing: border-box;
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .hero-card:hover {
            transform: translateY(-5px);
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: #212529;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.05);
            animation: fadeIn 1.5s ease-in-out;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #6c757d;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeIn 2s ease-in-out;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .action-btn {
            font-size: 1rem;
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4dabf7 0%, #28a7de 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(77, 171, 247, 0.4);
        }

        .btn-outline-light {
            background: transparent;
            color: #212529;
            border: 2px solid white;
        }

        .btn-outline-light:hover {
            background: white;
            color: #343a40;
            transform: translateY(-3px);
        }

        .features-section {
            padding: 40px 20px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 40px;
            color: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: white;
        }

        .feature-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: white;
        }

        .feature-text {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer {
            background: linear-gradient(135deg, #343a40 0%, #212529 100%);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: auto;
        }

        .footer a {
            color: #4dabf7;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }
            
            .action-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <section class="hero-section">
        <div class="hero-card">
            <h1 class="hero-title">Welcome to Gemnet User Management System</h1>
            <p class="hero-subtitle">A modern, secure platform for managing user accounts with PHP and MySQL. Built with best practices and user experience in mind.</p>
            
            <div class="action-buttons">
                <?php if (!isLoggedIn()): ?>
                    <a href="register.php" class="action-btn btn btn-primary">Get Started</a>
                    <a href="login.php" class="action-btn btn btn-outline-light">Login</a>
                <?php else: ?>
                    <!-- If logged in, show the "Go to User Profile" button -->
                    <a href="user-profile.php" class="action-btn btn btn-primary">Go to User Profile</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="features-container">
            <h2 class="features-title">Why Choose Our System?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Secure Authentication</h3>
                    <p class="feature-text">Industry-standard security practices including password hashing and session management.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h3 class="feature-title">Profile Management</h3>
                    <p class="feature-text">Easily update user profiles and manage account information with our intuitive interface.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h3 class="feature-title">Account Deletion</h3>
                    <p class="feature-text">Safe and complete account removal with data deletion confirmation.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <h3 class="feature-title">Profile Pictures</h3>
                    <p class="feature-text">Upload custom profile pictures with size and format validation.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>© <?= date('Y'); ?> Gemnet💎 Management System. <a href="about.php">About Us</a></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
