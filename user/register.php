<?php
session_start();
require __DIR__ . '/../config.php'; 

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ? OR username = ?');
    $stmt->execute([$email, $username]);
    $existing_user_count = $stmt->fetchColumn();

    if ($existing_user_count > 0) {
        $error_message = 'Email or username already exists.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$username, $email, $password]);

        $_SESSION['register_success'] = "Registration successful! You can now log in.";
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #b2f7b6, #ffffff); 
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            width: 300px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #000000;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            outline: none;
            background-color: #f0f0f0;
            color: #000000;
            border-bottom: 1px solid #8B4513; 
        }

        button {
            padding: 10px;
            background-color: transparent;
            color: #8B4513; 
            border: 2px solid #8B4513;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #8B4513;
            color: #ffffff;
        }

        p {
            margin-top: 10px;
            color: #8B4513;
        }

        a {
            color: #8B4513;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            margin-bottom: 15px;
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


    <div class="video-background">
            <video autoplay loop muted>
                <source src="../assets/videos/Starry Night Time-Lapse 4K UHD | Free Stock Video - BULLAKI (1080p, h264, youtube).mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

    <div class="container">
        <h2>Register</h2>

        <?php if (!empty($error_message)): ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Username" value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
