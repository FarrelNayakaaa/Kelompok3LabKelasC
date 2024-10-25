<?php
session_start();
require __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $detail_id = $_POST['detail_id'];
    $is_complete = isset($_POST['is_complete']) ? 1 : 0;

    $stmt = $pdo->prepare('UPDATE detaillists SET is_complete = ? WHERE id = ?');
    $stmt->execute([$is_complete, $detail_id]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
