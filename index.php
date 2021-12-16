<?php


/* Define Index Page */
define("is_index", true);

/* Define Base Path */
define("BASE_PATH", dirname(__FILE__));


/* Define System Folder */
$system_folder = "management";

/* Define Application Folder */
$application_folder = "application";

require_once($system_folder . "/loader.php");

$default_controller = $config['controller_class'];
$index_function = $config['index_name'];
$default_page = $config["default_page"];

/* Load URI Class */
$uri = new URI;
$url = $uri->url_path();

/*

    Routes

*/

$router_class = new router;
$routed_url = $router_class->route($url);




$extend_controller = $default_controller;
$page = $default_page;
if ($routed_url) {
    $get_controller_url = $uri->part(0, $routed_url);

    $get_page_url = $uri->part(1, $routed_url);
    if ($get_controller_url != null) {
        $extend_controller = $get_controller_url;
    }
    if ($get_page_url != null) {
        $page = $get_page_url;
    }
} else {
    $get_controller_url = $uri->part(0);
    $get_page_url = $uri->part(1);
    if ($get_controller_url != null) {
        $extend_controller = $get_controller_url;
    }
    if ($get_page_url != null) {
        $page = $get_page_url;
    }
}



$controller_file = $application_folder . "/controller/" . $extend_controller . ".php";
if (file_exists($controller_file)) {
    require_once($controller_file);
    if (class_exists($extend_controller)) {
        $controller = new $extend_controller;
        if (method_exists($extend_controller, $page)) {
            $controller->$page();
        }
    }
}


function require_file($required_file)
{
    if (file_exists($required_file)) {
        require($required_file);
    } else {
        exit('No such file!');
    }
}
