<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT username, email, profile_picture FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #b2f7b6, #ffffff); 
            color: #000000;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .iyah {
            color: white;
            padding: 40px;
            width: 500px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
            margin-top: 100px; 
            margin-bottom: 50px; 
            border: 2px solid #8B4513;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        h1 {
            color: white;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .profile-btn {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border: 2px solid #8B4513;
            display: inline-block;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .profile-btn:hover {
            background-color: #8B4513;
            color: #ffffff;
        }

        header a {
            border: none;
            padding: 0;
            text-decoration: none;
            color: inherit;
        }

        header, footer {
            width: 100%;
            position: fixed;
            left: 0;
            right: 0;
            z-index: 1000;
            background: none;
            box-shadow: none;
            border: none;
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

    <div class="iyah">
        <?php if (!empty($user['profile_picture'])): ?>
            <img src="../uploads/<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" class="profile-picture">
        <?php endif; ?>
        <h1>Username: <?= htmlspecialchars($user['username']) ?></h1>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <a href="edit_profile.php" class="profile-btn">Edit Profile</a>
    </div>

    <?php include '../includes/footer.php'; ?> 
</body>
</html>
