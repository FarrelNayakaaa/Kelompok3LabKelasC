<?php
session_start();
require __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $todolist_id = $_POST['todolist_id'];
    $detail_title = $_POST['detail_title'];
    $detail_due_date = $_POST['detail_due_date'];
    $label_color = isset($_POST['label_color']) ? $_POST['label_color'] : null; 

    $stmt = $pdo->prepare('INSERT INTO detaillists (todolist_id, title, due_date, label_color) VALUES (?, ?, ?, ?)');
    $stmt->execute([$todolist_id, $detail_title, $detail_due_date, $label_color]);

    header("Location: view_list.php?id=" . $todolist_id);
    exit;
}
