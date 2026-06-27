<?php
// One-time setup: imports db.sql into the existing MySQL server running on port 3306
// After success, delete this file for safety.

$host = 'localhost';
$user = 'root';
$pass = '';

$mysqli = @new mysqli($host, $user, $pass);
if ($mysqli->connect_error) {
    http_response_code(500);
    echo "Connection failed: ".$mysqli->connect_error;
    exit;
}

$sqlFile = __DIR__ . DIRECTORY_SEPARATOR . 'db.sql';
if (!file_exists($sqlFile)) {
    http_response_code(500);
    echo 'db.sql not found';
    exit;
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    http_response_code(500);
    echo 'Failed to read db.sql';
    exit;
}

$ok = $mysqli->multi_query($sql);
if (!$ok) {
    http_response_code(500);
    echo 'Import error: ' . $mysqli->error;
    exit;
}
// flush through all result sets
while ($mysqli->more_results()) {
    $mysqli->next_result();
}

?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Setup - Home Food Sharing</title>
<link rel="stylesheet" href="../frontend/styles.css">
</head>
<body>
<main style="max-width:800px;margin:40px auto;padding:0 20px">
  <div class="card">
    <h2 style="margin-top:0">Database Initialized</h2>
    <p class="muted">The database and tables have been created/imported.</p>
    <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap">
      <a class="btn" href="../frontend/index.php">Go to Home</a>
      <a class="btn secondary" href="../frontend/meals.php">Browse Meals</a>
    </div>
    <p class="muted" style="margin-top:16px">For safety, please delete <code>setup.php</code> now.</p>
  </div>
</main>
</body>
</html>
