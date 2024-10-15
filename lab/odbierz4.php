<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Form receiver</title>
</head>

<body>
    <div>
        <?php
        $nazw = isset($_REQUEST['nazw']) ? $_REQUEST['nazw'] : null;
        $wiek = isset($_REQUEST['wiek']) ? $_REQUEST['wiek'] : null;
        $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
        $kraj = isset($_REQUEST['kraj']) ? $_REQUEST['kraj'] : null;

        $zamowioneProdukty = isset($_REQUEST['jezyki']) ? $_REQUEST['jezyki'] : [];
        $platnosc = isset($_REQUEST['zaplata']) ? $_REQUEST['zaplata'] : null;

        if ($nazw && $wiek && $email && $kraj) {
            echo "<h2>Dane z formularza</h2>";
            if (!empty($zamowioneProdukty)) {
                print('Wybrano tutorials:');
                foreach ($zamowioneProdukty as $produkt) {
                    echo " $produkt";
                }
            } else {
                echo "Nie zamówiono żadnych produktów.<br>";
            }

            echo "<br>Sposób zapłaty: $platnosc";

            echo "<a href='klient.php?nazw=$nazw&wiek=$wiek&email=$email&kraj=$kraj'> <h4>Dane klienta</h4> </a>";
        } else {
            echo "<h3>Brak danych. Uzupełnij formularz ponownie.</h3>";
        }
        ?>

    </div>
</body>

</html>