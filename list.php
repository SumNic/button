<?php

$mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'button');
$result = $mysql->query("SELECT max id as max_id FROM `hello world4.xlsx`");
        $user = $result->fetch_array(MYSQLI_ASSOC);
        echo $user['max_id'];
        $mysql->close();

        
        