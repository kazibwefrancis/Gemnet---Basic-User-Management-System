<?php
require_once 'config/auth.php';
requireLogin();
require_once 'includes/functions.php';

// Fetch Current User Data
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username, $email, $profile_picture);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = sanitize($_POST['username']);
    $new_email = sanitize($_POST['email']);
    
    // Profile Picture Upload
    if (!empty($_FILES["profile_picture"]["name"])) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES["profile_picture"]["name"]);
        $file_tmp = $_FILES["profile_picture"]["tmp_name"];
        $file_size = $_FILES["profile_picture"]["size"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png'];

        if (!in_array($file_ext, $allowed_types) || $file_size > 5 * 1024 * 1024) {
            die("Invalid file type or file too large.");
        }

        // Generate Unique Filename
        $new_file_path = $target_dir . uniqid() . "." . $file_ext;

        // Delete Old Profile Picture
        if (file_exists($profile_picture)) {
            unlink($profile_picture);
        }

        move_uploaded_file($file_tmp, $new_file_path);
    } else {
        $new_file_path = $profile_picture;
    }

    // Update User Data
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, profile_picture = ? WHERE id = ?");
    $stmt->bind_param("sssi", $new_username, $new_email, $new_file_path, $user_id);

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
}

require_once 'includes/header.php';
?>

<h2>Edit Profile</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="username" value="<?php echo $username; ?>" required placeholder="Username">
    <input type="email" name="email" value="<?php echo $email; ?>" required placeholder="Email">
    <input type="file" name="profile_picture">
    <button type="submit">Update Profile</button>
</form>

<?php require_once 'includes/footer.php'; ?>
