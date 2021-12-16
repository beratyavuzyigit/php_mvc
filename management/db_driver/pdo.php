<?php

defined('is_index') or exit("Permission Denied");

class DB_Driver
{
    private $hostname, $db_name, $username, $password;
    private $db_port = "3306";
    public function __construct()
    {
        /* Get App Folder Name */
        global $application_folder;

        /* Define Required File */
        $required_file = $application_folder . "/config/database.php";

        /* Require Control */
        if (file_exists($required_file)) {
            require($required_file);
        } else {
            exit('No such file!');
        }

        /* Get and Define DB Variables From the DB Config File */
        $this->hostname = $database["hostname"];
        $this->db_name = $database["db_name"];
        $this->username = $database["username"];
        $this->password = $database["password"];
        if (isset($database["db_port"])) {
            $this->db_port = $database["db_port"];
        };
        
    }
    public function database()
    {
        /* Get and Define DB Variables From $this Class */
        $hostname = $this->hostname;
        $db_name = $this->db_name;
        $username = $this->username;
        $password = $this->password;
        $db_port = $this->db_port;

        /* Try Connecting to DB */
        try {
            $conn = new PDO("mysql:host=$hostname;dbname=$db_name;port=$db_port;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Bağlantı hatası" . $e->getMessage();
        }
    }
}
