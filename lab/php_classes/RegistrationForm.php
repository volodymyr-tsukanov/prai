<?php
namespace prai_lab;

include_once 'User.php';

use prai_lab\DTBase;



class RegistrationForm {
    protected User $user;


    function __construct(){
        echo '<h3>Formularz rejestracji</h3><p>';
        echo '<form action="loginProcess.php?act=rgr" method="POST">
            <label for="userName">Nazwa użytkownika:</label><br/>
            <input id="userName" name="userName" minlength="4" maxlength="25" placeholder="4-25 characters, alphanumeric, _ or -" required/><br/>
            
            <label for="fullName">Imię i nazwisko:</label><br/>
            <input id="fullName" name="fullName" minlength="4" maxlength="50" placeholder="Full name with Polish letters and spaces" required/><br/>
            
            <label for="email">Email:</label><br/>
            <input id="email" name="email" type="email" placeholder="example@mail.com" required/><br/>
            
            <label for="passwd">Hasło:</label><br/>
            <input id="passwd" name="passwd" type="password" minlength="6" placeholder="Minimum 6 characters, no spaces" required/><br/>
            
            <label for="confirmPasswd">Potwierdź hasło:</label><br/>
            <input id="confirmPasswd" name="confirmPasswd" type="password" minlength="6" placeholder="Confirm your password" required/><br/>
            
            <input type="submit" name="submit" value="Zarejestruj się" />
        </form></p>';
    }


    function getUser(): User|null{
        if(isset($this->user)) return $this->user;
        else return null;
    }


    function checkUser(DTBase& $db): User|null{
        $args = [
            'userName' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[0-9A-Za-z_-]{4,25}$/']
            ],
            'fullName' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[A-Za-ząćęłńóśźżĆŁŃŚŹŻ\s-]{4,50}$/']
            ],
            'email' => ['filter' => FILTER_VALIDATE_EMAIL],
            'passwd' => ['filter' => FILTER_DEFAULT],
            'confirmPasswd' => ['filter' => FILTER_DEFAULT]
        ];
        $dane = filter_input_array(INPUT_POST, $args);

        $errors = "";
        foreach ($dane as $key => $val){
            if ($val === false or $val === null){
                $errors .= $key.'<br>';
            }
        }
        if ($dane['passwd'] !== $dane['confirmPasswd']) {
            $errors .= "passwords nie rowne.<br>";
        }

        if ($errors === "") {
            $this->user = new User($dane['userName'], $dane['fullName'], $dane['email'], $dane['passwd'], $db);
            return $this->user;
        } else {
            echo "<p>Błędne dane: $errors</p>";
        }
        return null;
    }
}
?>