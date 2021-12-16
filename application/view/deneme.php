<?php

defined("is_index") or exit("Permission Denied");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>

<body>


    <ul>
        {{for deneme in deger}}
            {{deger.key}} => {{deger}} <br>
        {{endFor}}
    </ul>



</body>

</html>