<?php
namespace prai_lab;

include_once '../funkcje.php';

use prai_lab\DTBase;


class UserManager {
    protected DTBase $db;


    function __construct(DTBase& $db){
        $this->db = $db;
    }
    function __destruct(){
        
    }


    public static function loginForm(){
        echo '<h3>Login Form</h3>
        <form action="loginProcess.php" method="post">
            <label for="userName">Username:</label><br>
            <input type="text" name="userName" id="userName" minlength="4" maxlength="25"><br>
            <label for="passwd">Password:</label><br>
            <input type="password" name="passwd" id="passwd" minlength="6"><br><br>
            <input type="submit" name="submit" value="Login">
            <input type="submit" name="submit" value="LogOut">
            <input type="submit" name="submit" value="Check">
        </form>';
    }

    public function login(): int{
        $userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $passwd = filter_input(INPUT_POST, 'passwd', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$userName || !$passwd) {
            return -2;
        }

        if ($result = $this->db->selectUser($userName,$passwd)){
            // jezeli sesja jest to resetuj
            if(isset($_SESSION['user'])){
                echo "Najpierw wyloguj!";
                return -2;
            }

            $sessionId = session_id();
            $userId = $result->id;
            $timestamp = date("Y-m-d H:i:s");
            echo $timestamp;

            // wyczyszczenie poprzednich sesji
            $this->db->delete('logged_in_users', "userId=$userId");

            // nowy zapis sesji w tabeli         
            if($this->db->insert('logged_in_users(userId,sessionId,lastUpdate)', "$userId,'$sessionId','$timestamp'")){
                $user = User::fromStdClass($result,$passwd,$this->db);
                $_SESSION['user'] = $user->toJSON();
                return $userId;
            }
        }

        return -1;
    }
    public function logout(): bool{
        if(session_status() === PHP_SESSION_NONE){
            echo "no active sesiion";
            return false;
        }

        $sessionId = session_id();
        // wyczyszczenie sesji
        if($this->db->delete('logged_in_users', "sessionId='$sessionId'")){
            sessionDestroy();
            return true;
        }
        return false;
    }

    public function getLoggedInUser(): int{
        if(session_status() === PHP_SESSION_NONE){
            echo "no active sesiion";
            return -2;
        }

        $sessionId = session_id();
        if($result = $this->db->select('logged_in_users','userId',"sessionId='$sessionId'")){
            return (int)$result->userId;
        }
        sessionDestroy();   //usuwamy nie istniajaca sesje
        return -1;
    }
    public function getUserBySsId(): User|null{
        $userId = $this->getLoggedInUser();
        if($userId < 0) return null;
        if($result = $this->db->selectUserById($userId)){
            return User::fromStdClass($result,'',$this->db);
        }
        return null;
    }
}
?>