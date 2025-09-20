<?php
require_once 'helpers.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $display = trim($_POST['display_name']);
    $password = $_POST['password'];
    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } else {
        // check uniqueness
        $stmt = $mysqli->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'Username already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare('INSERT INTO users (username, password, display_name) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $username, $hash, $display);
            $stmt->execute();
            header('Location: login.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
  <div class="card" style="max-width:420px;margin:auto;">
    <h2>Register</h2>
    <?php if (!empty($error)): ?><div class="meta" style="color:#b91c1c;"><?=htmlspecialchars($error)?></div><?php endif; ?>
    <form method="post">
      <label>Username</label>
      <input name="username" required>
      <label>Display name (optional)</label>
      <input name="display_name">
      <label>Password</label>
      <input name="password" type="password" required>
      <button class="btn" type="submit">Create account</button>
    </form>
    <div style="margin-top:10px;"><a href="login.php">Already have an account? Login</a></div>
  </div>
</div>
</body>
</html>
