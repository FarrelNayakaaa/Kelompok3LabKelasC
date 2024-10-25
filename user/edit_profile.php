<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$error_message = '';

// Ambil username dan profile picture untuk ditampilkan di navbar
$stmt = $pdo->prepare('SELECT username, profile_picture FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$logged_user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = !empty($_POST['password']) ? $_POST['password'] : null;
    $profile_picture = null;

    // Ambil password saat ini dari database
    $stmt = $pdo->prepare('SELECT password, profile_picture FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Proses upload file gambar jika ada
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "../uploads/";

        // Pastikan direktori ada, jika tidak buat direktori
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file adalah gambar
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check === false) {
            $error_message = "File is not an image.";
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            $error_message = "Only JPG, JPEG, and PNG files are allowed.";
        } elseif ($_FILES["profile_picture"]["size"] > 500000) {
            $error_message = "File is too large.";
        } else {
            // Cek apakah file berhasil diunggah
            if (is_uploaded_file($_FILES['profile_picture']['tmp_name'])) {
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                    $profile_picture = basename($_FILES["profile_picture"]["name"]);
                } else {
                    $error_message = "Error moving the uploaded file.";
                }
            } else {
                $error_message = "Upload failed. Please try again.";
            }
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $profile_picture = $user['profile_picture'];
    }

    // Cek apakah user ingin mengubah password
    if ($new_password) {
        if (empty($current_password)) {
            $error_message = "You need to provide your current password to set a new password.";
        } elseif (!password_verify($current_password, $user['password'])) {
            $error_message = "Current password is incorrect.";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        }
    } else {
        $hashed_password = $user['password'];
    }

    if (empty($error_message)) {
        // Update profil user jika tidak ada error
        $sql = 'UPDATE users SET username = ?, email = ?, password = ?, profile_picture = ? WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $hashed_password, $profile_picture, $user_id]);

        header('Location: profile.php');
        exit;
    }
}

// Mengambil data pengguna untuk ditampilkan di form
$stmt = $pdo->prepare('SELECT username, email, profile_picture FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #b2f7b6, #ffffff); /* Gradient dari hijau muda ke putih */
            color: #000000;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hh {
            border: 2px solid #8B4513;
            padding: 40px;
            width: 500px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
            margin: 100px auto; /* Pusatkan kontainer dan tambahkan margin atas/bawah */
        }

        h2 {
            color: white;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] { /* Tambahkan input file */
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            outline: none;
            background-color: #f0f0f0;
            color: #000000;
            border-bottom: 1px solid #8B4513; /* Coklat untuk underline */
        }

        button {
            padding: 12px;
            background-color: transparent;
            color: #8B4513; /* Coklat untuk outline tombol */
            border: 2px solid #8B4513;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #8B4513;
            color: #ffffff;
        }

        #error-message {
            color: red;
            margin-bottom: 20px;
        }

        header, footer {
            width: 100%;
            position: fixed;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        header {
            top: 0;
        }

        footer {
            bottom: 0;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .video-background video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?> 

    <div class="video-background">
        <video autoplay loop muted>
            <source src="../assets/videos/Starry Night Time-Lapse 4K UHD | Free Stock Video - BULLAKI (1080p, h264, youtube).mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="hh">
        <h2>Edit Profile</h2>

        <!-- Area untuk notifikasi error -->
        <?php if (!empty($error_message)): ?>
            <div id="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data"> 
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            
            <input type="password" name="current_password" placeholder="Current Password (required to change password)">
            
            <input type="password" name="password" placeholder="New Password (optional)">
            
            <input type="file" name="profile_picture">

            <button type="submit">Update Profile</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?> 
</body>
</html>
