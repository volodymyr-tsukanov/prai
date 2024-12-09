<?php
namespace prai_lab;

require_once 'php_classes/DTBase.php';
include_once 'funkcje.php';
include_once 'php_classes/User.php';
include_once 'php_classes/UserManager.php';
include_once 'php_classes/RegistrationForm.php';


setDebugMode(1);

session_start();

$db = new DTBase("localhost", "tester", "pub0key", DB_NAME);
$um = new UserManager($db);

if(isset($_GET['act'])){
    switch($_GET['act']){
        case 'lgO':
            if($um->logout()) redirect('loginProcess.php');
            else print('Pomylka wylogowania. Refresh page and try again');
            break;
        case 'rgr':
            $rf = new RegistrationForm();
            if(isset($_POST['submit'])){
                if($user = $rf->checkUser($db)){
                    if($user->saveDB()){
                        redirect('loginProcess.php');
                    } else echo "Nieudano zapisac do DB.";
                } else echo "Niepoprawne dane";
            }
            break;
    }
} else {
    if(isset($_SESSION['user'])){
        $sessionUser = User::fromJson($_SESSION['user'],$db);
        echo "W ciasteczkach jest:<br>";
        $sessionUser->show();
    }

    UserManager::loginForm();
    if($akcja = filter_input(INPUT_POST, "submit")) {
        switch ($akcja){
            case "Login" :
                $res = $um->login();
                if($res > 0){
                    redirect('testLogin.php');
                } else echo 'Sprawdz poprawnosc danych';
                break;
            case "LogOut" :
                echo $um->logout();
                break;
            case "Check":
                echo 'Sprawdzono sesje w bazie, userId = '.$um->getLoggedInUser();
                break;
        }
    }

    print('<br><a href="loginProcess.php?act=rgr">Rejestracja</a>');
}
unset($db);
?>