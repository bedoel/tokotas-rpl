<?php

session_start();
$_SESSION = [];
session_unset();
session_destroy();

// setcookie('co', null, 1, '/');
// setcookie('kie', null, 1, '/');
if (isset($_COOKIE['co'])) {
    unset($_COOKIE['co']);
    setcookie('co', '', time() - 3600, '/'); // empty value and old timestamp
}
if (isset($_COOKIE['kie'])) {
    unset($_COOKIE['kie']);
    setcookie('kie', '', time() - 3600, '/'); // empty value and old timestamp
}

header("Location: index.php");
exit;
