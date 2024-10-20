<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Form receiver</title>
</head>
<body>
    <div>
        <h2>Dane odebrane z formularza:</h2>
        <?php
        if (isset($_REQUEST['jezyki'])) {
            echo "<h3>Wybrane kursy:</h3>";

            print('a) foreach<br>');
            foreach ($_REQUEST['jezyki'] as $jezyk) {
                echo "$jezyk ";
            }
            print('<br>b) join()<br>');
            print(join(', ',$_REQUEST['jezyki']));
        } else {
            echo "<h3>Nie wybrano żadnych kursów.</h3>";
        }

        echo "<h3>Wszystkie parametry:</h3>";
        foreach ($_REQUEST as $key => $value) {
            echo "$key: ";
            if (is_array($value)) {
                echo implode(' | ',$value).'<br>';
            } else {
                echo "$value <br>";
            }
        }
        ?>
    </div>
</body>
</html>