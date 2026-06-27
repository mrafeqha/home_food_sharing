<?php require __DIR__.'/../backend/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Browse Meals - Home Food Sharing</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <nav>
    <div class="brand"><span class="dot"></span> Home Food Sharing</div>
    <div style="flex:1"></div>
    <a href="index.php">Home</a>
    <a class="active" href="meals.php">Browse Meals</a>
    <a href="post.php">Post Meal</a>
    <?php if (is_logged_in()): ?>
      <span class="muted">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="auth.php">Login / Signup</a>
    <?php endif; ?>
  </nav>
</header>

<main>
<h2>Available Meals</h2>
<div class="grid cols-3" style="margin-top:14px">

<?php
$sql = "SELECT m.id, m.title, m.description, m.price, m.portions, m.available_until, 
               m.created_at, m.address, m.phone, u.name AS cook
        FROM meals m JOIN users u ON m.user_id = u.id
        ORDER BY m.created_at DESC";
$res = $conn->query($sql);

if ($res && $res->num_rows > 0):
  while($row = $res->fetch_assoc()):
    $img = 'https://source.unsplash.com/featured/800x600/?food,'.urlencode($row['title']);
?>
  <div class="card">
    <img class="meal-img" src="<?php echo $img; ?>" alt="Meal image">
    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
    <p class="muted"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>

    <div class="muted">Cook: <strong><?php echo htmlspecialchars($row['cook']); ?></strong></div>
    <div class="muted">Portions: <strong><?php echo (int)$row['portions']; ?></strong></div>
    <div class="price">₹ <?php echo number_format((float)$row['price'], 2); ?></div>

    <?php if (is_logged_in()): ?>
      <a class="btn" href="payment.php?meal_id=<?php echo $row['id']; ?>" style="margin-top:10px;display:inline-block">
        Pay & Pickup
      </a>
    <?php else: ?>
      <a class="btn secondary" href="auth.php" style="margin-top:10px;display:inline-block">
        Login to Buy
      </a>
    <?php endif; ?>

    <?php if(!empty($row['available_until'])): ?>
      <div class="muted">Available until: <?php echo htmlspecialchars($row['available_until']); ?></div>
    <?php endif; ?>

    <div class="muted">Posted: <?php echo htmlspecialchars($row['created_at']); ?></div>
    <div class="muted" style="color:green;font-weight:bold;">📍 Pickup: <?php echo htmlspecialchars($row['address']); ?></div>
    <div class="muted" style="color:#005cbb;font-weight:bold;">📞 Contact: <?php echo htmlspecialchars($row['phone']); ?></div>
  </div>
<?php endwhile; else: ?>
  <p class="muted">No meals yet. Be the first to <a href="post.php">post one</a>!</p>
<?php endif; ?>

</div>
</main>
</body>
</html>
