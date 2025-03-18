<?php
session_start();
require_once 'config/db.php';
require_once 'includes/functions.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;

        // Debugging output before redirection
        echo "Session set. Redirecting...";
        header("Refresh:2; url=user-profile.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
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

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
            position: relative;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .login-card h2 {
            text-align: center;
            color: #000000;
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

        .form-check {
            margin-bottom: 20px;
        }

        .text-center {
            margin-top: 20px;
        }

        .text-center a {
            color: #000000
            ;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .text-center a:hover {
            color: #e0e0e0;
            text-decoration: underline;
        }

        .alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            font-size: 1rem;
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

        .back-button-container {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 8px 15px;
            border-radius: 50px;
            color: white;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="back-button-container">
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
        <h2>Login</h2>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Enter your password">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="text-center">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?= date('Y'); ?> Gemnet 💎 Management System</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
