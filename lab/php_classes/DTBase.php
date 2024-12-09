<?php
namespace prai_lab;

use stdClass;
use mysqli;


class DTBase
{
    private const PARAMS = ['server'=>'localhost','user'=>'root','pass'=>''];

    private $mysqli; //uchwyt do BD


    public function __construct($serwer, $user, $pass, $baza) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
        /* sprawdz połączenie */
        if ($this->mysqli->connect_errno) {
            $this->mysqli = new mysqli(self::PARAMS['server'],self::PARAMS['user'],self::PARAMS['pass'], $baza);   //try with default params
            if ($this->mysqli->connect_errno){
                printf("Nie udało sie połączenie z serwerem: %s\n", $this->mysqli->connect_error);
                exit();
            }
        }
        /* zmien kodowanie na utf8 */
        if ($this->mysqli->set_charset("utf8")) {
            //udało sie zmienić kodowanie
        }
    }
    function __destruct(){
        //debug_print_backtrace();
        if(isset($this->mysqli)){
            $this->mysqli->close();
            unset($this->mysqli);
        }
    }


    public function getMysqli() {
        return $this->mysqli;
    }


    public function insert(string $table, string $values): bool{
        return $this->mysqli->query("INSERT INTO $table VALUES ($values)");
    }

    public function delete(string $table, string $where): bool{
        return $this->mysqli->query("DELETE FROM $table WHERE $where");
    }
    public function deleteById(string $table, int $id): bool{
        return $this->delete($table, "userId=$id");
    }
    public function deleteByUsername(string $table, $userName): bool{
        return $this->delete($table, "userName='$userName'");
    }
    public function deleteByEmail(string $table, $email): bool{
        return $this->delete($table, "email='$email'");
    }

    public function select(string $table, string $what, string $where): stdClass|null{
        $response = $this->mysqli->query("SELECT $what FROM $table WHERE $where");
        $res = null;
        if($response->num_rows > 0){
            $res = $response->fetch_object();
        }
        $response->close();
        return $res;
    }
    public function selectUser(string $userName, string $passwd): stdClass|null{
        $passHash = hash('sha256',$passwd);
        return $this->select('users','id,userName,fullName,email,date',"userName='$userName' AND passwd='$passHash'");
    }
    public function selectUserById(int $userId): stdClass|null{
        return $this->select('users','userName,fullName,email,passwd,date',"id=$userId");
    }
    public function selectAll($sql, $pola) {
        //parametr $sql – łańcuch zapytania select
        //parametr $pola - tablica z nazwami pol w bazie
        //Wynik funkcji – kod HTML tabeli z rekordami (String)
        $tresc = "";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows > 0) {
            $ilepol = count($pola); //ile pól
            // pętla po wyniku zapytania $results
            $tresc.="<table><tbody>";
            while ($row = $result->fetch_object()) {
                $tresc.="<tr>";
                for ($i = 0; $i < $ilepol; $i++) {
                    $p = $pola[$i];
                    $tresc.="<td>" . $row->$p . "</td>";
                }
                $tresc.="</tr>";
            }
            $tresc.="</tbody></table>";
            $result->close(); // zwolnij pamięć
        }
        return $tresc;
    }
}
?>
