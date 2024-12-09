<?php
namespace prai_lab;

require_once 'php_classes/DTBase.php';
include_once 'funkcje.php';
include_once 'php_classes/User.php';
include_once 'php_classes/UserManager.php';


setDebugMode(1);

session_start();

$db = new DTBase("localhost", "tester", "pub0key", DB_NAME);
$um = new UserManager($db);

print('<br><a href="loginProcess.php?act=lgO">Wyloguj</a>');

if(isset($_SESSION['user'])){
    $sessionUser = User::fromJson($_SESSION['user'],$db);
    echo '<h4>W ciasteczkach jest:</h4>';
    $sessionUser->show();
} else echo 'Nie ma ciastkowego user 😕';

echo '<h4>W bazie:</h4>';
if($user = $um->getUserBySsId()){
    echo '';
    $user->show();
} else echo 'Brak usera w BD lub ciastko zepsute';


?>