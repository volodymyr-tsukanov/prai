<form action="css.php" method="post">
    <textarea name="tekst"></textarea><br />
    <input type="submit" name="wyslij" value="Wyślij" />
</form>
<div>
    <?php
    if (filter_input(INPUT_POST,'wyslij')) {
        $msg = $_POST['tekst'];
        echo htmlspecialchars($msg) . '<br>';
        echo strip_tags($msg) . '<br>';
        $msg = filter_input(INPUT_POST, 'tekst', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        echo $msg;
    }
    ?>
</div>