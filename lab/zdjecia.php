<?php
include_once "funkcje.php";


$imgPath = './data/img/';
$thumbPath = './data/tnls/';  //thumbnails


setDebugMode(1);
printHTMLhead('Img thumbs');

if (isset($_POST['zapisz']) && $_POST['zapisz'] == 'Zapisz' && !isset($_GET['pic'])){
    if (is_uploaded_file($_FILES['zdjecie']['tmp_name'])) {
        $typ = $_FILES['zdjecie']['type'];
        if ($typ === 'image/jpeg') {
            $imgId = uniqid(); //wygenerowanie losowej wartości
            $iPath = $imgPath . 'img_' . $imgId . '.jpg';
            $tPath = $thumbPath . 'thn_' . $imgId . '.jpg';
            move_uploaded_file($_FILES['zdjecie']['tmp_name'], $iPath);

            list($width, $height) = getimagesize($iPath); //pobranie rozmiarów obrazu
            $wys = $_POST['wys']; //wysokość preferowana przez użytkownika
            $szer = $_POST['szer']; //szerokość preferowana przez użytkownika
            $skalaWys = 1;
            $skalaSzer = 1;
            $skala = 1;
            if ($width > $szer) $skalaSzer = $szer / $width;
            if ($height > $wys) $skalaWys = $wys / $height;
            if ($skalaWys <= $skalaSzer) $skala = $skalaWys;
            else $skala = $skalaSzer;
            //ustalenie rozmiarów miniaturki tworzonego zdjęcia:
            $newH = $height * $skala;
            $newW = $width * $skala;

            header('Content-Type: image/jpeg');
            $nowe = imagecreatetruecolor($newW, $newH); //czarny obraz
            $obraz = imagecreatefromjpeg($iPath);
            imagecopyresampled($nowe, $obraz, 0, 0, 0, 0, $newW, $newH, $width, $height);
            imagejpeg($nowe, $tPath, 100);
            echo "Miniatura utworzona: <a href='$tPath'>Zobacz miniaturę</a><br>";
            imagedestroy($nowe);
            imagedestroy($obraz);

            header('location:zdjecia.php?pic='.$imgId);
            exit;
        } else {
            header('location:zdjecia.html');
            exit;
        }
    }
}

if (isset($_GET['pic']) && !empty($_GET['pic'])){
    echo '<a href="' . $imgPath.'img_'. htmlspecialchars($_GET['pic']) . '.jpg">Zdjęcie</a><br>';
    echo '<a href="' . $thumbPath.'thn_' . htmlspecialchars($_GET['pic']) . '.jpg">Miniatura</a><br><br>';
    echo '<a href="zdjecia.html">Powrót</a>';
}
echo"<br>";

printHTMLtail();

// /etc/php/8.3/cli/php.ini <(line 943)- extension=gd
?>