<?php
require_once 'config/db.php';
require_once 'includes/header.php';

// Include PHPMailer
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Save token in the database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send Reset Email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Change this if using another SMTP provider
            $mail->SMTPAuth = true;
            $mail->Username = 'francis.b.kaz@gmail.com'; 
            $mail->Password = 'kemuvhdsvjufdztl';   
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email Settings
            $mail->setFrom('your-email@gmail.com', 'Your Website Name');
            $mail->addAddress($email); // Send to any email address
            $mail->Subject = 'Password Reset Request';
            $reset_link = "http://yourwebsite.com/new-password.php?token=" . $token;
            $mail->Body = "Click the following link to reset your password: $reset_link";

            // Send Email
            $mail->send();
            echo "<div class='alert alert-success'>A reset link has been sent to your email.</div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Email could not be sent. Error: {$mail->ErrorInfo}</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Email not found.</div>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark text-center">
                <h2>Reset Password</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
