<?php
session_start();
require __DIR__ . '/../config.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: user/login.php');
    exit;
}

$list_id = $_GET['id'];
$stmt = $pdo->prepare('DELETE FROM todolists WHERE id = ? AND user_id = ?');
$stmt->execute([$list_id, $_SESSION['user_id']]);

header('Location: dashboard.php');
exit;
?>
