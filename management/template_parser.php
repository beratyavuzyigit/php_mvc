<?php

class Template_Parser
{
    public $left_delimiter, $right_delimiter;
    public function __construct()
    {
        global $application_folder;

        /* Define Required File */
        $required_file = $application_folder . "/config/config.php";

        /* Require Control */
        if (file_exists($required_file)) {
            require($required_file);
        } else {
            exit('No such file!');
        }

        $this->left_delimiter = $config["left_delimiter"];
        $this->right_delimiter = $config["right_delimiter"];
    }
    public function send($view_page, array $data = null, $extract_data = true)
    {
        global $application_folder;

        $left_delimiter = $this->left_delimiter;
        $right_delimiter = $this->right_delimiter;

        if ($extract_data) {
            if ($data != null) {
                if (is_array($data)) {
                    extract($data);
                } else {
                    exit("View Data Must be Array Only!");
                }
            }
        }

        /* Define Required File */
        $required_file = BASE_PATH . "\\" . $application_folder . "\\view\\" . $view_page . ".php";


        /* Check File Exists */
        if (!file_exists($required_file)) {
            exit('View File Not Found in Parser Func.');
        }

        $file = fopen($required_file, "r");
        $file_content = fread($file, filesize($required_file));

        // $file_content = str_replace("  ", "", $file_content);

        $file_content = $this->eachParser($data, $file_content);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
            } else {
                $file_content = $this->variableParser($key, $value, $file_content);
            }
        }

        eval("?>" . $file_content . "<?php");
    }

    private function eachParser($data, $file_content)
    {
        $left_delimiter = $this->left_delimiter;
        $right_delimiter = $this->right_delimiter;

        $startFor = '(' . $left_delimiter . 'for (\w)+ in (\w)+' . $right_delimiter . ')';
        $endFor = '(' . $left_delimiter . 'endFor' . $right_delimiter . ')';

        $regex = $startFor . '(?!.*\2)([^\1]*?)' . $endFor;
        $regex = (preg_match_all('/' . $regex . '/s', $file_content, $forArr)) ? $regex : $startFor . '(?!.*\1)([^\1]*?)' . $endFor;
        $regMatch = preg_match_all('/' . $regex . '/s', $file_content, $forArr);

        if ($regMatch) {
            $forArrItem = $forArr[0][0];
            preg_match_all('/' . $startFor . '/', $forArrItem, $foreachCode);

            $content = $forArrItem;

            preg_match('/' . $startFor . '/', $content, $forData);
            $forData = $forData[0];
            $content = preg_replace($startFor, '', $content);
            $content = preg_replace($endFor, '', $content);

            $eachArrVariable = explode(" ", $forData)[1];
            $eachValVariable = trim(trim(explode(" ", $forData)[3], $right_delimiter));

            $value = $data[$eachArrVariable];

            extract($value);




            $newContent = '';
            foreach ($value as $parsedArrayKey => $parsedArrayValue) {
                $newContent .= @str_replace('{{' . $eachValVariable . '}}', $parsedArrayValue, $content);
                $newContent = @str_replace('{{' . $eachValVariable . '.value}}', $parsedArrayValue, $newContent);
                $newContent = @str_replace('{{' . $eachValVariable . '.key}}', $parsedArrayKey, $newContent);
            }

            // echo '<pre>';
            // print_r($newContent);
            // echo '<pre>';

            $result = str_replace($forArrItem, $newContent, $file_content);

            return $this->eachParser($data, $result);
        } else {
            return $file_content;
        }
    }

    private function variableParser($key, $value, $file_content)
    {
        $left_delimiter = $this->left_delimiter;
        $right_delimiter = $this->right_delimiter;

        $search = $left_delimiter . $key . $right_delimiter;
        return str_replace($search, $value, $file_content);
    }
}
