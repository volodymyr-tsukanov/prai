<?php
session_start();

echo "<h3>Id sesji: " . session_id() . "</h3>";

if (!empty($_SESSION)) {
    echo "<ul>";
    foreach ($_SESSION as $key => $value) {
        echo "<li>" . htmlspecialchars($key) . ": " . htmlspecialchars($value) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Nie ma cookies</p>";
}

echo "<h4>Sesja kontent:</h4>";
if (isset($_COOKIE[session_name()])) {
    echo "<p>Session cookie value: " . htmlspecialchars($_COOKIE[session_name()]) . "</p>";
} else {
    echo "<p>Nie ma session cookie</p>";
}

session_destroy();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}
$_SESSION = array();

echo "<h2>Sesja wyczysczona</h2>";

echo "<p><a href='test1.php'>Wroc do test1.php</a></p>";
?>
