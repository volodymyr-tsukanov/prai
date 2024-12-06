<?php
session_start();

$_SESSION['username'] = 'kubus';
$_SESSION['fullname'] = 'Kubus Puchatek';
$_SESSION['email'] = 'kubus@stumilowylas.pl';
$_SESSION['status'] = 'ADMIN';

echo "<h3>Id sesji: " . session_id() . "</h3>";

echo "<h4>Sesja kontent:</h4>";
echo "<ul>";
foreach ($_SESSION as $key => $value) {
    echo "<li>" . htmlspecialchars($key) . ": " . htmlspecialchars($value) . "</li>";
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
