<?php
function setDebugMode($mode){
    if($mode == 1){
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    } else {
        error_reporting(0);
        ini_set('display_errors', 0);
    }
}


// HTML
function printHTMLhead($title,$useStyle=false){
    $stl = '';
    if($useStyle) $stl = '<link rel="stylesheet" href="style/style.css"/>';

    header('Content-Type: text/html');
    print("<!DOCTYPE html>
<html lang='pl'>
<head>
    <meta charset='UTF-8'>
    <title>$title</title>
    $stl
</head><body>");
}
function printHTMLtail(){
    print("</body></html>");
}


// Data format
function implodeData($dataArr){
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

function printCSVEntry($entry, $tableFormat=false){
    if(!is_array($entry)) $entry = explode('|',$entry);
    if($tableFormat){
        echo '<tr>';
        foreach($entry as $elem){
            print("<td>$elem</td>");
        }
        echo '</tr>';
    } else {
        foreach($entry as $elem){
            print("$elem  ");
        }
        echo '<br>';
    }
}


// Files
function writeToCSV($path, $data, $head=null){
    $printingHead = !file_exists($path) && isset($head);

    $fl = fopen($path,'a');
    if (!$fl){
        echo "<p>Zamówienie nie może zostać przyjęte. Spróbuj później</p>";
        exit;
    }
    if($printingHead) fwrite($fl, $head."\n");
    fwrite($fl, $data."\n");
    fclose($fl);
}
function readFromCSV($path, $tableFormat=false, $procLnFunc=null,$procLnFuncArg=null){  // == pokaz ze skryptu
    if(file_exists($path)) {
        $fl = fopen($path, 'r');
        $line = fgets($fl); //read Head
        if($tableFormat){
            echo '<table border="1" cellpadding="10"><thead><tr>';
            foreach(explode('|',$line) as $headTitle){
                print("<th>$headTitle</th>");
            }
            echo '</tr></thead><tbody>';
        }
        while (!feof($fl)) {
            $line = fgets($fl);
            if ($line !== false) {
                if (isset($procLnFunc) && isset($procLnFuncArg)) {
                    $procLnFunc($procLnFuncArg, $line,$tableFormat);
                } else {
                    printCSVEntry(explode('|',$line),$tableFormat);
                }
            }
        }
        if($tableFormat){
            echo '</tbody></table>';
        }
        fclose($fl);
    } else print('<h3>Nie ma takiego pliku</h3>');
}


function showByTut($tut, $line, $tableFormat=false){
    $elems = explode('|', trim($line));
    foreach(explode(',',$elems[5]) as $t){
        if($t == $tut){
            printCSVEntry($elems,$tableFormat);
            break;
        }
    }
}
?>
