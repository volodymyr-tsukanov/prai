<?php
include_once "funkcje.php";

$dataPath = 'data/dane.csv';
//"$doc_root/../dtst/dane.txt";
$jezyki = ["C", "CPP", "Java", "C#", "HTML", "CSS", "XML", "PHP", "JavaScript"];
$zaplaty = ["eurocard", "visa", "przelew"];
$akcje = ["Wyczyść", "Zapisz", "Pokaż", "PHP", "CPP", "Java"];

$nazw = isset($_POST['nazw']) ? $_POST['nazw'] : null;
$wiek = isset($_POST['wiek']) ? $_POST['wiek'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$kraj = isset($_POST['kraj']) ? $_POST['kraj'] : null;
$tutoriale = isset($_POST['jezyki']) ? $_POST['jezyki'] : [];
$zaplata = isset($_POST['zaplata']) ? $_POST['zaplata'] : null;
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

function gatherData(){  // == dodaj ze skryptu
    global $nazw, $wiek, $kraj, $email, $tutoriale, $zaplata;
    if ($nazw && $wiek && $email && $kraj && $zaplata && !empty($tutoriale)){
        return implodeData($nazw,$wiek,$email,$kraj,$zaplata,$tutoriale);
    } else {
        echo "<h3>Dane nie w pełni uzupełnione. Wypełnij formularz.</h3>";
        return null;
    }
}


setDebugMode(1);
printHTMLhead('Files');
printForm();
printHTMLtail();

if($submit){
    switch($submit){
        case 'Wyczyść': //nic do wyświetlenia
            break;
        case 'Zapisz':
            $data = gatherData();
            if($data){
                writeToCSV($dataPath, $data, 'Nazwisko|Wiek|Państwo|Email|Zapłata|Języki');
            }
            break;
        case 'Pokaż':
            readFromCSV($dataPath, true);
            break;
        case 'PHP':
            readFromCSV($dataPath, true,  'showByTut','PHP');
            break;
        case 'CPP':
            readFromCSV($dataPath, true, 'showByTut','CPP');
            break;
        case 'Java':
            readFromCSV($dataPath, true, 'showByTut','Java');
            break;
        default:
            echo "<h3>To jest podejżane 🤨</h3>";
            break;
    }
}

/*foreach ($_SERVER as $key => $value) {
    echo "$key: $value<br>";
}*/
?>
