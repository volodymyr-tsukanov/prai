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
        if (isset($_REQUEST['nazw']) && ($_REQUEST['nazw'] != "")) {
            $nazwisko = htmlspecialchars(trim($_REQUEST['nazw']));
            echo "Nazwisko: $nazwisko <br />";
        } else echo "Nie wpisano nazwiska <br />";

        if (isset($_REQUEST['wiek']) && ($_REQUEST['wiek'] != "")) {
            $wiek = htmlspecialchars(trim($_REQUEST['wiek']));
            echo "Wiek: $wiek <br />";
        } else echo "Nie wpisano wiek <br />";

        if (isset($_REQUEST['kraj']) && ($_REQUEST['kraj'] != "")) {
            $kraj = htmlspecialchars(trim($_REQUEST['kraj']));
            echo "Kraj: $kraj <br />";
        } else echo "Nie wpisano kraj <br />";

        if (isset($_REQUEST['email']) && ($_REQUEST['email'] != "")) {
            $email = htmlspecialchars(trim($_REQUEST['email']));
            echo "Email: $email <br />";
        } else echo "Nie wpisano emailiska <br />";

        $tut = '';
        if (isset($_REQUEST['php']) && ($_REQUEST['php'] == "on"))
            $tut = 'php';
        if (isset($_REQUEST['c']) && ($_REQUEST['c'] == "on"))
            $tut = $tut.' c/c++';
        if (isset($_REQUEST['java']) && ($_REQUEST['java'] == "on"))
            $tut = $tut.' java';
        echo "Tutorial: $tut <br />";

        if (isset($_REQUEST['zaplata']) && ($_REQUEST['zaplata'] != "")) {
            $zaplata = htmlspecialchars(trim($_REQUEST['zaplata']));
            echo "Sposób zapaty: $zaplata <br />";
        } else echo "Nie używaj konsoli! <br />";
        ?>
    </div>
</body>

</html>