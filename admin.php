<?php
require_once 'helpers.php';
require_login();
$user = current_user();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    if ($title === '' || $content === '' || $start === '' || $end === '') {
        $error = 'All fields are required.';
    } else {
        $stmt = $mysqli->prepare('INSERT INTO announcements (title, content, start_date, end_date, created_by) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssi', $title, $content, $start, $end, $user['id']);
        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            $error = 'Failed to save announcement.';
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Add Announcement</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
  <div class="card" style="max-width:800px;margin:auto;">
    <h2>Add Announcement</h2>
    <?php if (!empty($error)): ?><div class="meta" style="color:#b91c1c;"><?=htmlspecialchars($error)?></div><?php endif; ?>
    <form method="post">
      <label>Title (eg. "School Holiday", "Exam Notice")</label>
      <input name="title" required>
      <label>Content</label>
      <textarea name="content" rows="6" required></textarea>
      <label>Start date</label>
      <input type="date" name="start_date" required>
      <label>End date</label>
      <input type="date" name="end_date" required>
      <button class="btn" type="submit">Post Announcement</button>
    </form>
    <div style="margin-top:12px;"><a href="index.php">← Back</a></div>
  </div>
</div>
</body>
</html>
