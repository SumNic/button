<?php
$foul_id = filter_var(trim($_REQUEST["file"]), FILTER_SANITIZE_STRING); 
$mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'u1870963_default');
    $result1 = $mysql->query("SELECT * FROM `cantry` WHERE `country` = '$q'");
    $user1 = $result1->fetch_assoc(); // Конвертируем в массив

    echo '<option value="'.$user1['region'].'">';
    echo $user1['region'];
    $x = $user1['id'];

?>
