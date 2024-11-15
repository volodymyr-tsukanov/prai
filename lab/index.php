<?php
namespace prai_lab;

include_once "funkcje.php";
include "php_classes/User.php";


printHTMLhead('Lab5', true);

$user1 = new User ('kp', 'Kubus Puchatek', 'kubus@stumilowylas.pl', 'nielubietygryska');
$user1->show();

printHTMLtail();
?>