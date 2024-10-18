<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lab1</title>
        <?php
        function arr_export(mixed $arr): string {
            return count($arr)." element ".var_export($arr,true);
        }
        ?>
    </head>
    <body>
        <?php
        $i=1234;
        $d=567.789;
        $b1=1;
        $b2=0;
        $b=true;
        $si="0";
        $s="Typy w PHP";
        $a=[1, 2, 3, 4];
        $ae=[];
        $as=["zielony", "czerwony", "niebieski"];
        $ap=["Agata", "Agatowska", 4.67, true];
        $dt = new DateTime();
        print($i.'<br>'.$d.'<br>'.$b1.'<br>'.$b2.'<br>'.$b.'<br>'.$si.'<br>'.$s.'<br>'.(arr_export($a)).'<br>'.(arr_export($ae)).'<br>'.(arr_export($as))."<br".(arr_export($ap)));
        echo('<br><br>');
        echo('czy i=1234 to Object: '.is_object($i).'<br>');
        echo('czy b1=1 to Bool: '.is_bool($b1).'<br>');
        echo('czy b2=0 to Bool: '.is_bool($b2).'<br>');
        echo('czy si="0" to Bool: '.is_bool($si).'<br>');
        echo('czy si="0" to Int: '.is_int($si).'<br>');
        echo('czy si="0" to Numeric: '.is_numeric($si).'<br>');
        echo('czy si="0" to String: '.is_string($si).'<br>');
        echo('czy ae to Array: '.is_array($ae).'<br>');
        echo('czy ap to Array: '.is_array($ap).'<br>');
        echo('czy ap to Object: '.is_object($ap).'<br>');
        echo('czy dt to Object: '.is_object($dt).'<br>');
        echo('czy d to NaN: '.is_nan($d).'<br>');
        echo('<br><br>');
        echo('czy 1 == true: '.($b1==$b).'<br>');
        echo('czy 1 === true: '.($b1===$b).'<br>');
        echo('czy 0 == "0": '.($b2==$si).'<br>');
        echo('czy 0 === "0": '.($b2===$si).'<br>');
        echo('<br><br>');
        var_dump($ap);
        echo('<br>');
        print_r($a)
        ?>
    </body>
</html>
