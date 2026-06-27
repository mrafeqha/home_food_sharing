<?php
require __DIR__.'/../backend/config.php';
if (!is_logged_in()) redirect('auth.php');

$meal_id = $_GET['meal_id'] ?? null;
if (!$meal_id) redirect('meals.php');

$sql = "SELECT title, price, user_id FROM meals WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $meal_id);
$stmt->execute();
$meal = $stmt->get_result()->fetch_assoc();
if (!$meal) redirect('meals.php');

$cook_id = $meal['user_id'];
$meal_title = $meal['title'];
$price = $meal['price'];

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = true;
}
?>
<!doctype html>
<html>
<head>
<title>Payment - Home Food Sharing</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php if ($success): ?>
<div class="card" style="margin:40px auto;max-width:520px;text-align:center">
    <h2>Payment Successful ✔</h2>
    <p class="muted">Thank you for reserving <strong><?php echo htmlspecialchars($meal_title); ?></strong>.</p>
    <p style="margin-top:14px"><strong>Pickup Details</strong></p>
    <p class="muted">
        Pickup From: Home Cook<br>
        Bring your order confirmation to collect your meal.
    </p>
    <p class="muted" style="font-size:0.9em;">
        (The pickup address / phone number can be shared by the cook through chat/SMS)
    </p>
    <a class="btn" href="meals.php" style="margin-top:18px">Back to Meals</a>
</div>

<?php else: ?>

<header>
<nav>
<a href="index.php">Home</a>
<a href="meals.php">Browse Meals</a>
<a href="post.php">Post Meal</a>
<span class="muted">Hi, <?php echo $_SESSION['user_name']; ?></span>
<a href="logout.php">Logout</a>
</nav>
</header>

<main style="max-width:450px;margin:20px auto">
<h2>Pay Online</h2>
<p class="muted">Meal: <strong><?php echo htmlspecialchars($meal_title); ?></strong></p>
<p class="price">₹ <?php echo number_format($price, 2); ?></p>

<form class="card" method="post">
<label class="label">Name on Card</label>
<input class="input" name="name" required>

<label class="label">Card Number</label>
<input class="input" maxlength="16" name="card" required>

<label class="label">Expiry Date</label>
<input class="input" placeholder="MM/YY" name="exp" required>

<label class="label">CVV</label>
<input class="input" type="password" maxlength="3" name="cvv" required>

<button class="btn" style="margin-top:20px">Pay ₹<?php echo number_format($price, 2); ?></button>
</form>
</main>

<?php endif; ?>
</body>
</html>
