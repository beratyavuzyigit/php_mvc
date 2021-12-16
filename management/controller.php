<?php

defined('is_index') or exit("Permission Denied");

class controller
{
    public $test;
    public function __construct()
    {
    }
    public function database($deneme = null)
    {
        global $system_folder;
        /* Define Required File */
        $required_file = $system_folder."/database.php";

        /* Require Control */
        if (file_exists($required_file)) {
            require_once($required_file);
        } else {
            exit('No such file!');
        }

        $db_class = new Database;
        return $db_class->database();
    }
    public function view()
    {
        global $system_folder;

        $required_file = $system_folder . "/view.php";

        /* Require Control */
        if (file_exists($required_file)) {
            require($required_file);
        } else {
            exit('No such file!');
        }

        return new View;
    }
    public function parser(){
        global $system_folder;

        $required_file = $system_folder . "/template_parser.php";

        /* Require Control */
        if (file_exists($required_file)) {
            require($required_file);
        } else {
            exit('No such file!');
        }

        return new Template_Parser;
    }
}
