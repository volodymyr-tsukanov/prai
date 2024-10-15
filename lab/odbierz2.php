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
        foreach ($_REQUEST as $key => $value) {
            echo "$key = $value <br />";
        }

        echo "<h3>GET:</h3>";
        var_dump($_GET);
        echo "<h3>POST:</h3>";
        var_dump($_POST);
        echo "<h3>REQUEST:</h3>";
        var_dump($_REQUEST);
        ?>
    </div>
</body>
</html>