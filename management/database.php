<?php

defined('is_index') or exit("Permission Denied");

class Database
{
    private $db_driver;

    public function __construct()
    {
        /* Get App Folder Name */
        global $application_folder;

        /* Define Required File */
        $required_file = $application_folder . "/config/database.php";

        /* Require Control */
        if (file_exists($required_file)) {
            require_once($required_file);
        } else {
            exit('No such file!');
        }

        /* Get and Define DB_Driver From the DB Config File */
        $this->db_driver = $database["db_driver"];
    }
    public function database()
    {
        /* Get System Folder Name */
        global $system_folder;

        /* Get and Define DB_Driver From $this Class */
        $db_driver = $this->db_driver;

        /* Define Required File */
        $required_file = $system_folder . "/db_driver/" . $db_driver . ".php";

        /* Require Control */
        if (file_exists($required_file)) {
            require_once($required_file);
        } else {
            exit('No such file!');
        }

        /* Call to DB_Driver */
        $db_driver = new DB_Driver;
        return $db_driver->database();
    }
}
