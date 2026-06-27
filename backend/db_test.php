<?php
require __DIR__.'/../backend/config.php';
header('Content-Type: text/plain');
echo "Connected OK to MySQL as '{$user}' to db '{$db}'.";

