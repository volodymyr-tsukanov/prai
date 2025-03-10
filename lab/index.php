<?php
namespace prai_lab;

require_once 'php_classes/DTBase.php';
include_once 'funkcje.php';
include_once 'php_classes/User.php';


$kraje = ["Polska", "Wielka Brytania", "Niemcy"];
$jezyki = ["CPP", "Java", "PHP"];
$zaplaty = ["Master Card", "Visa", "Przelew"];
$akcje = ["Wyczyść", "Dodaj", "Pokaż", "PHP", "CPP", "Java", "Staty", "Usuń"];

$submit = isset($_POST['submit']) ? $_POST['submit'] : null;


function printForm(){
    global $kraje, $jezyki, $zaplaty, $akcje;
    echo '<h2>Formularz zamówienia</h2>';
    echo '<form action="index.php" method="POST">';
    echo '<table>';
    echo '<tr><td>Nazwisko: </td><td><input name="nazw" size="30" id="nazw"/></td></tr>';
    echo '<tr><td>Wiek:</td><td><input name="wiek" size="30" id="wiek"/></td></tr>';
    echo '<tr><td>Państwo:</td><td>';
    echo '<select name="kraj" id="kraj">';
    foreach ($kraje as $kraj){
        echo "<option value='$kraj'>$kraj</option>";
    }
    echo '</select></td></tr>';
    echo '<tr><td>Adres e-mail: </td><td><input name="email" size="30" id="email"/></td></tr>';
    echo '</table>';
    echo '<h4>Zamawiam tutorial z języka:</h4>';
    foreach ($jezyki as $jezyk) {
        echo '<input name="jezyki[]" type="checkbox" value="'.$jezyk.'" />'.$jezyk.' ';
    }
    echo '<h4>Sposób zapłaty:</h4>';
    foreach ($zaplaty as $zaplata){
        echo "<input name='zaplata' type='radio' value='$zaplata' />$zaplata";
    }
    echo '<input name="zaplata" type="radio" value="cash" checked />gotówką 🤫';
    echo '<br>';
    foreach ($akcje as $akcja){
        echo "<input type='submit' name='submit' value='$akcja' />";
    }
    echo '<h4>Id to remove</h4><input name="deleteWhat" id="deleteWhat" size="20" />';
    echo '</form>';
}

function addToDB($db){
    $table = '`klienci`(`Nazwisko`,`Wiek`,`Panstwo`,`Email`,`Platnosc`,`Zamowienie`)';

    $args = ['nazw' => ['filter' => FILTER_VALIDATE_REGEXP,
        'options' => ['regexp' => '/^[A-Z]{1}[a-ząęłńśćźżó-]{1,25}$/']
        ],
        'wiek' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => [
                'min_range' => 18, //pełnoletnie tylko
                'max_range' => 120 //ludzie tak długo nie żyją
            ]
        ],
        'kraj' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'email' => [
            'filter' => FILTER_VALIDATE_EMAIL
        ],
        'zaplata' => [
            'filter' => FILTER_SANITIZE_STRING
        ],
        'jezyki' => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'flags' => FILTER_REQUIRE_ARRAY
        ]
    ];

    //przefiltruj dane z GET/POST zgodnie z ustawionymi w $args filtrami:
    $dane = filter_input_array(INPUT_POST, $args);
    //pokaż tablicę po przefiltrowaniu - sprawdź wyniki filtrowania:
    var_dump($dane);
    //Sprawdź czy dane w tablicy $dane nie zawierają błędów walidacji:
    $errors = "";
    foreach ($dane as $key => $val) {
        if ($val === false or $val === null) {
            $errors .= $key.' ';
        }
    }

    if ($errors === ""){
        echo 'Zapisanie to DB: '.$db->insert($table, arrToSQLValues($dane));
    } else {
        echo "<h3>Dane nie w pełni uzupełnione. Wypełnij formularz.</h3> " . $errors;
    }
    exit;
}


setDebugMode(1);
printHTMLhead('Lab8: Login', false);

$db = new DTBase("localhost", "tester", "pub0key", DB_NAME); //was root ""

$user = new User('kubus', 'Kubus Puchatek', 'kubus@stumilowylas.pl', 'password123', $db);
//$user->saveDB();
$user->getAllUsersFromDB();
//$db->selectUser('users','kubus','password123');

printForm();

if (filter_input(INPUT_POST, "submit")) {
    $akcja = filter_input(INPUT_POST, "submit");
    switch ($akcja) {
        case "Dodaj":
            echo 'dodanie do db: '.addToDB($db);
            break;
        case "Pokaż":
            echo '<h3>pokazanie z db:</h3>';
            echo $db->selectAll("SELECT Id,Nazwisko,Zamowienie FROM klienci", ["Id", "Nazwisko", "Zamowienie"]);
            break;
        case "Usuń":
            $db->deleteById('klienci', filter_input(INPUT_POST, "deleteWhat"));
            break;
    }
}

printHTMLtail();
?>
