<?php

defined('is_index') or exit("Permission Denied");

class test extends controller
{
    public function index()
    {
        $this->database();
    }
}
