<?php
require __DIR__ . '/../backend/config.php';
if (!is_logged_in()) redirect('auth.php');

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $portions = $_POST['portions'];
    $available_until = $_POST['available_until'] ?? null;
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO meals (user_id, title, description, price, portions, available_until, address, phone)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdisss", $user_id, $title, $description, $price, $portions, $available_until, $address, $phone);

    if ($stmt->execute()) redirect("meals.php");
    else $msg = "Error posting meal!";
}
?>
<!doctype html>
<html>
<head>
  <title>Post Meal</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
<nav>
  <div class="brand"><span class="dot"></span> Home Food Sharing</div>
  <a href="index.php">Home</a>
  <a href="meals.php">Browse Meals</a>
  <a class="active" href="post.php">Post Meal</a>
  <span class="muted">Hi, <?php echo $_SESSION['user_name']; ?></span>
  <a href="logout.php">Logout</a>
</nav>
</header>

<main>
<h2>Post a Meal</h2>

<form method="post" class="card" style="max-width:650px;margin:auto">

<label>Title</label>
<input class="input" name="title" required>

<label>Description</label>
<textarea class="input" name="description" required></textarea>

<label>Pickup Address</label>
<input class="input" name="address" placeholder="House, Street, Area" required>

<label>Phone Number</label>
<input class="input" name="phone" maxlength="10" placeholder="10-digit phone no" required>

<div class="grid cols-2">
  <div>
    <label>Price (₹)</label>
    <input class="input" type="number" name="price" step="0.01" required>
  </div>
  <div>
    <label>Portions</label>
    <input class="input" type="number" name="portions" required>
  </div>
</div>

<label>Available until (optional)</label>
<input class="input" type="datetime-local" name="available_until">

<button class="btn" style="margin-top:16px">Publish Meal</button>
</form>
</main>
</body>
</html>
