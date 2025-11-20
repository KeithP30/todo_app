<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List - <?= htmlspecialchars($_SESSION['username']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Hai, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </header>
    <?php

$urgent = array_filter($tasks, function($t) {
    if ($t['status'] !== 'completed' && !empty($t['due_date'])) {
        $now = new DateTime();
        $due = new DateTime($t['due_date']);
        return $due >= $now && $due <= $now->modify('+24 hours');
    }
    return false;
});
if (!empty($urgent)): ?>
    <div class="alert-warning">
        ⚠️ Ada <?= count($urgent) ?> tugas dengan deadline dalam 24 jam!
    </div>
<?php endif; ?>

       <form method="POST" action="add_task.php" class="add-task-form">
    <input type="text" name="task" placeholder="Apa yang harus dikerjakan?" required>
    
    <div class="task-options">
        <select name="priority" class="priority-select">
            <option value="low">Rendah</option>
            <option value="medium" selected>Sedang</option>
            <option value="high">Tinggi</option>
        </select>
        <input type="datetime-local" name="due_date">
    </div>
    
    <button type="submit">Tambah Tugas</button>
</form>

      <ul class="task-list">
<?php foreach ($tasks as $t): 
    $overdue = $t['due_date'] && new DateTime($t['due_date']) < new DateTime();
    $dueSoon = $t['due_date'] && 
        (new DateTime($t['due_date']) >= new DateTime()) && 
        (new DateTime($t['due_date']) <= (clone (new DateTime()))->modify('+24 hours'));
?>
    <li class="task-item <?= $t['status'] == 'completed' ? 'completed' : '' ?> 
                         <?= $overdue ? 'overdue' : '' ?> 
                         <?= $dueSoon ? 'due-soon' : '' ?>">
        
        <div class="task-content">
            <span><?= htmlspecialchars($t['task']) ?></span>
            <?php if ($t['due_date']): ?>
                <small class="<?= $overdue ? 'text-overdue' : '' ?>">
                    🕒 <?= date('d M Y H:i', strtotime($t['due_date'])) ?>
                </small>
            <?php endif; ?>
            <span class="badge <?= $t['priority'] ?>"><?= ucfirst($t['priority']) ?></span>
        </div>

        <div class="task-actions">
            <?php if ($t['status'] === 'pending'): ?>
                <form method="POST" action="toggle_complete.php" style="display:inline;">
                    <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                    <button type="submit" class="btn-complete">✓</button>
                </form>
            <?php endif; ?>
            
            <form method="POST" action="delete_task.php" style="display:inline;" 
                  onsubmit="return confirm('Yakin hapus tugas ini?');">
                <input type="hidden" name="task_id" value="<?= $t['id'] ?>">
                <button type="submit" class="btn-delete">🗑️</button>
            </form>
        </div>
    </li>
<?php endforeach; ?>
</ul>
    </div>
</body>
</html>