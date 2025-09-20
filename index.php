<?php
require_once 'helpers.php';
// Fetch announcements and group into past/present/future
$today = new DateTimeImmutable('today');

$stmt = $mysqli->prepare('SELECT a.*, u.display_name FROM announcements a LEFT JOIN users u ON a.created_by = u.id ORDER BY start_date DESC, created_at DESC');
$stmt->execute();
$res = $stmt->get_result();
$announcements = [];
while ($row = $res->fetch_assoc()) {
    $announcements[] = $row;
}

$past = $present = $future = [];
foreach ($announcements as $a) {
    $start = new DateTimeImmutable($a['start_date']);
    $end = new DateTimeImmutable($a['end_date']);
    if ($end < $today) $past[] = $a;
    else if ($start > $today) $future[] = $a;
    else $present[] = $a;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>School Announcements</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>School Announcements</h1>
      <div class="nav">
        <?php if (is_logged_in()): ?>
          <span>Hi, <?=htmlspecialchars(current_user()['display_name'] ?? current_user()['username'])?></span>
          <a class="btn" href="admin.php">+ Add</a>
          <a class="btn" href="logout.php">Logout</a>
        <?php else: ?>
          <a class="btn" href="login.php">Login</a>
          <a class="btn" href="register.php">Register</a>
        <?php endif; ?>
      </div>
    </header>

    <section class="card">
      <h2>Present Announcements</h2>
      <?php if (empty($present)): ?>
        <p class="meta">No present announcements right now.</p>
      <?php else: ?>
        <div class="grid">
          <?php foreach ($present as $a): ?>
            <div>
              <h3><?=htmlspecialchars($a['title'])?></h3>
              <p><?=nl2br(htmlspecialchars($a['content']))?></p>
              <div class="meta">From <?=htmlspecialchars($a['start_date'])?> to <?=htmlspecialchars($a['end_date'])?> • Posted by <?=htmlspecialchars($a['display_name'] ?? 'Unknown')?></div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>

    <section style="margin-top:12px;">
      <div class="grid">
        <div class="card">
          <h3>Future Announcements</h3>
          <?php if (empty($future)): ?>
            <p class="meta">No future announcements.</p>
          <?php else: ?>
            <?php foreach ($future as $a): ?>
              <div style="margin-bottom:10px;">
                <strong><?=htmlspecialchars($a['title'])?></strong>
                <div class="meta"><?=htmlspecialchars($a['start_date'])?> — <?=htmlspecialchars($a['end_date'])?></div>
                <p><?=nl2br(htmlspecialchars($a['content']))?></p>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="card">
          <h3>Past Announcements</h3>
          <?php if (empty($past)): ?>
            <p class="meta">No past announcements.</p>
          <?php else: ?>
            <?php foreach ($past as $a): ?>
              <div style="margin-bottom:10px;">
                <strong><?=htmlspecialchars($a['title'])?></strong>
                <div class="meta"><?=htmlspecialchars($a['start_date'])?> — <?=htmlspecialchars($a['end_date'])?></div>
                <p><?=nl2br(htmlspecialchars($a['content']))?></p>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <footer>
      © <?=date('Y')?> Your School Name
    </footer>
  </div>
</body>
</html>
