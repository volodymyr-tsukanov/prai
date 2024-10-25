<?php
function implodeData(...$dataArr){
    $result = '';
    $sprt = '|';
    foreach ($dataArr as $elem) {
        if (is_array($elem)){
            $result .= implode(',',$elem);
        } else {
            $result .= $elem;
        }
        $result .= $sprt;
    }
    return substr($result, 0, -1);
}
function deplodeData($data, $sprt=' '){
    return str_replace('|',$sprt,$data);
}

// Files
function writeToF($path, $data){
    $printingHead = !file_exists($path);

    $fl = fopen($path,'a');
    if (!$fl){
        echo "<p>Zamówienie nie może zostać przyjęte. Spróbuj później</p>";
        exit;
    }
    if($printingHead) fwrite($fl,"Nazwisko|Wiek|Państwo|Email|Języki|Zapłata\n");
    fwrite($fl,$data."\n");
    fclose($fl);
}
function readFromF($path, $procLnFunc=null,$procLnFuncArg=null){  // == pokaz ze skryptu
    if(file_exists($path)) {
        $fl = fopen($path, 'r');
        $line = fgets($fl); //ignore Head
        while (!feof($fl)) {
            $line = fgets($fl);
            if ($line !== false) {
                if ($procLnFunc) {
                    $procLnFunc($procLnFuncArg, $line);
                } else echo deplodeData($line) . '<br>';
            }
        }
        fclose($fl);
    } else print('<h3>Nie ma takiego pliku</h3>');
}

function showByTut($tut, $line){
    $elems = explode(' ', $line);
    if(strpos($elems[4], $tut) !== false){  // z != nie działa dla tutorialu na 1 miejscu, bo zwraca 0 co jest interpretowane jako false
        echo deplodeData($line).'<br>';
    }
}
?>