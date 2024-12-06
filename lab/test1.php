<?php
include_once 'funkcje.php';
include_once 'php_classes/User.php';
use prai_lab\User;

setDebugMode(1);

session_start();

$user = new User('kubus', 'Kubus Puchatek', 'kubus@stumilowylas.pl', 'password123', $db);
$_SESSION['user'] = serialize($user);

echo "<h3>Id sesji: " . session_id() . "</h3>";
echo "<h4>Sesja kontent:</h4><ul>";
if (isset($_SESSION['user'])) {
    $sessionUser = unserialize($_SESSION['user']);
    if ($sessionUser instanceof User) {
        echo "<li>Username: " . htmlspecialchars($sessionUser->getUserName()) . "</li>";
        echo "<li>Full Name: " . htmlspecialchars($sessionUser->getFullName()) . "</li>";
        echo "<li>Email: " . htmlspecialchars($sessionUser->getEmail()) . "</li>";
        echo "<li>Status: " . ($sessionUser->getStatus() == User::STATUS_ADMIN ? 'ADMIN' : 'USER') . "</li>";
        echo "<li>Date: " . htmlspecialchars($sessionUser->getDate()->format(DateTime::W3C)) . "</li>";
    }
}
echo "</ul>";


echo "<h3>Ciasteczka:</h3>";
if (!empty($_COOKIE)) {
    echo "<ul>";
    foreach ($_COOKIE as $key => $value) {
        echo "<li>" . htmlspecialchars($key) . ": " . htmlspecialchars($value) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Nie ma cookies</p>";
}

// link test2.php
echo "<p><a href='test2.php'>Do test2.php</a></p>";

$sessionFile = session_save_path() . '/sess_' . session_id();
echo "<h3>File sesji:</h3>";
echo "<p>Path: " . htmlspecialchars($sessionFile) . "</p>";
if (file_exists($sessionFile)) {
    echo "<p>Content:</p>";
    echo "<pre>" . htmlspecialchars(file_get_contents($sessionFile)) . "</pre>";
}
?>
