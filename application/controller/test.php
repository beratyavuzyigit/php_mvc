<?php

defined('is_index') or exit("Permission Denied");

class test extends controller
{
    public function index()
    {

        $array2 = array(
            "deneme" => array(
                "test" => 'sss',
                "test2" => 'sss',
            ),
            "deneme2" => "2423",
        );
        $array2["test"] = "deneme";

        $start = microtime(true);

        $this->parser()->send("deneme", $array2, true);

        $end = microtime(true);
        $creationtime = ($end - $start);
        printf("Bu sayfa %.6f saniyede işlendi.", $creationtime);
        // $this->view()->send("deneme", $array2);
    }

    public function index2()
    {
        $db = $this->database();
        $query = $db->prepare("SELECT * FROM mvc_test_table");
        $query->execute();
        $query = $query->fetchAll(PDO::FETCH_OBJ);
        echo "<pre>";
        print_r($query);
        echo "</pre>";
    }
}
