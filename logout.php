<?php
session_start();
session_destroy();

// Clear cookies
setcookie('remember_token', '', time() - 3600, "/");

header('Location: index.php');