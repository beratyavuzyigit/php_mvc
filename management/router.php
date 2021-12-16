<?php

class router
{
    private $routes;
    public function __construct()
    {
        global $routes;
        $this->routes = $routes;
    }
    public function route($url)
    {
        $routes = $this->routes;
        foreach ($routes as $key => $value) {
            $rule = $this->create_rule($key);
            if ($this->route_control($url, $rule)) {
                $replaced = $value;
                return $this->replace_str($rule, $replaced, $url);
            }
        }
    }

    private function create_rule($rule)
    {
        $rules = array(
            "(:all)" => "(.+)",
            "(:numeric)" => "(\d+)",
            "(:string)" => "([a-zA-Z]+)",
        );
        foreach ($rules as $key => $value) {
            $rule = str_replace($key, $value, $rule);
        }
        $rule = str_replace("/", "\/", $rule);

        return $rule;
    }

    private function route_control($data, $rule)
    {
        $pattern = "/" . $rule . "$/";
        if (preg_match_all($pattern, $data)) {
            return true;
        }
    }

    private function replace_str($rule, $target, $deger)
    {
        $pattern = "/" . $rule . "$/";
        return preg_replace($pattern, $target, $deger);
    }
}
