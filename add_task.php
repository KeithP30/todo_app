<?php
session_start();
if (!isset($_SESSION['user_id'])) exit;

require 'config.php';

$task = trim($_POST['task']);
$priority = in_array($_POST['priority'], ['low','medium','high']) ? $_POST['priority'] : 'medium';
$due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : null;

$pdo->prepare("INSERT INTO tasks (user_id, task, priority, due_date) VALUES (?,?,?,?)")
    ->execute([$_SESSION['user_id'], $task, $priority, $due_date]);

header("Location: index.php");
exit;