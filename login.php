<?php
require_once 'helpers.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $mysqli->prepare('SELECT id, password FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid credentials.';
        }
    } else {
        $error = 'Invalid credentials.';
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
  <div class="card" style="max-width:420px;margin:auto;">
    <h2>Login</h2>
    <?php if (!empty($error)): ?><div class="meta" style="color:#b91c1c;"><?=htmlspecialchars($error)?></div><?php endif; ?>
    <form method="post">
      <label>Username</label>
      <input name="username" required>
      <label>Password</label>
      <input name="password" type="password" required>
      <button class="btn" type="submit">Login</button>
    </form>
    <div style="margin-top:10px;"><a href="register.php">Need an account? Register</a></div>
  </div>
</div>
</body>
</html>
