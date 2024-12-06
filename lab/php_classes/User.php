<?php
namespace prai_lab;

require_once 'DTBase.php';

use DateTime;
use SimpleXMLElement;


class User {
    const STATUS_USER = 1;
    const STATUS_ADMIN = 2;
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

    protected $userName;
    protected $fullName;
    protected $email;
    protected $passwd;
    protected $date;
    protected $status;
    protected DTBase $db;


    function __construct($userName, $fullName, $email, $passwd, DTBase $db){
        $this->status=User::STATUS_USER;
        $this->userName = $userName;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->passwd = $passwd;
        $this->date = new DateTime('now');
        $this->db = $db;
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
    public function setDB(DTBase $db){
        $this->db = $db;
    }


    static function isXMLReady(): bool {
        return extension_loaded('xml') && class_exists('SimpleXMLElement');
    }


    public function show(){
        printf('User: %s %s %s status=%d %s', $this->userName,$this->fullName,$this->email,$this->status,$this->date->format('Y-m-d H:i:s'));
    }

    public static function getAllUsers(string $file, string $format = self::FORMAT_JSON){
        if (!file_exists($file)){
            echo "<p>File not found</p>";
            return;
        }

        if ($format === self::FORMAT_XML && !self::isXMLReady()) {
            echo "<p>XML support is not enabled in PHP</p>";
            return;
        }

        switch ($format){
            case self::FORMAT_JSON:
                self::displayJsonUsers($file);
                break;
            case self::FORMAT_XML:
                self::displayXmlUsers($file);
                break;
            default:
                echo "<p>Unsupported format</p>";
                break;
        }
    }
    public static function getAllUsersFromDB(){
        print('<h3>All the users</h3>');
        $this->db->select("SELECT userName, fullName, email, status, date FROM users", ["userName", "fullName", "email", "status", "date"]);
    }
    private static function displayJsonUsers(string $file){
        $content = file_get_contents($file);
        if ($content === false){
            echo "<p>Unable to read file</p>";
            return;
        }
        
        $users = json_decode($content);
        if ($users === null){
            echo "<p>Invalid JSON format</p>";
            return;
        }

        foreach ($users as $user){
            echo "<p>" . htmlspecialchars($user->userName) . " " . 
                 htmlspecialchars($user->fullName) . " " . 
                 $user->date . "</p>";
        }
    }
    private static function displayXmlUsers(string $file){
        $allUsers = simplexml_load_file($file);
        if ($allUsers === false) {
            echo "<p>Invalid XML file</p>";
            return;
        }

        echo "<ul>";
        foreach ($allUsers as $user) {
            $userName = htmlspecialchars((string)$user->userName);
            $fullName = htmlspecialchars((string)$user->fullName);
            $email = htmlspecialchars((string)$user->email);
            $date = htmlspecialchars((string)$user->date);
            $status = (int)$user->status;

            echo "<li>$userName, $fullName, $email, $date, Status: $status</li>";
        }
        echo "</ul>";
    }

    public function toArray(): array {
        return [
            "userName" => $this->userName,
            "fullName" => $this->fullName,
            "email" => $this->email,
            "passwd" => $this->passwd,
            "date" => $this->date->format('Y-m-d H:i:s'),
            "status" => $this->status
        ];
    }
    public function toXML(): SimpleXMLElement {
        $userData = $this->toArray();
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><user></user>');
        
        foreach ($userData as $key => $value){
            $xml->addChild($key, htmlspecialchars((string)$value));
        }
        
        return $xml;
    }

    public function save(string $file, string $format = self::FORMAT_JSON): bool {
        switch ($format){
            case self::FORMAT_JSON:
                return $this->saveJson($file);
            case self::FORMAT_XML:
                return $this->saveXml($file);
            default:
                return false;
        }
    }
    protected function saveJson(string $file): bool {
        $data = [];
        
        if (file_exists($file)){
            $content = file_get_contents($file);
            if ($content !== false){
                $data = json_decode($content, true) ?? [];
            }
        }
        
        $data[] = $this->toArray();
        return file_put_contents($file, json_encode($data)) !== false;
    }
    protected function saveXml(string $file): bool {
            // Load existing XML or create new if doesn't exist
        if (file_exists($file)) {
            $xml = simplexml_load_file($file);
            if ($xml === false) {
                // Create new XML structure if file is invalid
                $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><users></users>');
            }
        } else {
            // Create new XML structure if file doesn't exist
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><users></users>');
        }

        // Add new user element
        $userElement = $xml->addChild('user');
        $userElement->addChild('userName', $this->userName);
        $userElement->addChild('fullName', $this->fullName);
        $userElement->addChild('email', $this->email);
        $userElement->addChild('passwd', $this->passwd);
        $userElement->addChild('date', $this->date->format('Y-m-d H:i:s'));
        $userElement->addChild('status', $this->status);

        // Save XML to file
        return $xml->asXML($file) !== false;
    }
    public function saveDB(): bool{
        $dateFormatted = $this->date->format('Y-m-d H:i:s');
        $passwdHash = password_hash($this->passwd,PASSWORD_ARGON2ID);
        return $this->db->insert('`users`(`userName`,`fullName`,`email`,`status`,`date`,`passwd`)', "('$this->userName','$this->fullName','$this->email','$this->status','$dateFormatted','$passwdHash')");
    }
}
?>
