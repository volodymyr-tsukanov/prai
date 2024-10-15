<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Forms</title>
</head>
<body>
    <?php
    $jezyki = ["C", "CPP", "Java", "C#", "HTML", "CSS", "XML", "PHP", "JavaScript"];

    echo '<form action="odbierz3.php" method="POST">';
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
    echo '<input name="zaplata" type="radio" value="euro" />eurocard';
    echo '<input name="zaplata" type="radio" value="visa" checked />visa';
    echo '<input name="zaplata" type="radio" value="przelew" />przelew bankowy';
    echo '<br><input type="submit" value="Wyślij" />';
    echo '<input type="reset" value="Anuluj" />';
    echo '</form>';
    ?>
</body>
</html>