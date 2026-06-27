<?php
require __DIR__.'/../backend/config.php';
session_unset();
session_destroy();
redirect('index.php');
