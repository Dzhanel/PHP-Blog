<?php
    $db_host = "localhost";
    $db_name = "my_blog";
    $db_user = "root";
    $db_pass = "";
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (!$conn) {
        echo "Website is down";
        exit;
    }
    
?>