<?php
function writeToF($path, $data){
    $fl = fopen($path,'a');
    if (!$fl){
        echo "<p>Zamówienie nie może zostać przyjęte. Spróbuj później</p>";
        exit;
    }
    fwrite($fl,$data."\n");
    fclose($fl);
}
function readFromF($path, $procLnFunc=null,$procLnFuncArg=null){  // == pokaz ze skryptu
    $fl = fopen($path,'r');
    while (!feof($fl)) {
        $line = fgets($fl);
        if ($line !== false) {
            if($procLnFunc){
                $procLnFunc($procLnFuncArg,$line);
            } else echo $line.'<br>';
        }
    }
    fclose($fl);
}

function showByTut($tut, $line){
    $elems = explode(' ', $line);
    if(strpos($elems[4], $tut) !== false){  // z != nie działa dla tutorialu na 1 miejscu, bo zwraca 0 co jest interpretowane jako false
        echo $line.'<br>';
    }
}
?>