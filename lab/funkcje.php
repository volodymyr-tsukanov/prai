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
function implodeData($dataArr): string{
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
function arrToSQLValues($dataArr): string{
    $result = '(';
    foreach ($dataArr as $elem) {
        if (is_array($elem)){
            $result .= "'".implode(',',$elem)."'";
        } else {
            $result .= "'$elem'";
        }
        $result .= ',';
    }
    echo '<br>'.$result;
    return substr($result, 0, -1).')';
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
const FILE_TYPE_TXT = 0;
const FILE_TYPE_CSV = 1;
const FILE_TYPE_JSON = 6;
const FILE_TYPE_XML = 11;

function writeToFile(string $path, $data, $mode = FILE_TYPE_TXT){
    
}

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
                if (isset($procLnFunc)) {
                    if(isset($procLnFuncArg))
                        $procLnFunc($procLnFuncArg, $line,$tableFormat);
                    else
                        $procLnFunc($line,$tableFormat);
                } else {
                    printCSVEntry(explode('|',$line),$tableFormat);
                }
            }
        }
        if($tableFormat){
            echo '</tbody></table>';
        }
        fclose($fl);

        if(isset($procLnFunc) && isset($procLnFuncArg)) return $procLnFuncArg;
    } else print('<h3>Nie ma takiego pliku</h3>');
    return null;
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
