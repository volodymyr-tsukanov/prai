<?php
namespace prai_lab;

use mysqli;


class DTBase
{
    private $mysqli; //uchwyt do BD


    public function __construct($serwer, $user, $pass, $baza) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
        /* sprawdz połączenie */
        if ($this->mysqli->connect_errno) {
            printf("Nie udało sie połączenie z serwerem: %s\n",
                $mysqli->connect_error);
            exit();
        }
        /* zmien kodowanie na utf8 */
        if ($this->mysqli->set_charset("utf8")) {
            //udało sie zmienić kodowanie
        }
    }
    function __destruct() {
        $this->mysqli->close();
    }


    public function getMysqli() {
        return $this->mysqli;
    }


    public function insert(string $table, string $values): bool{
        return $this->mysqli->query("INSERT INTO $table VALUES $values");
    }

    protected function delete(string $table, string $where): bool{
        return $this->mysqli->query("DELETE FROM $table WHERE $where");
    }
    public function deleteById(string $table, $id): bool{
        return $this->delete($table, "id=$id");
    }
    public function deleteByUsername(string $table, $userName): bool{
        return $this->delete($table, "userName='$userName'");
    }
    public function deleteByEmail(string $table, $email): bool{
        return $this->delete($table, "email='$email'");
    }

    public function selectUser(string $table, string $userName, string $passwd): int{
        $passwdHash = password_hash($passwd,PASSWORD_ARGON2I);
        $response = $this->mysqli->query("SELECT * FROM $table WHERE userName='$userName' AND passwd='$passwdHash'");
        $res = $response->fetch_object();
        echo $res->userName;
        $response->close();
        return -1;
    }
    public function selectAll($sql, $pola) {
        //parametr $sql – łańcuch zapytania select
        //parametr $pola - tablica z nazwami pol w bazie
        //Wynik funkcji – kod HTML tabeli z rekordami (String)
        $tresc = "";
        if ($result = $this->mysqli->query($sql)) {
            $ilepol = count($pola); //ile pól
            $ile = $result->num_rows; //ile wierszy
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