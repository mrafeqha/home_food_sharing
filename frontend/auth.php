<?php
require __DIR__.'/../backend/config.php';
if (is_logged_in()) {
    redirect('index.php');
}
$tab = ($_GET['tab'] ?? 'login') === 'signup' ? 'signup' : 'login';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['action'] ?? '') === 'signup') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($name === '' || $email === '' || $password === '') $errors[] = 'All fields are required';
        if (!$errors) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO users (name, email, password_hash) VALUES (?,?,?)');
            $stmt->bind_param('sss', $name, $email, $hash);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['user_name'] = $name;
                redirect('index.php');
            } else {
                $errors[] = 'Email may already be registered';
            }
        }
        $tab = 'signup';
    } elseif (($_POST['action'] ?? '') === 'login') {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($email === '' || $password === '') $errors[] = 'Email and password required';
        if (!$errors) {
            $stmt = $conn->prepare('SELECT id, name, password_hash FROM users WHERE email = ? LIMIT 1');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && $row = $res->fetch_assoc()) {
                if (password_verify($password, $row['password_hash'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['name'];
                    redirect('index.php');
                }
            }
            $errors[] = 'Invalid credentials';
        }
        $tab = 'login';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login / Signup - Home Food Sharing</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <nav>
    <div class="brand"><span class="dot"></span> Home Food Sharing</div>
    <div style="flex:1"></div>
    <a href="index.php">Home</a>
    <a href="meals.php">Browse Meals</a>
    <a href="post.php">Post Meal</a>
  </nav>
</header>
<main>
  <h2 class="center">Login / Signup</h2>
  <?php if ($errors): ?>
    <div class="card" style="border-color:#fecaca;background:#fef2f2;color:#7f1d1d">
      <?php foreach($errors as $e): ?>
        <div><?php echo htmlspecialchars($e); ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <div class="grid" style="grid-template-columns:1fr 1fr;gap:20px;align-items:start">
    <form class="card" method="post" action="" <?php echo $tab==='login'?'':'style="opacity:.6"'; ?>>
      <h3 style="margin-top:0">Login</h3>
      <input type="hidden" name="action" value="login">
      <label class="label">Email</label>
      <input class="input" type="email" name="email" required>
      <label class="label">Password</label>
      <input class="input" type="password" name="password" required>
      <div style="margin-top:12px"><button class="btn" type="submit">Login</button></div>
    </form>

    <div class="card">
      <img class="meal-img" style="height:260px" src="https://images.unsplash.com/photo-1526318472351-c75fcf070305?q=80&w=1200&auto=format&fit=crop" alt="Share homemade food">
      <p class="muted">Join your neighborhood food network — discover and share extra portions of home-cooked meals.</p>
    </div>
  </div>

  <div class="grid" style="grid-template-columns:1fr 1fr;gap:20px;align-items:start;margin-top:18px">
    <div class="card">
      <img class="meal-img" style="height:220px" src="https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?q=80&w=1200&auto=format&fit=crop" alt="Cook at home">
      <h3 style="margin:6px 0 0">New here?</h3>
      <p class="muted">Create an account to start posting meals.</p>
    </div>
    <form class="card" method="post" action="" <?php echo $tab==='signup'?'':'style="opacity:.6"'; ?>>
      <h3 style="margin-top:0">Signup</h3>
      <input type="hidden" name="action" value="signup">
      <label class="label">Name</label>
      <input class="input" name="name" required>
      <label class="label">Email</label>
      <input class="input" type="email" name="email" required>
      <label class="label">Password</label>
      <input class="input" type="password" name="password" required>
      <div style="margin-top:12px"><button class="btn" type="submit">Create account</button></div>
    </form>
  </div>
</main>
</body>
</html>
