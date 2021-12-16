<?php

defined('is_index') or exit("Permission Denied");

class URI
{
    protected $url, $base_url;
    public function __construct()
    {
        global $config;
        $this->base_url = $config['base_url'];
        $this->url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
    public function url()
    {
        return $this->url;
    }
    public function url_path()
    {
        $base_url = $this->base_url;
        $url = $this->url;
        $url = str_replace($base_url, "", $url);
        return $url;
    }
    public function part($part_number = 0, $routed_url = null)
    {
        if (!isset($routed_url)) {
            $url = $this->url;
        } else {
            $url = $routed_url;
        }
        $part_result = $this->part_func($url, $part_number);
        return $part_result;
    }

    private function part_func($url, $part_number)
    {
        $base_url = $this->base_url;

        $url = str_replace($base_url, "", $url);

        $url = trim($url, "/");
        $part_array = explode("/", $url);

        $part_length = count($part_array) - 1;
        if ($part_number < 0) {
            $part_number += $part_length + 1;
            if ($part_number < 0) {
                $part_number = 0;
            }
        }

        return isset($part_array[$part_number]) ? $part_array[$part_number] : "";
    }
}
