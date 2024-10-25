<?php
session_start();
require __DIR__ . '/../config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $due_date = $_POST['due_date']; 
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare('INSERT INTO todolists (user_id, title, due_date) VALUES (?, ?, ?)');
    $stmt->execute([$user_id, $title, $due_date]);

    header('Location: dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create To-Do List</title>
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
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            width: 300px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 50px auto; 
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
        input[type="date"] {
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

        header, footer {
            width: 100%;
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

    <div class="container">
        <h2>Create a New To-Do List</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="List Title" required>
            <input type="date" name="due_date" placeholder="Due Date" required>
            <button type="submit">Create</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?> 
</body>
</html>
