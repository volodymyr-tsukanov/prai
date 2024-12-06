<?php
include_once 'funkcje.php';
include_once 'php_classes/User.php';
use prai_lab\User;

setDebugMode(1);

session_start();

echo "<h3>Id sesji: " . session_id() . "</h3>";

if (isset($_SESSION['user'])) {
    $sessionUser = unserialize($_SESSION['user']);
    if ($sessionUser instanceof User) {
        $sessionUser->show(); // Using the show() method from User class
    } else {
        echo "<p>Invalid user object in session</p>";
    }
} else {
    echo "<p>Nie ma cookies</p>";
}

session_destroy();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}
$_SESSION = array();

echo "<h2>Sesja wyczysczona</h2>";

echo "<p><a href='test1.php'>Wroc do test1.php</a></p>";
?>
