<?php

class View{
    public function send($view_page, array $data = null){
        if ($data != null) {
            if (is_array($data)) {
                extract($data);
            }else {
                exit("View Data Must be Array Only!");
            }
        }
        $view_page = str_replace(".php", "", $view_page);

        /* Get Application Folder Name */
        global $application_folder;

        /* Define Required File */
        $required_file = $application_folder . "/config/config.php";

        /* Require Control */
        if (file_exists($required_file)) {
            require($required_file);
        } else {
            exit('No such file!');
        }

        /* Define Required File */
        $required_file = $application_folder . "/view/" . $view_page . ".php";


        /* Require Control */
        if (file_exists($required_file)) {
            if ($config["view_limit"]) {
                include_once($required_file);
            } else {
                include($required_file);
            }
        } else {
            exit('No such file!');
        }
    }
}