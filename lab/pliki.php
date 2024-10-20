<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Files</title>
</head>
<body>
    <?php
    include_once "funkcje.php";
    
    $dataPath = 'data/dane.txt';
    $jezyki = ["C", "CPP", "Java", "C#", "HTML", "CSS", "XML", "PHP", "JavaScript"];
    $zaplaty = ["eurocard", "visa", "przelew"];
    $akcje = ["Wyczyść", "Zapisz", "Pokaż", "PHP", "CPP", "Java"];

    $nazw = isset($_REQUEST['nazw']) ? $_REQUEST['nazw'] : null;
    $wiek = isset($_REQUEST['wiek']) ? $_REQUEST['wiek'] : null;
    $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
    $kraj = isset($_REQUEST['kraj']) ? $_REQUEST['kraj'] : null;
    $tutoriale = isset($_REQUEST['jezyki']) ? $_REQUEST['jezyki'] : [];
    $zaplata = isset($_REQUEST['zaplata']) ? $_REQUEST['zaplata'] : null;
    $submit = isset($_REQUEST['submit']) ? $_REQUEST['submit'] : null;


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
            return "$nazw $wiek $kraj $email ".implode(',',$tutoriale)." $zaplata";
        } else {
            echo "<h3>Dane nie w pełni uzupełnione. Wypełnij formularz.</h3>";
            return null;
        }
    }


    printForm();
    
    if($submit){
        switch($submit){
            case 'Wyczyść': //nic do wyświetlenia
                break;
            case 'Zapisz':
                $data = gatherData();
                if($data){
                    writeToF($dataPath, $data);
                }
                break;
            case 'Pokaż':
                readFromF($dataPath);
                break;
            case 'PHP':
                readFromF($dataPath, 'showByTut','PHP');
                break;
            case 'CPP':
                readFromF($dataPath, 'showByTut','CPP');
                break;
            case 'Java':
                readFromF($dataPath, 'showByTut','Java');
                break;
            default:
                echo "<h3>To jest podejżane 🤨</h3>";
                break;
        }
    }
    ?>
</body>
</html>