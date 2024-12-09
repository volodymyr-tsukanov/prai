<?php
namespace prai_lab;

require_once 'php_classes/DTBase.php';
include_once 'funkcje.php';
include_once 'php_classes/UserManager.php';
include_once 'php_classes/RegistrationForm.php';


setDebugMode(1);

$db = new DTBase("localhost", "tester", "pub0key", DB_NAME);
$um = new UserManager($db);

if(isset($_GET['new'])){
    $rf = new RegistrationForm();
    if(isset($_POST['submit'])){
        if($user = $rf->checkUser($db)){
            if($user->saveDB()){
                redirect('loginProcess.php');
            } else echo "Nieudano zapisac do DB.";
        }
    }
} else {
    session_start();
    if(isset($_SESSION['user'])){
        $sessionUser = User::fromJson($_SESSION['user'],$db);
        echo "W ciasteczkach jest:<br>";
        $sessionUser->show();
    }

    UserManager::loginForm();
    if($akcja = filter_input(INPUT_POST, "submit")) {
        switch ($akcja){
            case "Login" :
                echo $um->login();
                break;
            case "LogOut" :
                echo $um->logout();
                break;
            case "Check":
                echo 'Sprawdzono sesje w bazie, userId = '.$um->getLoggedInUser();
                break;
        }
    }

    print('<br><a href="loginProcess.php?new=">Rejestracja</a>');
}
unset($db);
?>