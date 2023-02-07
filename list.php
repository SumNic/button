<?php
$x = filter_var(trim($_REQUEST["x"]), FILTER_SANITIZE_STRING); 
$mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'u1870963_default');
$result = $mysql->query("SHOW TABLES FROM u1870963_default LIKE 'uploads'");
    $user = $result->fetch_assoc();
    if (!empty($user)) {
        $mysql->close();
        $mysql = new mysqli('localhost', 'u1870963_default', '93HgEE7or1RrVHow', 'u1870963_default');
        $result = $mysql->query("SELECT * FROM `uploads`");
        echo "<ol>";
        while ($user = $result->fetch_assoc()){
            echo "<li>".$user['file']."</li>";
        }
        echo "</ol>";
    } else {
        echo "Файлы пока не загружены";
    }
$mysql->close();
?>
