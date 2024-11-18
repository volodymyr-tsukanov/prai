<?php
namespace prai_lab;

include_once "funkcje.php";
include_once "php_classes/User.php";
include_once "php_classes/RegistrationForm.php";

$usersPath = 'data/users.';


setDebugMode(1);
printHTMLhead('Lab5', true);

$user1 = new User ('kp', 'Kubus Puchatek', 'kubus@stumilowylas.pl', 'nielubietygryska');
$user1->show();
//$user1->save($usersPath.User::FORMAT_XML,User::FORMAT_XML);

$rf = new RegistrationForm(); //wyświetla formularz rejestracji
if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
    $user = $rf->checkUser(); //sprawdza poprawność danych
    if ($user === NULL)
        echo "<p>Niepoprawne dane rejestracji.</p>";
    else{
        echo "<p>Poprawne dane rejestracji:</p>";
        $user->show();
        $user->save($usersPath.User::FORMAT_JSON);
    }
}

print('<br>JSON:<br>');
$user1->getAllUsers($usersPath.User::FORMAT_JSON);
print('<br><br>XML:<br>');
$user1->getAllUsers($usersPath.User::FORMAT_XML,User::FORMAT_XML);

printHTMLtail();
?>