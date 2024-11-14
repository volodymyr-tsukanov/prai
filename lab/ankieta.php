<?php
$dataPath = 'data/ankieta.txt';
$dataSep = ':';
$tech = ["C", "CPP", "Java", "C#", "HTML", "CSS", "XML", "PHP", "JavaScript"];


if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $votes = [];    //init
    foreach ($tech as $language){
        $votes[$language] = 0;
    }

    if (file_exists($dataPath)){    //load
        $existingVotes = file($dataPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($existingVotes as $line) {
            list($language, $count) = explode($dataSep, $line);
            $votes[$language] += (int)$count;
        }
    }

    if (isset($_POST['tech'])){ //vote
        foreach ($_POST['tech'] as $selectedTech) {
            if (array_key_exists($selectedTech, $votes)) {
                $votes[$selectedTech]++;
            }
        }
    }

    $fl = fopen($dataPath, 'w');    //save
    foreach ($votes as $language => $count) {
        fwrite($fl, "$language$dataSep$count\n");
    }
    fclose($fl);

    header('Location: ankieta.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ankieta</title>
</head>
<body>
    <h1>Ankieta - Wybierz Technologie</h1>
    <form action="ankieta.php" method="POST">
        <?php
        foreach ($tech as $technology) {
            echo '<input type="checkbox" name="tech[]" value="' . $technology . '">' . $technology . '<br>';
        }
        ?>
        <input type="submit" value="Zgłoś głos">
    </form>
    <h2>Wyniki Ankiety</h2>

<?php

if (file_exists($dataPath)) {
    $res = file($dataPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($res as $line) {
        echo str_replace($dataSep,' - ',htmlspecialchars($line)) . '<br>';
    }
} else {
    echo "Brak ankiety";
}
?>

</body></html>