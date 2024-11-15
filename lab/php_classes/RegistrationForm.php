<?php
namespace prai_lab;


class RegistrationForm {
    protected $user;

    //TODO separate function printForm to avoid breaking php block
    function __construct(){ ?>
        <h3>Formularz rejestracji</h3><p>
        <form action="index.php" method="post">
            Nazwa użytkownika: <br/><input name="userName" /><br/>
            //dodaj pozostałe pola formularza
        </form></p>
        <?php
    }

    //TODO validation of $fullName $email $passwd
    function checkUser(){ // podobnie jak metoda validate z lab4
        $args = [
            'userName' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[0-9A-Za_-
]{2,25}$/']
            ]
        ];


        //przefiltruj dane:
        $dane = filter_input_array(INPUT_POST, $args);
        //sprawdz czy są błędy walidacji $errors – jak w lab4
        ... // uzupełnij kod
        if ($errors === "") {
            //Dane poprawne – utwórz obiekt user
            $this->user=new User($dane['userName'], $dane['fullName'],
                $dane['email'],$dane['passwd']);
        } else {
            echo "<p>Błędne dane: $errors</p>";
            $this->user = NULL;
        }
        return $this->user;
    }
}
?>