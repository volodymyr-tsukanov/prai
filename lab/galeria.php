<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Galeria</title>
        <link rel="stylesheet" href='style/style.css'/>
        <?php
        function printImg($name,$class){
            print("<img src='assets/img/$name' alt='$name' class='$class' />" );
        }
        function galery($rows,$cols){
            $index=1;
            echo "<div id='galery'>";
            for ($i = 0; $i < $rows; $i++) {
                echo "<div class='flex-row-1'>";
                for($j = 0; $j < $cols; $j++){
                    printImg("obraz$index.JPG", "flex-col-$cols");
                    $index++;
                }
                echo '</div>';
            }
            echo '</div>';
        }
        function galeria($rows,$cols){
            galery($rows,$cols);
        }
        ?>
    </head>
    <body>
        <?php
        echo '<h2>Galeria zdjęć</h2>';
        galery(2,4);
        ?>
    </body>
</html>
