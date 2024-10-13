<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lab1</title>
    </head>
    <body>
        <?php
        echo "<h2>Pierwszy skrypt PHP</h2>";
        $n=4567; $x=10.123456789;
        //a
        //echo "Domyślny format: ".$n." ".$x."<br>";
        //b
        echo "Domyślny format: n=$n x=$x <br>";
        //c
        //echo 'Domyślny format: $n $x <br>';
        //d
        printf("Zaokrąglenie do liczby całkowitej x=%d, <br>z trzema cyframi po kropce x=%.3f", $x, $x);
        ?>
    </body>
</html>

