<?php
session_start();
require __DIR__ . '/../config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$list_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($list_id) {
    $stmt = $pdo->prepare('UPDATE todolists SET completion_status = "incomplete" WHERE id = ? AND user_id = ?');
    $stmt->execute([$list_id, $_SESSION['user_id']]);

    header('Location: dashboard.php');
} else {
    echo "Invalid Task ID";
}
exit;
?>