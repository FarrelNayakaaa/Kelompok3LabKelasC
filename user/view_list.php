<?php
session_start();
require __DIR__ . '/../config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$list_id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM todolists WHERE id = ? AND user_id = ?');
$stmt->execute([$list_id, $_SESSION['user_id']]);
$list = $stmt->fetch();

if (!$list) {
    echo "To-Do List tidak ditemukan atau Anda tidak memiliki akses.";
    exit;
}

$detail_stmt = $pdo->prepare('SELECT * FROM detaillists WHERE todolist_id = ?');
$detail_stmt->execute([$list_id]);
$details = $detail_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View To-Do List</title>
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
            min-height: 100vh;
            margin-bottom: 20px;
        }

        .bouxx {
            background-color: rgba(255, 255, 255, 0.3);
            padding: 20px;
            width: 500px;
            margin: 50px auto;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
            border: 2px solid #8B4513;
        }


        h2 {
            color: #ffffff;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #8B4513;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        button {
            padding: 10px;
            background-color: transparent;
            color: #ffffff; 
            border: 2px solid #8B4513;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #8B4513;
            color: #ffffff;
        }

        input[type="text"], input[type="date"], input[type="color"] {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            background-color: #f0f0f0;
            color: #000000;
            border-bottom: 1px solid #8B4513; 
            width: 100%;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #8B4513;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        input[type="checkbox"] {
            transform: scale(1.2);
            cursor: pointer;
        }

        td.checked {
            text-decoration: line-through;
        }

        h3 {
            margin-bottom: 30px;
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

        p {
            margin-bottom: 10px;
        }

        th {
            color: black;
        }

        td {
            color: black;
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

    <div class="bouxx">
        <h2><?= htmlspecialchars($list['title']) ?></h2>
        <ul>
            <li>Due Date: <?= htmlspecialchars($list['due_date']) ?></li> 
        </ul>

        <h3>Add Detail to This List</h3>
        <form method="POST" action="add_detail.php">
            <input type="hidden" name="todolist_id" value="<?= htmlspecialchars($list['id']) ?>">
            <input type="text" name="detail_title" placeholder="Detail Title" required>
            <input type="date" name="detail_due_date" placeholder="Due Date" required>

            <label for="label_color">Select Label Color:</label>
            <input type="color" name="label_color" id="label_color">
            
            <button type="submit">Add Detail</button>
        </form>

        <h3>Detail List</h3>
        <table>
            <thead>
                <tr>
                    <th>Detail Title</th>
                    <th>Due Date</th>
                    <th>Complete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $detail): ?>
                    <tr>
                        <td class="<?= $detail['is_complete'] ? 'checked' : '' ?>">
                            <?= htmlspecialchars($detail['title']) ?>
                        </td>
                        <td><?= htmlspecialchars($detail['due_date']) ?></td>
                        <td>
                            <form method="POST" action="update_detail.php">
                                <input type="hidden" name="detail_id" value="<?= $detail['id'] ?>">
                                <input type="checkbox" name="is_complete" <?= $detail['is_complete'] ? 'checked' : '' ?> onchange="this.form.submit()">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>

    <?php include '../includes/footer.php'; ?> 
</body>
</html>
