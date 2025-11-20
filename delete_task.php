<?php
session_start();
if (!isset($_SESSION['user_id'])) exit;

require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task_id'])) {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$_POST['task_id'], $_SESSION['user_id']]);
}
header("Location: index.php");
exit;
?>