<?php
namespace prai_lab;

include_once 'funkcje.php';
require_once 'php_classes/DTBase.php';


$jezyki = ["C", "CPP", "Java", "C#", "HTML", "CSS", "XML", "PHP", "JavaScript"];
$zaplaty = ["eurocard", "visa", "przelew"];
$akcje = ["Wyczyść", "Zapisz", "Pokaż", "PHP", "CPP", "Java", "Staty"];

$submit = isset($_POST['submit']) ? $_POST['submit'] : null;


function printForm(){
    global $jezyki, $zaplaty, $akcje;
    echo '<form action="pliki.php" method="POST">';
    echo '<table>';
    echo '<tr><td>Nazwisko: </td><td><input name="nazw" size="30" id="nazw"/></td></tr>';
    echo '<tr><td>Wiek:</td><td><input name="wiek" size="30" id="wiek"/></td></tr>';
    echo '<tr><td>Państwo:</td><td>';
    echo '<select name="kraj" id="kraj">';
    echo '<option value="pl" selected="selected">Polska</option>';
    echo '<option value="gb">Wielka Brytania</option>';
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
    echo '</form>';
}


setDebugMode(1);
printHTMLhead('Lab5', false);

printForm();

printHTMLtail();
?>