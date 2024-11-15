<?php
namespace prai_lab;

use DateTime;


class User {
    const STATUS_USER = 1;
    const STATUS_ADMIN = 2;

    protected $userName;
    protected $fullName;
    protected $email;
    protected $passwd;
    protected $date;
    protected $status;


    function __construct($userName, $fullName, $email, $passwd){
        $this->status=User::STATUS_USER;
        $this->userName = $userName;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->passwd = $passwd;
        $this->date = new DateTime('now');
    }


    public function getUserName() : string{
        return $this->userName;
    }
    public function setUserName($userName){
        $this->userName = $userName;
    }

    public function getFullName() : string{
        return $this->fullName;
    }
    public function setFullName($fullName){
        $this->fullName = $fullName;
    }

    public function getEmail() : string{
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    public function getPasswd() : string{
        return $this->passwd;
    }
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
    }

    public function getDate(): DateTime{
        return $this->date;
    }
    public function setDate(DateTime $date){
        $this->date = $date;
    }

    public function getStatus(): int{
        return $this->status;
    }
    public function setStatus(int $status){
        $this->status = $status;
    }


    public function show(){
        printf('User: %s %s %s status=%d %s', $this->userName,$this->fullName,$this->email,$this->status,$this->date->format(DateTime::W3C));
    }
}
?>