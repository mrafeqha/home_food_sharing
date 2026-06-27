<?php require __DIR__.'/../backend/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home Food Sharing</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <nav>
    <div class="brand"><span class="dot"></span> Home Food Sharing</div>
    <div style="flex:1"></div>
    <a href="index.php" class="active">Home</a>
    <a href="meals.php">Browse Meals</a>
    <a href="post.php">Post Meal</a>
    <?php if(is_logged_in()): ?>
      <span class="muted">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="auth.php">Login / Signup</a>
    <?php endif; ?>
  </nav>
</header>
<main>
  <section class="hero">
    <div class="panel">
      <h1 style="margin:0 0 8px">Share homemade goodness, reduce waste</h1>
      <p class="sub">Turn extra portions into income and help neighbors enjoy fresh, affordable meals near them.</p>
      <div class="hero-cta">
        <a class="btn" href="meals.php">Browse Meals</a>
        <a class="btn secondary" href="post.php">Post a Meal</a>
      </div>
    </div>
    <div class="card">
      <div class="feature"><span class="dot"></span><div>
        <h3 style="margin:0">For Home Cooks</h3>
        <div class="muted">Earn from extra portions with a simple posting flow.</div>
      </div></div>
      <div class="spacer"></div>
      <div class="feature"><span class="dot"></span><div>
        <h3 style="margin:0">For Neighbors</h3>
        <div class="muted">Find affordable, fresh meals prepared nearby.</div>
      </div></div>
      <div class="spacer"></div>
      <div class="feature"><span class="dot"></span><div>
        <h3 style="margin:0">For Communities</h3>
        <div class="muted">Reduce food waste and build local connections.</div>
      </div></div>
    </div>
  </section>

  <section class="grid cols-3">
    <div class="card">
      <img class="meal-img" src="https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?q=80&w=800&auto=format&fit=crop" alt="Home cook">
      <h3 style="margin-top:0">Fresh & Homemade</h3>
      <p class="muted">Delicious meals prepared with care, just around the corner.</p>
    </div>
    <div class="card">
      <img class="meal-img" src="https://images.unsplash.com/photo-1466637574441-749b8f19452f?q=80&w=800&auto=format&fit=crop" alt="Neighbors">
      <h3 style="margin-top:0">Local & Affordable</h3>
      <p class="muted">Great food without the markup, supporting your neighborhood.</p>
    </div>
    <div class="card">
      <img class="meal-img" src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=800&auto=format&fit=crop" alt="Community table">
      <h3 style="margin-top:0">Reduce Waste</h3>
      <p class="muted">Share extra portions and make every meal count.</p>
    </div>
  </section>
</main>
</body>
</html>


