<?php
namespace prai_lab;

include_once "funkcje.php";
include_once "php_classes/User.php";
include_once "php_classes/RegistrationForm.php";


printHTMLhead('Lab5', true);

$user1 = new User ('kp', 'Kubus Puchatek', 'kubus@stumilowylas.pl', 'nielubietygryska');
$user1->show();

$rf = new RegistrationForm(); //wyświetla formularz rejestracji
if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
    $user = $rf->checkUser(); //sprawdza poprawność danych
    if ($user === NULL)
        echo "<p>Niepoprawne dane rejestracji.</p>";
    else{
        echo "<p>Poprawne dane rejestracji:</p>";
        $user->show();
    }
}

printHTMLtail();
?>